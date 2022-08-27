@extends('admin.layouts.master')

@section('content')
    <h3 class="text-center mt-5">Детали заказа</h3>

    <table class="table table-striped mt-3">
        <thead>
        <tr>
            <th scope="col">ID</th>
            <th scope="col">Имя</th>
            <th scope="col">Телефон</th>
            <th scope="col">Дата</th>
            <th scope="col">Сумма</th>
            <th scope="col">Статус</th>
        </tr>
        </thead>
        <tbody>
        @isset($order)
            <tr>

                <td>{{$order->id}}</td>
                <td>{{$order->name}}</td>
                <td>{{$order->phone}}</td>
                <td>{{$order->updated_at}}</td>
                <td>{{$order->getFullPrice()}}</td>
                <td>{{$order->getStatusName()}}</td>
            </tr>
        @endisset
        </tbody>
    </table>

    <h3 class="mt-5">Информация о товарах</h3>
    <table class="table table-striped mt-3">
        <thead>
        <tr>
            <th scope="col">Название</th>
            <th scope="col">Категория</th>
            <th scope="col">Количество</th>
            <th scope="col">Цена</th>
            <th scope="col">Стоимость</th>
        </tr>
        </thead>
        <tbody>
        @isset($products)
            @foreach($products as $product)
                <tr>
                    <td>{{$product->name}}</td>
                    <td>{{$product->category->name}}</td>
                    <td>{{$product->pivot->count}}</td>
                    <td>{{$product->price}}</td>
                    <td>{{$product->getPriceForCount()}}</td>
                </tr>
            @endforeach
        @endisset
        </tbody>
    </table>
@endsection
