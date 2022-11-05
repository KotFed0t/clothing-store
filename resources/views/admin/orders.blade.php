@extends('admin.layouts.master')

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
            <h5 class="text-start">Фильтр по статусам:</h5>
            <form action="{{route('admin.orders')}}">
                <div class="row">
                    <div class="col-sm-3">
                        <select name="status_id" class="form-select mb-5" aria-label="Default select example">
                            <option value="0">По умолчанию</option>
                            <option value="1" @if(request()->status_id == '1') selected @endif>Оформленные</option>
                            <option value="2" @if(request()->status_id == '2') selected @endif>В процессе
                                комлпектации
                            </option>
                            <option value="3" @if(request()->status_id == '3') selected @endif>Переданы в доставку
                            </option>
                            <option value="4" @if(request()->status_id == '4') selected @endif>Доставлен</option>
                            <option value="5" @if(request()->status_id == '5') selected @endif>Возврат</option>
                        </select>
                    </div>
                    <div class="col-sm-1">
                        <button class="btn bg-dark text-white">Применить</button>
                    </div>
                </div>

            </form>
            @foreach($orders as $order)
                <tr>

                    <td>{{$order->id}}</td>
                    <td>{{$order->user->name}}</td>
                    <td>{{$order->user->phone}}</td>
                    <td>{{$order->updated_at}}</td>
                    <td>{{$order->getFullPrice()}}</td>
                    <td>{{$order->getStatusName()}}</td>
                    <td><a href="{{route('admin.orderDetails', $order->id)}}" class="btn bg-dark text-white">Открыть</a></td>
                </tr>
            @endforeach
        @endisset
        </tbody>
    </table>
@endsection
