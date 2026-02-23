# System Architecture

## Overview
This application follows a modern, decoupled architecture using **Laravel 11** at its core. It leverages the **Repository Design Pattern** for data abstraction and an **Action-based domain layer** for business logic, supporting both a reactive **Livewire** frontend and a dedicated **REST API** for mobile integration.

---

## 1. Core Architectural Layers

### A. Data Layer (Repository Pattern)
We use a formal Repository layer (`app/Repositories`) to abstract all Eloquent operations.
- **Interfaces**: Define the contract for data access (e.g., `CourseRepositoryInterface`).
- **Eloquent Implementations**: Concrete classes (e.g., `Eloquent/CourseRepository`) that perform the actual database queries.
- **Service Provider**: `RepositoryServiceProvider` binds interfaces to implementations, allowing for zero-downtime dependency swapping and simplified unit testing via mocking.

### B. Domain Layer (Actions & Events)
Business logic is encapsulated in **Action Classes** (`app/Actions`).
- **Actions**: Discrete, reusable classes like `EnrollUser` or `CompleteLesson` that carry out specific tasks. They inject Repository Interfaces to interact with data.
- **Events**: Automated workflows are triggered via events (e.g., `CourseCompleted`).
- **Listeners**: Isolated listeners handle side effects like `IssueCertificate` or `SendCourseCompletionEmail`, which are processed asynchronously via queues.

### C. Validation & Authorization (Form Requests & Policies)
Security and data integrity are handled at the entry points:
- **Unified API Validation**: API requests inherit from `BaseApiRequest`, which overrides `failedValidation` to ensure all errors are returned as JSON (422 Unprocessable Entity) with a consistent schema, regardless of request headers.
- **Multi-Format Support**: Our `BaseApiRequest` provides utility helpers to parse payloads from both **Raw JSON** and **multipart/form-data**, allowing file uploads (like avatars) to coexist seamlessly with structured domain data.
- **Policies**: Standard Laravel Policies (e.g., `LessonPolicy`) gate access to premium content, ensuring users are enrolled before viewing non-preview lessons.

---

## 2. Access Channels

### A. Web Layer (Livewire & Blade)
- **Livewire Components**: Provide a reactive SPA-like experience without the complexity of a Javascript framework. They interact directly with repositories and actions.
- **Alpine.js**: Handles client-side interactivity such as UI toggles, video player controls, and modal animations.

### B. Mobile API Layer (Sanctum)
- **Laravel Sanctum**: Provides robust Token-based authentication for mobile apps and third-party integrations.
- **API Resources**: Dedicated resource classes (`app/Http/Resources`) transform internal models into a fixed JSON contract, ensuring API stability even if the database schema changes.

---

## 3. Storage & Infrastructure

### A. Docker Ecosystem
- **App**: PHP 8.3-FPM environment.
- **Web**: Nginx proxy.
- **DB**: MySQL 8.0 with optimized indexing for multi-language lookups.
- **Redis**: High-speed cache for session data and queue management.

### B. Specialized Data Handling
- **Translatable Content**: Powered by `spatie/laravel-translatable`, utilizing JSON columns to store localized titles and descriptions (AR/EN) within a single record.
- **UUID System**: Certificates use UUIDs as primary keys to prevent ID scraping and provide secure, unique identifiers for public verification links.

---

## 4. Key Design Principles
1. **Idempotency**: Critical operations (enrollment, completion) use database-level unique constraints and `firstOrCreate` to prevent race conditions or duplicate data.
2. **Thin Controllers**: Controllers solely facilitate HTTP/API responses; they do not contain business or validation logic.
3. **Interface Segregation**: Clients (Controllers/Livewire) depend on Repository Interfaces rather than concrete models.
