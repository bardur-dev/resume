<div class="card">
    <div class="card-header bg-primary text-white">
        <h2>Анализ ваших навыков</h2>
    </div>
    <div class="card-body">
        <!-- График востребованности -->
        <div class="mb-4">
            <h4>Рейтинг востребованности</h4>
            <div class="row">
                @foreach($analysis['skills'] as $skill)
                    <div class="col-md-6 mb-3">
                        <div class="card">
                            <div class="card-body">
                                <h5>{{ $skill['name'] }}</h5>
                                <div class="d-flex justify-content-between">
                                <span class="badge bg-{{
                                    $skill['demand'] == 'high' ? 'success' :
                                    ($skill['demand'] == 'medium' ? 'warning' : 'danger')
                                }}">
                                    {{ $skill['demand'] == 'high' ? 'Высокая' :
                                      ($skill['demand'] == 'medium' ? 'Средняя' : 'Низкая') }}
                                </span>
                                    <span class="text-muted">{{ $skill['avg_salary'] }} руб.</span>
                                </div>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>

        <!-- Рекомендации -->
        <div class="alert alert-info">
            <h4>Рекомендации</h4>
            <ul>
                @foreach($analysis['recommendations'] as $rec)
                    <li>{{ $rec }}</li>
                @endforeach
            </ul>
        </div>

        <!-- Вакансии -->
        <div class="mt-4">
            <h4>Актуальные вакансии</h4>
            <div class="list-group">
                @foreach($jobLinks as $link)
                    <a href="{{ $link['url'] }}" target="_blank" class="list-group-item list-group-item-action">
                        <i class="bi bi-box-arrow-up-right me-2"></i>
                        {{ $link['title'] }} ({{ $link['source'] }})
                    </a>
                @endforeach
            </div>
        </div>
    </div>
</div>
