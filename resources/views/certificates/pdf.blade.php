<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}" dir="{{ app()->getLocale() == 'ar' ? 'rtl' : 'ltr' }}">
<head>
    <meta charset="UTF-8">
    <title>{{ __('messages.certificate_of_completion') }}</title>
    <style>
        body {
            font-family: sans-serif;
            text-align: center;
            margin: 0;
            padding: 0;
            color: #1f2937;
        }
        .container {
            width: 100%;
            height: 100%;
            border: 12px double #e5e7eb;
            padding: 50px;
            box-sizing: border-box;
        }
        .header {
            font-size: 40px;
            font-weight: bold;
            color: #111827;
            margin-bottom: 20px;
            text-transform: uppercase;
        }
        .sub-header {
            font-size: 20px;
            color: #6b7280;
            margin-bottom: 30px;
            font-style: italic;
        }
        .name {
            font-size: 50px;
            font-weight: bold;
            color: #111827;
            border-bottom: 4px solid #2563eb;
            display: inline-block;
            padding-bottom: 10px;
            margin-bottom: 30px;
        }
        .course-label {
            font-size: 20px;
            color: #4b5563;
            margin-bottom: 20px;
        }
        .course-title {
            font-size: 35px;
            font-weight: bold;
            color: #2563eb;
            text-transform: uppercase;
            margin-bottom: 60px;
        }
        .footer {
            width: 100%;
            font-size: 14px;
            color: #9ca3af;
        }
        .footer table {
            width: 100%;
        }
        .footer td {
            text-align: center;
            vertical-align: bottom;
        }
        .date {
            font-size: 20px;
            color: #1f2937;
            font-weight: bold;
        }
        .label {
            border-top: 1px solid #d1d5db;
            padding-top: 5px;
            margin-top: 5px;
            text-transform: uppercase;
        }
        .seal {
            border: 4px dashed #2563eb;
            border-radius: 50%;
            width: 100px;
            height: 100px;
            line-height: 100px;
            margin: 0 auto;
            color: #2563eb;
            font-weight: bold;
        }
    </style>
</head>
<body>
    <div class="container">
        
        <div class="header">{{ __('messages.certificate_of_completion') }}</div>
        
        <div class="sub-header">{{ __('messages.this_is_to_certify_that') }}</div>
        
        <div class="name">{{ $user->name }}</div>
        
        <div class="course-label">{{ __('messages.has_successfully_completed') }}</div>
        
        <div class="course-title">"{{ $course->title }}"</div>
        
        <div class="footer">
            <table>
                <tr>
                    <td style="width: 30%;">
                        <div class="date">{{ \Carbon\Carbon::parse($date)->format('F d, Y') }}</div>
                        <div class="label">{{ __('messages.date') }}</div>
                    </td>
                    <td style="width: 40%;">
                        <div class="seal">VERIFIED</div>
                    </td>
                    <td style="width: 30%;">
                        <div class="date">Admin</div>
                        <div class="label">{{ __('messages.signature') }}</div>
                    </td>
                </tr>
            </table>
        </div>

        <div style="margin-top: 40px; font-size: 10px;">
            {{ __('messages.certificate_id') }}: {{ $certificate->id }}
        </div>
    </div>
</body>
</html>
