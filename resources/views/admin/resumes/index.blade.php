@extends('layouts.app')

@section('content')
    <div class="container">
        <h1>Управление резюме</h1>

        <table class="table table-striped">
            <thead>
            <tr>
                <th>Пользователь</th>
                <th>Имя файла</th>
                <th>Дата создания</th>
                <th>Действия</th>
            </tr>
            </thead>
            <tbody>
            @foreach($resumes as $resume)
                <tr>
                    <td>{{ $resume->user->name }}</td>
                    <td>{{ $resume->file_name }}</td>
                    <td>{{ $resume->created_at->format('d.m.Y H:i') }}</td>
                    <td>
                        <a href="{{ route('admin.resumes.download', $resume) }}"
                           class="btn btn-sm btn-success">
                            <i class="bi bi-download"></i> Скачать
                        </a>
                    </td>
                </tr>
            @endforeach
            </tbody>
        </table>

        {{ $resumes->links() }}
    </div>
@endsection
