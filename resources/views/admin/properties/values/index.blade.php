@extends('admin.layouts.master')

@section('title', 'Свойства')

@section('content')
    <div class="col-md-12">
        <h1>Значения свойств</h1>
        <table class="table">
            <tbody>
            <tr>
                <th>
                    #
                </th>
                <th>
                    Название
                </th>
                <th>
                    Действия
                </th>
            </tr>
            @foreach($values as $value)
                <tr>
                    <td>{{ $value->id }}</td>
                    <td>{{ $value->name }}</td>
                    <td>
                        <div class="btn-group" role="group">
                            <form>
                                <a class="btn btn-success" type="button"
                                   href="{{route('admin.showEditPropertyValue', $value->id)}}">Редактировать</a>
                                @csrf
                                <a class="btn btn-danger" type="button"
                                   href="{{route('admin.deletePropertyValue', $value->id)}}">удалить</a>
                            </form>
                        </div>
                    </td>
                </tr>
            @endforeach
            </tbody>
        </table>

        <a class="btn btn-success" type="button"
           href="{{route('admin.showCreatePropertyValue', $propertyId)}}">Добавить значение</a>
    </div>
@endsection
