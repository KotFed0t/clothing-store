@extends('admin.layouts.master')

@section('title', 'Товары')

@section('content')
    <div class="col-md-12">
        <h1 class="mb-5">Товары</h1>
        <table class="table">
            <tbody>
            <tr>
                <th>
                    id
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
                    <td valign="middle">{{ $product->id}} &nbsp; <img src="{{Storage::url($product->image)}}" width="80px" height="80px"></td>
                    <td valign="middle">{{ $product->code }}</td>
                    <td valign="middle">{{ $product->name }}</td>
                    <td valign="middle">{{ $product->category->name }}</td>
                    <td valign="middle">{{ $product->price }} р.</td>
                    <td valign="middle">
                        <div class="btn-group" role="group">
                            <form>
                                @csrf
                                <a class="btn btn-success" type="button"
                                   href="{{route('admin.showProduct', $product->id)}}">Открыть</a>
                                @can('admin-manager')
                                    <a class="btn btn-warning" type="button"
                                       href="{{route('admin.showEditProduct', $product->id)}}">Редактировать</a>
                                    <a class="btn btn-danger" type="button"
                                       href="{{route('admin.deleteProduct', $product->id)}}">удалить</a>
                                @endcan
                            </form>
                        </div>
                    </td>
                </tr>
            @endforeach
            </tbody>
        </table>
        @can('admin-manager')
            <a class="btn btn-success" type="button" href="{{ route('admin.createProduct') }}">Добавить товар</a>
        @endcan
    </div>
@endsection
