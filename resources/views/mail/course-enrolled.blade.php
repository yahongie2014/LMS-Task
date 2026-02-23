<x-mail::message>
# Enrollment Confirmed!

Hello {{ $name }},

You have successfully enrolled in the course: **{{ $courseTitle }}**.

We hope you find this course valuable and enjoy your learning journey!

<x-mail::button :url="config('app.url') . '/dashboard'">
Go to Course
</x-mail::button>

Thanks,<br>
{{ config('app.name') }}
</x-mail::message>
