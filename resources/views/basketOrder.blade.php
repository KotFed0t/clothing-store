@extends('layouts.master')

@section('content')

    <h1 class="text-center mt-5 mb-2">Подтвердите заказ</h1>

    <p class="text-center mb-5">Общая стоимость: {{$order->getFullPrice()}} руб.</p>

    <form action="{{route('basket-confirm')}}" method="POST">
        @csrf
        <div class="row justify-content-center">
            <div class="col-3 mb-3">
                <label for="name" class="form-label">Имя</label>
                <input type="text" class="form-control" id="name" name="name">
            </div>
            <div class="w-100"></div>
            <div class="col-3 mb-3">
                <label for="phone" class="form-label">Номер телефона</label>
                <input type="tel" class="form-control" id="phone" name="phone">
            </div>
            <div class="w-100"></div>
            <button type="submit" class="btn btn-primary col-2 mb-3">Submit</button>
        </div>
    </form>
@endsection
