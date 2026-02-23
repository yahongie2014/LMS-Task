# Product Thinking & Design Decisions

### 1. Robust Architecture: The Repository Pattern
We moved beyond simple Eloquent CRUD to a formal **Repository Pattern**. 
- **Decoupling**: Business logic in controllers (Web and API) is now decoupled from the data layer. Interfaces like `CourseRepositoryInterface` allow us to swap the underlying storage or add caching without touching a single controller line.
- **Consistency**: Centralizing queries (e.g., `hasCompletedCourse`, `getCourseProgress`) ensures that progress is calculated exactly the same way in the Dashboard, the Lesson view, and the Certificate generation logic.

### 2. Multi-Channel Support (Web & Mobile API)
In early development, we pivoted to an **API-First** mindset using **Laravel Sanctum**.
- **Shared Validation**: By using **Form Requests** (e.g., `GenerateCertificateRequest`), we share the exact same authorization and validation logic between traditional Web routes and mobile API endpoints. If logic changes, we update it in one class.
- **Thin Controllers**: Controllers are now "thin". They don't check permissions or validate data; they simply delegate to Repositories and return responses (Views or Resource JSON).

### 3. Business Risks Managed
- **Concurrent Actions & Double Enrollments**: Duplicate enrollments or completions are mitigated via database unique constraints (`user_id`, `course_id`) and idempotent repository methods (`firstOrCreate`).
- **Curriculum Shifts**: Progress is computed dynamically (`$completed / $totalLessons * 100`). If a lesson is added mid-course, a user's progress percentage updates automatically without data corruption.
- **Access Control**: Strict `LessonPolicy` and route-level `auth:sanctum` or `auth` middleware prevent unauthorized access to premium content.

### 4. Metrics & Performance
- **Course Completion Rate**: Tracked via `certificates` count vs `enrollments` count.
- **User Progression**: `LessonCompletion` records provide high-granularity data on where users drop off.
- **Performance Trade-off**: Progress math is dynamic. While caching a progress percentage row could be faster, dynamic calculation ensures total accuracy against the current curriculum state, which is vital in an LMS.

### 5. Trade-offs Made
1. **Repository Overhead vs Speed**: Adding Interfaces and Repositories increases initial file count but drastically reduces long-term maintenance debt as the mobile app and admin features scale.
2. **Monolith with API vs Microservices**: We stayed in a Monolith for simplicity and speed of deployment, while using Sanctum to provide the "Mobile App" ready infrastructure.
3. **Database Constraints over Application Gates**: We rely on DB-level unique indexes for data integrity. This prevents race conditions that simple PHP `if (!exists)` checks might miss under high concurrent load.

### 6. Future Evolution
- **Sequential Locking**: We can easily add a `LockedByPrerequisite` check in the `LessonRepository`.
- **Gamification**: The `CourseCompleted` event is ready to be hooked into a Badge or Points system.
- **Monetization**: The `EnrollUser` action can be updated to require a Stripe payment reference before creating the `Enrollment` record.
