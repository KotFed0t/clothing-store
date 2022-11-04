@extends('admin.layouts.master')

@section('title', 'Роли')

@section('content')
    <div class="col-md-12">
        <h1>Роли</h1>
        <table class="table">
            <tbody>
            <tr>
                <th>
                    Email
                </th>
                <th>
                    Роль
                </th>
                <th>
                    Действия
                </th>
            </tr>
            @foreach($users as $user)
                <tr>
                    <td>{{ $user->email }}</td>
                    <td>
                    @foreach($user->roles as $role)
                        {{$role->name}} <br>
                    @endforeach
                    </td>
                    <td>
                        <div class="btn-group" role="group">
                            <form>
                                <a class="btn btn-success" type="button"
                                   href="{{route('admin.showEditUserRole', $user->id)}}">Редактировать</a>
                                @csrf
                                <a class="btn btn-danger" type="button"
                                   href="{{route('admin.deleteUserRole', $user->id)}}">удалить</a>
                            </form>
                        </div>
                    </td>
                </tr>
            @endforeach
            </tbody>
        </table>

        <a class="btn btn-success" type="button"
           href="{{route('admin.showCreateUserRole')}}">Добавить значение</a>
    </div>
@endsection
