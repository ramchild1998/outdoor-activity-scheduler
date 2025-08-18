# API Documentation

## Overview

The Outdoor Activity Scheduler provides a RESTful API for managing outdoor activities and retrieving weather information. All API endpoints return JSON responses and follow standard HTTP status codes.

## Base URL

```
http://localhost:8000/api
```

## Authentication

Currently, the API does not require authentication for basic operations. Future versions may include API key authentication.

## Response Format

All API responses follow this standard format:

```json
{
    "success": true|false,
    "message": "Response message",
    "data": {}, // Response data
    "errors": {} // Validation errors (if any)
}
```

## HTTP Status Codes

- `200` - OK: Request successful
- `201` - Created: Resource created successfully
- `400` - Bad Request: Invalid request data
- `404` - Not Found: Resource not found
- `422` - Unprocessable Entity: Validation errors
- `500` - Internal Server Error: Server error

## Activities API

### List Activities

Get a paginated list of all activities with optional filtering.

**Endpoint:** `GET /api/activities`

**Parameters:**
- `date` (optional): Filter by preferred date (YYYY-MM-DD)
- `status` (optional): Filter by status (pending, scheduled, completed, cancelled)
- `location` (optional): Filter by location (partial match)
- `per_page` (optional): Number of items per page (default: 15)

**Example Request:**
```bash
curl "http://localhost:8000/api/activities?status=pending&per_page=10"
```

**Example Response:**
```json
{
    "success": true,
    "data": [
        {
            "id": 1,
            "name": "Field Survey",
            "location": "DKI Jakarta",
            "sub_district": "Menteng",
            "village": "Menteng Dalam",
            "preferred_date": "2024-01-15",
            "selected_time_slot": "2024-01-15 09:00:00",
            "weather_condition": "Clear",
            "status": "scheduled",
            "notes": "Equipment inspection",
            "created_at": "2024-01-10T10:00:00.000000Z",
            "updated_at": "2024-01-10T10:00:00.000000Z"
        }
    ],
    "pagination": {
        "current_page": 1,
        "last_page": 1,
        "per_page": 15,
        "total": 1,
        "from": 1,
        "to": 1
    }
}
```

### Create Activity

Create a new outdoor activity.

**Endpoint:** `POST /api/activities`

**Required Parameters:**
- `name`: Activity name (string, max 255 characters)
- `location`: Location/Province (string, max 255 characters)
- `preferred_date`: Preferred date (date, format: YYYY-MM-DD, must be today or future)

**Optional Parameters:**
- `sub_district`: Sub-district (string, max 255 characters)
- `village`: Village/Area (string, max 255 characters)
- `selected_time_slot`: Selected time slot (datetime, format: YYYY-MM-DD HH:MM)
- `notes`: Additional notes (text)

**Example Request:**
```bash
curl -X POST http://localhost:8000/api/activities \
  -H "Content-Type: application/json" \
  -d '{
    "name": "Maintenance Check",
    "location": "DKI Jakarta",
    "sub_district": "Kebayoran",
    "village": "Senayan",
    "preferred_date": "2024-01-20",
    "notes": "Monthly equipment maintenance"
  }'
```

**Example Response:**
```json
{
    "success": true,
    "message": "Activity created successfully",
    "data": {
        "id": 2,
        "name": "Maintenance Check",
        "location": "DKI Jakarta",
        "sub_district": "Kebayoran",
        "village": "Senayan",
        "preferred_date": "2024-01-20",
        "selected_time_slot": null,
        "weather_condition": null,
        "status": "pending",
        "notes": "Monthly equipment maintenance",
        "created_at": "2024-01-10T11:00:00.000000Z",
        "updated_at": "2024-01-10T11:00:00.000000Z"
    },
    "weather_suggestions": [
        {
            "datetime": "2024-01-20 06:00:00",
            "time": "06:00",
            "weather": "Clear",
            "weather_code": "0",
            "temperature": "26",
            "humidity": "75",
            "is_optimal": true,
            "recommendation": "Recommended"
        }
    ]
}
```

### Get Activity Details

Retrieve details of a specific activity including weather suggestions.

**Endpoint:** `GET /api/activities/{id}`

**Example Request:**
```bash
curl http://localhost:8000/api/activities/1
```

**Example Response:**
```json
{
    "success": true,
    "data": {
        "id": 1,
        "name": "Field Survey",
        "location": "DKI Jakarta",
        "sub_district": "Menteng",
        "village": "Menteng Dalam",
        "preferred_date": "2024-01-15",
        "selected_time_slot": "2024-01-15 09:00:00",
        "weather_condition": "Clear",
        "status": "scheduled",
        "notes": "Equipment inspection",
        "created_at": "2024-01-10T10:00:00.000000Z",
        "updated_at": "2024-01-10T10:00:00.000000Z"
    },
    "weather_suggestions": [
        {
            "datetime": "2024-01-15 06:00:00",
            "time": "06:00",
            "weather": "Clear",
            "weather_code": "0",
            "temperature": "26",
            "humidity": "75",
            "is_optimal": true,
            "recommendation": "Recommended"
        }
    ]
}
```

### Update Activity

Update an existing activity.

**Endpoint:** `PUT /api/activities/{id}`

**Parameters:** Same as create activity, but all parameters are optional.

**Example Request:**
```bash
curl -X PUT http://localhost:8000/api/activities/1 \
  -H "Content-Type: application/json" \
  -d '{
    "status": "completed",
    "weather_condition": "Clear"
  }'
```

**Example Response:**
```json
{
    "success": true,
    "message": "Activity updated successfully",
    "data": {
        "id": 1,
        "name": "Field Survey",
        "location": "DKI Jakarta",
        "sub_district": "Menteng",
        "village": "Menteng Dalam",
        "preferred_date": "2024-01-15",
        "selected_time_slot": "2024-01-15 09:00:00",
        "weather_condition": "Clear",
        "status": "completed",
        "notes": "Equipment inspection",
        "created_at": "2024-01-10T10:00:00.000000Z",
        "updated_at": "2024-01-10T12:00:00.000000Z"
    }
}
```

### Delete Activity

Delete an activity.

**Endpoint:** `DELETE /api/activities/{id}`

**Example Request:**
```bash
curl -X DELETE http://localhost:8000/api/activities/1
```

**Example Response:**
```json
{
    "success": true,
    "message": "Activity deleted successfully"
}
```

## Weather API

### Get Weather Forecast

Retrieve weather forecast data for a specific province.

**Endpoint:** `GET /api/weather/forecast`

**Required Parameters:**
- `province_id`: Province ID (string)

**Optional Parameters:**
- `days`: Number of forecast days (integer, 1-7, default: 3)

**Example Request:**
```bash
curl "http://localhost:8000/api/weather/forecast?province_id=31&days=3"
```

**Example Response:**
```json
{
    "success": true,
    "message": "Weather forecast retrieved successfully",
    "data": {
        "province_id": "31",
        "days": 3,
        "forecast": {
            "Jakarta": [
                {
                    "datetime": "2024-01-15 06:00:00",
                    "date": "2024-01-15",
                    "time": "06:00",
                    "weather": "0",
                    "t": "26",
                    "hu": "75"
                }
            ]
        }
    }
}
```

### Get Weather Suggestions

Get weather-based time slot suggestions for optimal outdoor activities.

**Endpoint:** `GET /api/weather/suggestions`

**Required Parameters:**
- `location`: Location name (string)
- `date`: Target date (date, format: YYYY-MM-DD, must be today or future)

**Optional Parameters:**
- `province_id`: Province ID (string, default: "31" for Jakarta)

**Example Request:**
```bash
curl "http://localhost:8000/api/weather/suggestions?location=Jakarta&date=2024-01-15"
```

**Example Response:**
```json
{
    "success": true,
    "message": "Weather suggestions retrieved successfully",
    "data": {
        "location": "Jakarta",
        "date": "2024-01-15",
        "province_id": "31",
        "suggestions": [
            {
                "datetime": "2024-01-15 06:00:00",
                "time": "06:00",
                "weather": "Clear",
                "weather_code": "0",
                "temperature": "26",
                "humidity": "75",
                "is_optimal": true,
                "recommendation": "Recommended"
            },
            {
                "datetime": "2024-01-15 12:00:00",
                "time": "12:00",
                "weather": "Light Rain",
                "weather_code": "60",
                "temperature": "28",
                "humidity": "85",
                "is_optimal": false,
                "recommendation": "Not recommended"
            }
        ],
        "optimal_count": 1,
        "total_slots": 2
    }
}
```

### Get Available Locations

Retrieve list of available provinces/locations.

**Endpoint:** `GET /api/weather/locations`

**Example Request:**
```bash
curl http://localhost:8000/api/weather/locations
```

**Example Response:**
```json
{
    "success": true,
    "message": "Available locations retrieved successfully",
    "data": {
        "locations": {
            "31": "DKI Jakarta",
            "32": "Jawa Barat",
            "33": "Jawa Tengah",
            "34": "DI Yogyakarta",
            "35": "Jawa Timur"
        },
        "total": 34
    }
}
```

## Weather Codes

The BMKG API uses specific codes for weather conditions:

| Code | Description |
|------|-------------|
| 0 | Clear |
| 1 | Partly Cloudy |
| 2 | Cloudy |
| 3 | Overcast |
| 4 | Haze |
| 5 | Mist |
| 10 | Smoke |
| 45 | Fog |
| 60 | Light Rain |
| 61 | Rain |
| 63 | Heavy Rain |
| 80 | Light Shower |
| 95 | Thunderstorm |
| 97 | Heavy Thunderstorm |

## Optimal Weather Conditions

The system considers these weather codes as optimal for outdoor activities:
- 0 (Clear)
- 1 (Partly Cloudy)
- 2 (Cloudy)
- 3 (Overcast)

## Error Handling

### Validation Errors

When validation fails, the API returns a 422 status code with detailed error information:

```json
{
    "success": false,
    "message": "Validation failed",
    "errors": {
        "name": ["The name field is required."],
        "preferred_date": ["The preferred date must be a date after or equal to today."]
    }
}
```

### Not Found Errors

When a resource is not found, the API returns a 404 status code:

```json
{
    "success": false,
    "message": "Activity not found"
}
```

### Server Errors

For server errors, the API returns a 500 status code:

```json
{
    "success": false,
    "message": "Internal server error"
}
```

## Rate Limiting

Currently, there are no rate limits implemented. Future versions may include rate limiting for API protection.

## Pagination

List endpoints support pagination with the following parameters:
- `page`: Page number (default: 1)
- `per_page`: Items per page (default: 15, max: 100)

Pagination information is included in the response:

```json
{
    "pagination": {
        "current_page": 1,
        "last_page": 3,
        "per_page": 15,
        "total": 45,
        "from": 1,
        "to": 15
    }
}
```

## Testing the API

You can test the API using various tools:

### cURL Examples

```bash
# List activities
curl http://localhost:8000/api/activities

# Create activity
curl -X POST http://localhost:8000/api/activities \
  -H "Content-Type: application/json" \
  -d '{"name":"Test Activity","location":"Jakarta","preferred_date":"2024-01-20"}'

# Get weather suggestions
curl "http://localhost:8000/api/weather/suggestions?location=Jakarta&date=2024-01-20"
```

### Postman Collection

Import the following collection into Postman for easy API testing:

```json
{
    "info": {
        "name": "Outdoor Activity Scheduler API",
        "schema": "https://schema.getpostman.com/json/collection/v2.1.0/collection.json"
    },
    "item": [
        {
            "name": "Activities",
            "item": [
                {
                    "name": "List Activities",
                    "request": {
                        "method": "GET",
                        "url": "{{base_url}}/api/activities"
                    }
                },
                {
                    "name": "Create Activity",
                    "request": {
                        "method": "POST",
                        "url": "{{base_url}}/api/activities",
                        "header": [
                            {
                                "key": "Content-Type",
                                "value": "application/json"
                            }
                        ],
                        "body": {
                            "mode": "raw",
                            "raw": "{\n    \"name\": \"Test Activity\",\n    \"location\": \"DKI Jakarta\",\n    \"preferred_date\": \"2024-01-20\"\n}"
                        }
                    }
                }
            ]
        }
    ],
    "variable": [
        {
            "key": "base_url",
            "value": "http://localhost:8000"
        }
    ]
}
```

## SDK and Libraries

Currently, no official SDKs are available. The API can be consumed using standard HTTP libraries in any programming language.

## Changelog

### Version 1.0.0
- Initial API release
- Activities CRUD operations
- Weather forecast integration
- Weather suggestions endpoint
- Location management