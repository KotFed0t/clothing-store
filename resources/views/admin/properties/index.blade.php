@extends('admin.layouts.master')

@section('title', 'Свойства')

@section('content')
    <div class="col-md-12">
        <h1>Свойства</h1>
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
            @foreach($properties as $property)
                <tr>
                    <td>{{ $property->id }}</td>
                    <td>{{ $property->name }}</td>
                    <td>
                        <div class="btn-group" role="group">
                            <form>
                                <a class="btn btn-success" type="button"
                                   href="{{route('admin.showEditProperty', $property->id)}}">Редактировать</a>
                                <a class="btn btn-warning" type="button"
                                   href="{{route('admin.propertyValues', $property->id)}}">Значение свойств</a>
                                @csrf
                                <a class="btn btn-danger" type="button"
                                   href="{{route('admin.deleteProperty', $property->id)}}">удалить</a>
                            </form>
                        </div>
                    </td>
                </tr>
            @endforeach
            </tbody>
        </table>

        <a class="btn btn-success" type="button"
           href="{{route('admin.showCreateProperty')}}">Добавить свойство</a>
    </div>
@endsection
