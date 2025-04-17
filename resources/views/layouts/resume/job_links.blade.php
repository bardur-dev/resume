<div class="job-links" style="page-break-before: always; margin-top: 30px; font-family: 'DejaVu Sans', sans-serif;">
    <h2 style="color: #2d3748; border-bottom: 2px solid #e2e8f0; padding-bottom: 5px;">
        Где искать вакансии
    </h2>

    <ul style="list-style-type: none; padding-left: 0;">
        @foreach($jobLinks as $link)
            <li style="margin-bottom: 15px; padding: 10px; background: #f8fafc; border-radius: 4px;">
                <div style="display: flex; align-items: center;">
                    @if($link['icon'] === 'hh')
                        <span style="display: inline-block; width: 24px; height: 24px; margin-right: 10px; background-color: #FF3366; color: white; text-align: center; border-radius: 3px; font-weight: bold; font-family: 'DejaVu Sans';">HH</span>
                    @elseif($link['icon'] === 'habr')
                        <span style="display: inline-block; width: 24px; height: 24px; margin-right: 10px; background-color: #2a5885; color: white; text-align: center; border-radius: 3px; font-weight: bold; font-family: 'DejaVu Sans';">H</span>

                    @endif

                    <a href="{{ $link['url'] }}" style="color: #2b6cb0; text-decoration: none; font-size: 15px; font-family: 'DejaVu Sans', sans-serif;">
                        {{ $link['title'] }}
                    </a>
                </div>
                <div style="font-size: 12px; color: #718096; margin-left: 34px; font-family: 'DejaVu Sans', sans-serif;">
                    {{ $link['source'] }}
                </div>
            </li>
        @endforeach
    </ul>

    <p style="font-size: 12px; color: #a0aec0; margin-top: 20px; font-family: 'DejaVu Sans', sans-serif;">
        @if(!empty($jobLinks[0]['technologies']))
            Ссылки сгенерированы на основе ваших технологий:
            <strong>{{ implode(', ', $jobLinks[0]['technologies']) }}</strong>
        @else
            Ссылки на популярные IT-вакансии
        @endif
    </p>
</div>
