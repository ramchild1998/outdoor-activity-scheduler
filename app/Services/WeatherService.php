<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
use Carbon\Carbon;

class WeatherService
{
    private $baseUrl;
    private $timeout;

    public function __construct()
    {
        $this->baseUrl = env('BMKG_API_BASE_URL', 'https://data.bmkg.go.id/DataMKG/MEWS/DigitalForecast/');
        $this->timeout = 30;
    }

    /**
     * Get weather forecast for a specific location
     */
    public function getForecast($provinceId, $days = 3)
    {
        try {
            $url = $this->baseUrl . "DigitalForecast-{$provinceId}.xml";
            
            $response = Http::timeout($this->timeout)->get($url);
            
            if ($response->successful()) {
                return $this->parseWeatherXML($response->body(), $days);
            }
            
            Log::error('BMKG API request failed', [
                'url' => $url,
                'status' => $response->status(),
                'response' => $response->body()
            ]);
            
            return $this->getMockWeatherData($days);
            
        } catch (\Exception $e) {
            Log::error('Weather service error: ' . $e->getMessage());
            return $this->getMockWeatherData($days);
        }
    }

    /**
     * Parse XML weather data from BMKG
     */
    private function parseWeatherXML($xmlContent, $days)
    {
        try {
            $xml = simplexml_load_string($xmlContent);
            $forecasts = [];
            
            if ($xml && isset($xml->forecast->area)) {
                foreach ($xml->forecast->area as $area) {
                    $areaName = (string) $area['description'];
                    
                    $areaForecasts = [];
                    foreach ($area->parameter as $parameter) {
                        $paramName = (string) $parameter['id'];
                        
                        if (in_array($paramName, ['weather', 't', 'hu'])) {
                            foreach ($parameter->timerange as $timerange) {
                                $datetime = (string) $timerange['datetime'];
                                $value = (string) $timerange->value;
                                
                                if (!isset($areaForecasts[$datetime])) {
                                    $areaForecasts[$datetime] = [
                                        'datetime' => $datetime,
                                        'date' => Carbon::parse($datetime)->format('Y-m-d'),
                                        'time' => Carbon::parse($datetime)->format('H:i'),
                                    ];
                                }
                                
                                $areaForecasts[$datetime][$paramName] = $value;
                            }
                        }
                    }
                    
                    $forecasts[$areaName] = array_values($areaForecasts);
                }
            }
            
            return $forecasts;
            
        } catch (\Exception $e) {
            Log::error('XML parsing error: ' . $e->getMessage());
            return $this->getMockWeatherData($days);
        }
    }

    /**
     * Get weather suggestions for optimal time slots
     */
    public function getSuggestions($location, $date, $provinceId = '31')
    {
        $forecast = $this->getForecast($provinceId, 3);
        $suggestions = [];
        
        $targetDate = Carbon::parse($date)->format('Y-m-d');
        
        // Find matching location or use first available
        $locationData = null;
        foreach ($forecast as $areaName => $areaData) {
            if (stripos($areaName, $location) !== false || stripos($location, $areaName) !== false) {
                $locationData = $areaData;
                break;
            }
        }
        
        if (!$locationData && !empty($forecast)) {
            $locationData = reset($forecast);
        }
        
        if ($locationData) {
            foreach ($locationData as $timeSlot) {
                if ($timeSlot['date'] === $targetDate) {
                    $weather = $timeSlot['weather'] ?? 'unknown';
                    $temperature = $timeSlot['t'] ?? 'N/A';
                    $humidity = $timeSlot['hu'] ?? 'N/A';
                    
                    $isOptimal = $this->isOptimalWeather($weather);
                    
                    $suggestions[] = [
                        'datetime' => $timeSlot['datetime'],
                        'time' => $timeSlot['time'],
                        'weather' => $this->getWeatherDescription($weather),
                        'weather_code' => $weather,
                        'temperature' => $temperature,
                        'humidity' => $humidity,
                        'is_optimal' => $isOptimal,
                        'recommendation' => $isOptimal ? 'Recommended' : 'Not recommended'
                    ];
                }
            }
        }
        
        // Sort by optimal conditions first
        usort($suggestions, function($a, $b) {
            return $b['is_optimal'] <=> $a['is_optimal'];
        });
        
        return $suggestions;
    }

    /**
     * Check if weather condition is optimal for outdoor activities
     */
    private function isOptimalWeather($weatherCode)
    {
        // BMKG weather codes for optimal conditions (clear, partly cloudy)
        $optimalCodes = ['0', '1', '2', '3', '100', '101', '102', '103'];
        
        return in_array($weatherCode, $optimalCodes);
    }

    /**
     * Get weather description from code
     */
    private function getWeatherDescription($code)
    {
        $descriptions = [
            '0' => 'Clear',
            '1' => 'Partly Cloudy',
            '2' => 'Cloudy',
            '3' => 'Overcast',
            '4' => 'Haze',
            '5' => 'Mist',
            '10' => 'Smoke',
            '45' => 'Fog',
            '60' => 'Light Rain',
            '61' => 'Rain',
            '63' => 'Heavy Rain',
            '80' => 'Light Shower',
            '95' => 'Thunderstorm',
            '97' => 'Heavy Thunderstorm'
        ];
        
        return $descriptions[$code] ?? 'Unknown';
    }

    /**
     * Get mock weather data for testing/fallback
     */
    private function getMockWeatherData($days = 3)
    {
        $mockData = [];
        $baseDate = Carbon::now();
        
        $mockData['Jakarta'] = [];
        
        for ($day = 0; $day < $days; $day++) {
            $currentDate = $baseDate->copy()->addDays($day);
            
            // Generate 4 time slots per day (6AM, 12PM, 6PM, 12AM)
            $timeSlots = ['06:00', '12:00', '18:00', '00:00'];
            
            foreach ($timeSlots as $time) {
                $datetime = $currentDate->format('Y-m-d') . ' ' . $time;
                $weatherCodes = ['0', '1', '2', '60', '61']; // Mix of good and bad weather
                $randomWeather = $weatherCodes[array_rand($weatherCodes)];
                
                $mockData['Jakarta'][] = [
                    'datetime' => $datetime,
                    'date' => $currentDate->format('Y-m-d'),
                    'time' => $time,
                    'weather' => $randomWeather,
                    't' => rand(24, 32), // Temperature 24-32°C
                    'hu' => rand(60, 85)  // Humidity 60-85%
                ];
            }
        }
        
        return $mockData;
    }

    /**
     * Get available provinces/locations
     */
    public function getAvailableLocations()
    {
        return [
            '31' => 'DKI Jakarta',
            '32' => 'Jawa Barat',
            '33' => 'Jawa Tengah',
            '34' => 'DI Yogyakarta',
            '35' => 'Jawa Timur',
            '36' => 'Banten',
            '51' => 'Bali',
            '52' => 'Nusa Tenggara Barat',
            '53' => 'Nusa Tenggara Timur',
            '61' => 'Kalimantan Barat',
            '62' => 'Kalimantan Tengah',
            '63' => 'Kalimantan Selatan',
            '64' => 'Kalimantan Timur',
            '65' => 'Kalimantan Utara',
            '71' => 'Sulawesi Utara',
            '72' => 'Sulawesi Tengah',
            '73' => 'Sulawesi Selatan',
            '74' => 'Sulawesi Tenggara',
            '75' => 'Gorontalo',
            '76' => 'Sulawesi Barat',
            '81' => 'Maluku',
            '82' => 'Maluku Utara',
            '91' => 'Papua Barat',
            '94' => 'Papua',
            '11' => 'Aceh',
            '12' => 'Sumatera Utara',
            '13' => 'Sumatera Barat',
            '14' => 'Riau',
            '15' => 'Jambi',
            '16' => 'Sumatera Selatan',
            '17' => 'Bengkulu',
            '18' => 'Lampung',
            '19' => 'Kepulauan Bangka Belitung',
            '21' => 'Kepulauan Riau'
        ];
    }
}