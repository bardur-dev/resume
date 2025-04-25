@extends('layouts.app')

@section('content')
    <div class="container py-4">
        <div class="card">
            <div class="card-header">
                <h2>Редактирование пользователя: {{ $user->name }}</h2>
            </div>

            <div class="card-body">
                <form method="POST" action="{{ route('admin.users.update', $user) }}">
                    @csrf
                    @method('PUT')

                    <div class="mb-3">
                        <label for="name" class="form-label">Имя</label>
                        <input type="text" class="form-control" id="name" name="name"
                               value="{{ old('name', $user->name) }}" required>
                    </div>

                    <div class="mb-3">
                        <label for="email" class="form-label">Email</label>
                        <input type="email" class="form-control" id="email" name="email"
                               value="{{ old('email', $user->email) }}" required>
                    </div>

                    <div class="mb-3">
                        <label for="password" class="form-label">Новый пароль</label>
                        <input type="password" class="form-control" id="password" name="password">
                        <div class="form-text">Оставьте пустым, если не хотите менять</div>
                    </div>

                    <div class="mb-3">
                        <label for="password_confirmation" class="form-label">Подтверждение пароля</label>
                        <input type="password" class="form-control" id="password_confirmation"
                               name="password_confirmation">
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Роль</label>
                        <div class="form-check">
                            <input class="form-check-input" type="radio" name="role"
                                   id="role_user" value="user" {{ $user->role === 'user' ? 'checked' : '' }}>
                            <label class="form-check-label" for="role_user">
                                Обычный пользователь
                            </label>
                        </div>
                        <div class="form-check">
                            <input class="form-check-input" type="radio" name="role"
                                   id="role_admin" value="admin" {{ $user->role === 'admin' ? 'checked' : '' }}>
                            <label class="form-check-label" for="role_admin">
                                Администратор
                            </label>
                        </div>
                    </div>

                    <button type="submit" class="btn btn-primary">Сохранить</button>
                    <a href="{{ route('admin.users.index') }}" class="btn btn-secondary">Отмена</a>
                </form>
            </div>
        </div>
    </div>
@endsection
