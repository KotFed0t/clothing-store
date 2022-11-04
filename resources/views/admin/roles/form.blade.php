@extends('admin.layouts.master')

@isset($user)
    @section('title', 'Редактировать роли пользователя ' . $user->email)
@else
    @section('title', 'Добавить роль пользователю')
@endisset

@section('content')
    <div class="col-md-12">
        @isset($user)
            <h1 class="mb-5">Редактировать роли пользователя </h1>
        @else
            <h1>Добавить роль пользователю</h1>
        @endisset

        <form method="POST"
              @isset($user)
                  action="{{ route('admin.EditUserRole', $user->id) }}"
              @else
                  action="{{ route('admin.CreateUserRole') }}"
            @endisset
        >
            <div>
                @csrf
                <br>
                <div class="input-group row">
                    <label for="email" class="col-sm-2 col-form-label">Email: </label>
                    <div class="col-sm-4">
                        @error('email')
                        <div class="alert alert-danger">{{ $message }}</div>
                        @enderror
                        @isset($user)
                            <p>@isset($user){{ $user->email }}@endisset</p>
                        @else
                            <input type="text" class="form-control" name="email" id="email">
                        @endisset
                    </div>
                </div>

                <br>

                @error('roles_id')
                <div class="alert alert-danger">{{ $message }}</div>
                @enderror
                <div class="input-group row">
                    <label for="email" class="col-sm-2 col-form-label">Роли: </label>
                        <div class="form-check col-sm-4">
                            @foreach($roles as $role)
                            <input name="roles_id[]" class="form-check-input" type="checkbox" value="{{$role->id}}"
                                   @isset($user)
                                       @if($user->roles->contains('id', $role->id))
                                           checked
                                   @endif
                                   @endisset
                                  id="condition-checkbox">
                            <label class="form-check-label text-uppercase small text-muted" for="condition-checkbox">
                                {{$role->name}}
                            </label>
                                <br>
                            @endforeach
                        </div>
                </div>

                <br>

                <button class="btn btn-success">Сохранить</button>
            </div>
        </form>
    </div>
@endsection
