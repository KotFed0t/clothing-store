@extends('admin.layouts.master')

@section('title', 'Товары')

@section('content')
    <div class="col-md-12">
        <h1>Товары</h1>
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
                    Категория
                </th>
                <th>
                    Цена
                </th>
                <th>
                    Действия
                </th>
            </tr>
            @foreach($products as $product)
                <tr>
                    <td>{{ $product->id}}</td>
                    <td>{{ $product->code }}</td>
                    <td>{{ $product->name }}</td>
                    <td>{{ $product->category->name }}</td>
                    <td>{{ $product->price }} р.</td>
                    <td>
                        <div class="btn-group" role="group">
                            <form>
                                <a class="btn btn-success" type="button"
                                   href="{{route('admin.showProduct', $product->id)}}">Открыть</a>
                                <a class="btn btn-warning" type="button"
                                   href="{{route('admin.showEditProduct', $product->id)}}">Редактировать</a>
                                @csrf
                                <a class="btn btn-danger" type="button"
                                   href="{{route('admin.deleteProduct', $product->id)}}">удалить</a>
                            </form>
                        </div>
                    </td>
                </tr>
            @endforeach
            </tbody>
        </table>
        <a class="btn btn-success" type="button" href="{{ route('admin.createProduct') }}">Добавить товар</a>
    </div>
@endsection
