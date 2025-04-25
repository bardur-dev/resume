@extends('layouts.app')

@section('content')
    <div class="container py-4">
        <div id="memo-container" class="memo-container">
            <button id="memo-toggle" class="btn btn-primary memo-button" data-bs-toggle="collapse" data-bs-target="#memo-content">
                <i class="bi bi-info-circle me-2"></i>Памятка
            </button>
            <div id="memo-content" class="memo-content collapse">
                <h5>Как правильно заполнять резюме:</h5>
                <ul>
                    <li><strong>ФИО:</strong> Укажите ваше полное имя.</li>
                    <li><strong>Контакты:</strong>
                        <ul>
                            <li>Телефон: действующий номер для связи.</li>
                            <li>Email: актуальный адрес электронной почты.</li>
                        </ul>
                    </li>
                    <li><strong>Профессиональный опыт:</strong>
                        <ul>
                            <li>Укажите должность, название компании и период работы.</li>
                            <li>Опишите обязанности общими словами, без лишних деталей.</li>
                        </ul>
                    </li>
                    <li><strong>Навыки:</strong>
                        <ul>
                            <li>Перечислите ключевые навыки.</li>
                            <li>Укажите уровень владения иностранными языками.</li>
                        </ul>
                    </li>
                    <li><strong>Образование:</strong> Название учебного заведения и год окончания.</li>
                    <li><strong>Зарплата, график, место работы:</strong>
                        <ul>
                            <li>Желаемая зарплата.</li>
                            <li>График работы (полный день, удалённая работа и т.д.).</li>
                            <li>Предпочтительное место работы.</li>
                        </ul>
                    </li>
                    <li><strong>Информация о себе:</strong> Краткое описание ваших профессиональных целей или личных качеств.</li>
                    <li><strong>Проекты:</strong>
                        <ul>
                            <li>Название проекта.</li>
                            <li>Ваша роль в проекте.</li>
                            <li>Технологии, которые вы использовали.</li>
                            <li>Ключевые особенности проекта.</li>
                        </ul>
                    </li>
                </ul>
            </div>
        </div>
        <div class="card">
            <div class="card-header">
                <h1 class="h3">Добавить профессиональный опыт</h1>
            </div>

            <div class="card-body">
                @if(session('success'))
                    <div class="alert alert-success alert-dismissible fade show">
                        {{ session('success') }}
                        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                    </div>
                @endif

                <form action="{{ route('experience.store') }}" method="POST" class="mb-4">
                    @csrf
                    <div class="row g-3">
                        <div class="col-md-6">
                            <label for="title" class="form-label">Должность*</label>
                            <input type="text" name="title" id="title" class="form-control" required>
                        </div>

                        <div class="col-md-3">
                            <label for="start_date" class="form-label">Дата начала*</label>
                            <input type="date" name="start_date" id="start_date" class="form-control" required>
                        </div>

                        <div class="col-md-3">
                            <label for="end_date" class="form-label">Дата окончания</label>
                            <input type="date" name="end_date" id="end_date" class="form-control">
                            <div class="form-text">Оставьте пустым, если продолжаете работать</div>
                        </div>

                        <div class="col-12">
                            <label for="description" class="form-label">Обязанности и достижения*</label>
                            <textarea name="description" id="description" class="form-control" rows="4" required></textarea>
                        </div>
                        <div class="col-12">
                            <label for="projects" class="form-label">Проекты (укажите ваши ключевые проекты)</label>
                            <textarea name="projects" id="projects" class="form-control" rows="4"
                                      placeholder="Пример:
- Проект: Разработка CRM-системы
  Роль: Fullstack разработчик
  Технологии: PHP, Laravel, Vue.js
  Особенности: Интеграция с 1С, реализация сложных отчетов"></textarea>
                            <div class="form-text">Опишите ключевые проекты, в которых участвовали (роль, технологии, особенности)</div>
                        </div>

                        <div class="col-12">
                            <button type="submit" class="btn btn-primary">
                                <i class="bi bi-save me-2"></i>Сохранить
                            </button>
                        </div>
                    </div>
                </form>

                @if($experiences->isNotEmpty())
                    <div class="mt-5">
                        <h2 class="h4 mb-3">Ваш опыт работы</h2>
                        <form action="{{ route('resume.generate') }}" method="POST" id="resumeForm">
                            @csrf
                            <div class="list-group mb-3">
                                @foreach($experiences as $experience)
                                    <div class="list-group-item">
                                        <div class="form-check">
                                            <input class="form-check-input" type="checkbox"
                                                   name="experience_ids[]"
                                                   value="{{ $experience->id }}"
                                                   id="exp_{{ $experience->id }}" checked>
                                            <label class="form-check-label w-100" for="exp_{{ $experience->id }}">
                                                <div class="d-flex justify-content-between">
                                                    <h5 class="mb-1">{{ $experience->title }}</h5>
                                                    <small>{{ $experience->start_date }} — {{ $experience->end_date ?? 'наст. время' }}</small>
                                                </div>
                                                <p class="mb-1">{{ $experience->description }}</p>
                                            </label>
                                        </div>
                                    </div>
                                @endforeach
                            </div>



                            <div class="card mb-4">
                                <div class="card-header">Выберите шаблон резюме</div>
                                <div class="card-body">
                                    <div class="row">
                                        <div class="col-md-6 mb-3">
                                            <div class="template-preview text-center">
                                                <img src="/images/classic-template.png" class="img-fluid rounded mb-2 border" alt="Классический шаблон" style="max-height: 300px;">
                                                <div class="form-check d-flex justify-content-center">
                                                    <input class="form-check-input" type="radio" name="template" id="templateClassic" value="classic" checked>
                                                    <label class="form-check-label ms-2 fw-bold" for="templateClassic">
                                                        Классический шаблон
                                                    </label>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-6 mb-3">
                                            <div class="template-preview text-center">
                                                <img src="/images/dark-template.png" class="img-fluid rounded mb-2 border" alt="Темный шаблон" style="max-height: 300px;">
                                                <div class="form-check d-flex justify-content-center">
                                                    <input class="form-check-input" type="radio" name="template" id="templateDark" value="dark">
                                                    <label class="form-check-label ms-2 fw-bold" for="templateDark">
                                                        Темный шаблон
                                                    </label>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="d-flex justify-content-between mt-4">
                                <button type="submit" class="btn btn-success" id="generateResumeBtn">
                                    <i class="bi bi-file-earmark-pdf me-2"></i>Скачать резюме (PDF)
                                </button>
                            </div>
                        </form>
                    </div>
                @endif
            </div>
        </div>

        @if($experiences->isNotEmpty())
            <form action="{{ route('experience.clear') }}" method="POST" class="d-inline">
                @csrf
                @method('DELETE')
                <button type="submit" class="btn btn-outline-danger"
                        onclick="return confirm('Вы уверены, что хотите удалить весь опыт работы?')">
                    <i class="bi bi-trash me-2"></i>Очистить все
                </button>
            </form>
        @endif
    </div>
@endsection
