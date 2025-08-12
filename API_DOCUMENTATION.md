# Appointments API Documentation

## Authentication
All API endpoints require authentication using Bearer token.

## Endpoints

### 1. Get All Appointments
Retrieve a list of all appointments with optional filtering.

**Endpoint:** `GET /api/appointments`

**Headers:**
```
Authorization: Bearer YOUR_TOKEN_HERE
Content-Type: application/json
```

**Query Parameters:**
- `search` (optional): Search appointments by name or description
- `status` (optional): Filter by status (pending, confirmed, completed, cancelled, rescheduled)
- `date_from` (optional): Filter appointments from this date (YYYY-MM-DD)
- `date_to` (optional): Filter appointments to this date (YYYY-MM-DD)
- `per_page` (optional): Number of results per page (1-100, default: 15)
- `page` (optional): Page number (default: 1)

**Example Request:**
```bash
curl -X GET "http://your-domain.com/api/appointments?status=confirmed&per_page=20" \
  -H "Authorization: Bearer YOUR_TOKEN_HERE" \
  -H "Content-Type: application/json"
```

**Example Response:**
```json
{
  "success": true,
  "message": "Appointments retrieved successfully.",
  "data": {
    "appointments": [
      {
        "id": 1,
        "full_name": "John Doe",
        "email": "john@example.com",
        "date": "2024-01-15",
        "time": "10:00:00",
        "description": "Initial consultation",
        "status": "confirmed",
        "created_at": "2024-01-10T10:00:00Z",
        "updated_at": "2024-01-10T10:00:00Z"
      }
    ],
    "pagination": {
      "current_page": 1,
      "per_page": 20,
      "total": 1,
      "last_page": 1
    }
  }
}
```

**Error Response:**
```json
{
  "success": false,
  "message": "Error retrieving appointments.",
  "data": {
    "error": "Authentication failed"
  }
}
```

## Status Codes
- `200`: Success
- `401`: Unauthorized (invalid or missing token)
- `422`: Validation Error
- `500`: Server Error

## Notes
- The API uses the existing AppointmentApiService which connects to an external appointment management system
- All dates are returned in ISO 8601 format
- The API supports pagination for large datasets
- Filtering is optional and can be combined 