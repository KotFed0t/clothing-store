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
            <h5>Фильтр по статусам:</h5>
            <form action="{{route('admin.orders')}}">
                <select name="status_id" class="form-select mb-4" aria-label="Default select example">
                    <option value="0">По умолчанию</option>
                    <option value="1" @if(request()->sort == 'price_asc') selected @endif>Оформленные</option>
                    <option value="2" @if(request()->sort == 'price_desc') selected @endif>В процессе комлпектации</option>
                    <option value="3" @if(request()->sort == 'name_asc') selected @endif>Переданы в доставку</option>
                    <option value="4" @if(request()->sort == 'name_desc') selected @endif>Доставлен</option>
                    <option value="5" @if(request()->sort == 'name_desc') selected @endif>Возврат</option>
                </select>
                <button class="btn btn-success">Применить</button>
            </form>
            @foreach($orders as $order)
                <tr>

                    <td>{{$order->id}}</td>
                    <td>{{$order->user->name}}</td>
                    <td>{{$order->user->phone}}</td>
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
