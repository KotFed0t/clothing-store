@extends('admin.layouts.master')

@section('title', 'Продукт ' . $product->name)

@section('content')
    <div class="col-md-12">
        <h1>{{ $product->name }}</h1>
        <table class="table">
            <tbody>
            <tr>
                <th>
                    Поле
                </th>
                <th>
                    Значение
                </th>
            </tr>
            <tr>
                <td>ID</td>
                <td>{{ $product->id}}</td>
            </tr>
            <tr>
                <td>Код</td>
                <td>{{ $product->code }}</td>
            </tr>
            <tr>
                <td>Название</td>
                <td>{{ $product->name }}</td>
            </tr>
            <tr>
                <td>Описание</td>
                <td>{{ $product->description }}</td>
            </tr>
            <tr>
                <td>Картинка</td>
                <td>
                    <img src="{{ Storage::url($product->image) }}" height="240px">
                    @foreach($product->images() as $image)
                        <img src="{{ Storage::url($image) }}" height="240px">
                    @endforeach
                </td>
            </tr>
            <tr>
                <td>Категория</td>
                <td>{{ $product->category->name }}</td>
            </tr>
            <tr>
                <td>Гендер</td>
                <td>{{ $product->gender }}</td>
            </tr>
            @foreach($product->values as $value)
                @if($value->property->name != 'размер')
                    <tr>
                        <td>{{$value->property->name}}</td>
                        <td>{{ $value->name }}</td>
                    </tr>
                @endif
            @endforeach

            <tr>
                <td>Размер</td>
                <td>
            @foreach($product->values as $value)
                @if($value->property->name == 'размер')
                    {{ $value->name }}<br>
                @endif
            @endforeach
                </td>
            </tr>
            <tr>
                <td>Цена</td>
                <td>{{ $product->price }} р.</td>
            </tr>
            </tbody>
        </table>
    </div>
@endsection
