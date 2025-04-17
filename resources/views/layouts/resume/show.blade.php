@extends('layouts.app')

@section('content')
    <div class="container py-4">
        <div class="card">
            <div class="card-header d-flex justify-content-between align-items-center">
                <h1 class="h3 mb-0">Ваше резюме</h1>
                <div>
                    <a href="{{ route('experience.create') }}" class="btn btn-outline-primary btn-sm me-2">
                        <i class="bi bi-arrow-left"></i> Назад
                    </a>
                    <a href="{{ route('resume.download') }}" class="btn btn-success btn-sm">
                        <i class="bi bi-download me-1"></i> PDF
                    </a>
                </div>
            </div>

            <div class="card-body">
                @if(session('error'))
                    <div class="alert alert-danger alert-dismissible fade show">
                        {{ session('error') }}
                        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                    </div>
                @endif

                <div class="resume-content bg-light p-4 rounded">
                    {!! nl2br(e($resume)) !!}
                </div>

                <div class="mt-4 d-flex justify-content-between">
                    <a href="{{ route('experience.create') }}" class="btn btn-outline-secondary">
                        <i class="bi bi-plus-circle me-2"></i>Добавить опыт
                    </a>

                    <div>
                        <button class="btn btn-outline-primary me-2" onclick="window.print()">
                            <i class="bi bi-printer me-2"></i>Печать
                        </button>
                        <a href="{{ route('resume.download') }}" class="btn btn-primary">
                            <i class="bi bi-file-earmark-pdf me-2"></i>Скачать PDF
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
