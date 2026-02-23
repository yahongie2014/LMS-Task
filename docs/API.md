# API Documentation & Integration Guide

## 1. Request Handling Policy

All mobile API endpoints utilize a unified validation layer (`BaseApiRequest`) to ensure consistent data structures and error handling.

### Content-Type Support
The API supports two primary request formats:
- **application/json**: Recommended for standard data-only requests (Login, OTP verification, Enrollment).
- **multipart/form-data**: Required when uploading binary data (Registration with Avatar, Profile Update).

### Unified Validation Schema
When validation fails, the API returns a **422 Unprocessable Entity** status with the following structure:

```json
{
    "success": false,
    "message": "Validation Error",
    "errors": {
        "email": ["The email has already been taken."],
        "password": ["The password must be at least 8 characters."]
    }
}
```

---

## 2. Authentication Flow

### Dual-Guard System
The platform maintains distinct guards for different roles:
- `user`: Students/Regular Users
- `instructor`: Teachers/Content Creators

### A. Email/Password Login
**Endpoint**: `POST /api/auth/login`

**Payload**:
```json
{
    "email": "student@example.com",
    "password": "password",
    "type": "user",
    "device_name": "iPhone 15 Pro"
}
```

### B. Phone & OTP Login
**Step 1: Request OTP**
**Endpoint**: `POST /api/auth/send-otp`
**Payload**: `{"phone": "123456789012", "type": "user"}`

**Step 2: Verify OTP**
**Endpoint**: `POST /api/auth/verify-otp`
**Payload**: 
```json
{
    "phone": "123456789012",
    "otp": "123456",
    "type": "user",
    "device_name": "Android Tablet"
}
```

---

## 3. Core Endpoints

| Category | Method | Endpoint | Description |
| :--- | :--- | :--- | :--- |
| **Auth** | `POST` | `/api/auth/register` | Create account (supports multi-part form for avatars) |
| **Student** | `GET` | `/api/student/profile` | Retrieve authenticated student profile |
| **Student** | `POST` | `/api/student/enroll` | Enroll in a course (uses wallet balance) |
| **Instructor**| `POST` | `/api/instructor/courses` | Create a new course (with translated fields) |

---

## 4. Multi-Language (i18n)

The API automatically respects the `Accept-Language` header (values: `en` or `ar`). This influences:
- Validation error messages.
- Success/Error status messages.
- Dynamic data fields (e.g., `Course.title`).

---

## 5. Security Note

All authenticated requests must include the Bearer token in the header:
`Authorization: Bearer {token}`
