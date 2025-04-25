@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="card">
            <div class="card-header">
                <h2>Мои резюме</h2>
            </div>

            <div class="card-body">
                @if($resumes->isEmpty())
                    <div class="alert alert-info">У вас пока нет сохраненных резюме</div>
                @else
                    <div class="list-group">
                        @foreach($resumes as $resume)
                            <div class="list-group-item d-flex justify-content-between align-items-center">
                                <div>
                                    <h5>{{ $resume->file_name }}</h5>
                                    <small>Создано: {{ $resume->created_at->format('d.m.Y H:i') }}</small>
                                </div>
                                <div>
                                    <a href="{{ route('user.resumes.edit', $resume) }}"
                                       class="btn btn-sm btn-outline-primary me-2">
                                        <i class="bi bi-pencil"></i> Редактировать
                                    </a>
                                    <a href="{{ route('admin.resumes.download', $resume) }}"
                                       class="btn btn-sm btn-outline-success"
                                       download="{{ $resume->file_name }}">
                                        <i class="bi bi-download"></i> Скачать
                                    </a>
                                </div>
                            </div>
                        @endforeach
                    </div>
                    {{ $resumes->links() }}
                @endif
            </div>
        </div>
    </div>
@endsection
