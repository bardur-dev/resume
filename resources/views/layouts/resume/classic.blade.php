<!DOCTYPE html>
<html>
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
    <title>Резюме</title>
    <style>
        @font-face {
            font-family: 'DejaVu Sans';
            font-style: normal;
            font-weight: normal;
            src: url({{ storage_path('fonts/DejaVuSans.ttf') }}) format('truetype');
        }
        @font-face {
            font-family: 'DejaVu Sans';
            font-style: normal;
            font-weight: bold;
            src: url({{ storage_path('fonts/DejaVuSans-Bold.ttf') }}) format('truetype');
        }
        .avatar-container {
            text-align: center;
            margin-bottom: 20px;
        }
        .avatar-img {
            width: 120px;
            height: 120px;
            border-radius: 50%;
            object-fit: cover;
            border: 3px solid #3498db;
        }

        body {
            font-family: 'DejaVu Sans', sans-serif;
            line-height: 1.6;
            color: #333;
            font-size: 12px;
            padding: 40px;
            max-width: 800px;
            margin: 0 auto;
        }

        h1 {
            color: #2c3e50;
            font-size: 24px;
            border-bottom: 2px solid #3498db;
            padding-bottom: 10px;
            text-align: center;
            margin-bottom: 5px;
        }

        h2 {
            color: #3498db;
            font-size: 16px;
            border-bottom: 1px solid #eee;
            padding-bottom: 5px;
            margin-top: 20px;
        }

        h3 {
            font-size: 14px;
            color: #2c3e50;
            margin-bottom: 5px;
        }

        ul, ol {
            padding-left: 20px;
        }

        li {
            margin-bottom: 5px;
        }

        .contact-info {
            text-align: center;
            margin-bottom: 20px;
            color: #7f8c8d;
        }

        .job {
            margin-bottom: 15px;
        }

        .job-title {
            font-weight: bold;
        }

        .company {
            font-style: italic;
        }

        .period {
            color: #7f8c8d;
            font-size: 11px;
        }

        strong {
            font-weight: bold;
        }

        em {
            font-style: italic;
        }

        .footer {
            text-align: center;
            margin-top: 30px;
            font-size: 10px;
            color: #95a5a6;
            border-top: 1px solid #eee;
            padding-top: 10px;
        }
    </style>
</head>
<body>
{!! $resume !!}

@isset($jobLinks)
    @include('layouts.resume.job_links', ['jobLinks' => $jobLinks, 'technologies' => $technologies ?? []])
@endisset

<div class="footer">
    Резюме сгенерировано на сайте ResumeGenerator | {{ date('d.m.Y') }}

</div>

</body>
</html>
