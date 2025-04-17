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

        body {
            font-family: 'DejaVu Sans', sans-serif;
            line-height: 1.6;
            color: #e2e8f0;
            font-size: 12px;
            padding: 40px;
            max-width: 800px;
            margin: 0 auto;
            background-color: #1a202c;
        }

        h1 {
            color: #81e6d9;
            font-size: 24px;
            border-bottom: 2px solid #4fd1c5;
            padding-bottom: 10px;
            text-align: center;
            margin-bottom: 5px;
            letter-spacing: 1px;
        }

        h2 {
            color: #63b3ed;
            font-size: 16px;
            border-bottom: 1px solid #2d3748;
            padding-bottom: 5px;
            margin-top: 20px;
        }

        h3 {
            font-size: 14px;
            color: #a0aec0;
            margin-bottom: 5px;
        }

        ul, ol {
            padding-left: 20px;
        }

        li {
            margin-bottom: 5px;
            color: #cbd5e0;
        }

        .contact-info {
            text-align: center;
            margin-bottom: 20px;
            color: #a0aec0;
            background-color: #2d3748;
            padding: 10px;
            border-radius: 5px;
        }

        .job {
            margin-bottom: 15px;
            background-color: #2d3748;
            padding: 15px;
            border-radius: 5px;
            border-left: 3px solid #4fd1c5;
        }

        .job-title {
            font-weight: bold;
            color: #81e6d9;
        }

        .company {
            font-style: italic;
            color: #a0aec0;
        }

        .period {
            color: #718096;
            font-size: 11px;
        }

        strong {
            font-weight: bold;
            color: #feb2b2;
        }

        em {
            font-style: italic;
            color: #fbd38d;
        }

        a {
            color: #63b3ed;
            text-decoration: none;
        }

        a:hover {
            text-decoration: underline;
        }

        .footer {
            text-align: center;
            margin-top: 30px;
            font-size: 10px;
            color: #718096;
            border-top: 1px solid #2d3748;
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
