@extends('layouts.master')

@section('content')
    <h1 class="text-center mb-4">Заказы</h1>

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
                    <td>{{$order->user->name}}</td>
                    <td>{{$order->user->phone}}</td>
                    <td>{{$order->updated_at}}</td>
                    <td>{{$order->getFullPrice()}}</td>
                    <td>{{$order->getStatusName()}}</td>
                    <td><a class="btn bg-dark text-white" href="{{route('orderDetails', $order->id)}}">Открыть</a></td>
                </tr>
            @endforeach
        @endisset
        </tbody>
    </table>
@endsection
