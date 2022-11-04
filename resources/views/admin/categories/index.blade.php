@extends('admin.layouts.master')

@section('title', 'Категории')

@section('content')
    <div class="col-md-12">
        <h1>Категории</h1>
        <table class="table">
            <tbody>
            <tr>
                <th>
                    #
                </th>
                <th>
                    Код
                </th>
                <th>
                    Название
                </th>
                <th>
                    Действия
                </th>
            </tr>
            @foreach($categories as $category)
                <tr>
                    <td>{{ $category->id }}</td>
                    <td>{{ $category->code }}</td>
                    <td>{{ $category->name }}</td>
                    <td>
                        <div class="btn-group" role="group">
                            <form>
                                @csrf
                                <a class="btn btn-success" type="button"
                                   href="{{route('admin.showCategory', $category->id)}}">Открыть</a>
                                @can('admin-manager')
                                    <a class="btn btn-warning" type="button"
                                       href="{{route('admin.showEditCategory', $category->id)}}">Редактировать</a>
                                    <a class="btn btn-danger" type="button"
                                       href="{{route('admin.deleteCategory', $category->id)}}">удалить</a>
                                @endcan
                            </form>
                        </div>
                    </td>
                </tr>
            @endforeach
            </tbody>
        </table>
        @can('admin-manager')
            <a class="btn btn-success" type="button"
               href="{{route('admin.showCreateCategory')}}">Добавить категорию</a>
        @endcan

    </div>
@endsection
