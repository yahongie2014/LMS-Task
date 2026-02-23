<x-mail::message>
# Welcome, {{ $name }}

Thank you for joining our Mini-LMS! We are excited to have you on board.

<x-mail::button :url="config('app.url')">
Browse Courses
</x-mail::button>

Thanks,<br>
{{ config('app.name') }}
</x-mail::message>
