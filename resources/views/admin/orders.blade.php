@extends('admin.layouts.master')

@section('content')
    <h1 class="text-center mt-5">Заказы</h1>

    <table class="table table-striped">
        <thead>
        <tr>
            <th scope="col">ID</th>
            <th scope="col">Имя</th>
            <th scope="col">Телефон</th>
            <th scope="col">Дата</th>
            <th scope="col">Сумма</th>
            <th scope="col">Статус</th>
            <th scope="col">Действия</th>
        </tr>
        </thead>
        <tbody>
        @isset($orders)
            @foreach($orders as $order)
                <tr>

                    <td>{{$order->id}}</td>
                    <td>{{$order->name}}</td>
                    <td>{{$order->phone}}</td>
                    <td>{{$order->updated_at}}</td>
                    <td>{{$order->getFullPrice()}}</td>
                    <td>{{$order->getStatusName()}}</td>
                    <td><a href="{{route('admin.orderDetails', $order->id)}}">Открыть</a></td>
                </tr>
            @endforeach
        @endisset
        </tbody>
    </table>
@endsection
