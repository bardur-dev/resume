@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="card">
            <div class="card-header">
                <h2>Редактирование резюме</h2>
            </div>

            <div class="card-body">
                <form action="{{ route('user.resumes.update', $resume) }}" method="POST">
                    @csrf
                    @method('PUT')

                    <div class="mb-3">
                        <label for="content" class="form-label">Содержимое резюме (Markdown)</label>
                        <textarea name="content" id="content"
                                  class="form-control"
                                  rows="20">{{ old('content', $resume->content) }}</textarea>
                    </div>

                    <div class="d-flex justify-content-between">
                        <a href="{{ route('user.resumes.index') }}" class="btn btn-secondary">
                            <i class="bi bi-arrow-left"></i> Назад
                        </a>
                        <button type="submit" class="btn btn-primary">
                            <i class="bi bi-save"></i> Сохранить изменения
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection
