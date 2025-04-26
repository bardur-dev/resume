@extends('layouts.app')

@section('content')
    <div class="container">
        <h1>Редактирование промпта для генерации резюме</h1>

        <form method="POST" action="{{ route('admin.prompts.update') }}">
            @csrf
            @method('PUT')

            <div class="mb-3">
                <label for="content" class="form-label">Текст промпта:</label>
                <textarea class="form-control"
                          id="content"
                          name="content"
                          rows="20"
                          required>{{ old('content', $prompt->content) }}</textarea>
            </div>

            <button type="submit" class="btn btn-primary">Сохранить изменения</button>
        </form>
    </div>
@endsection
