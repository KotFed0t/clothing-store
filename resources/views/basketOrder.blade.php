@extends('layouts.master')

@section('content')

    <h3 class="text-center mt-5 mb-2">Введите адрес доставки и подтвердите заказ</h3>

    <p class="text-center mb-5">Общая стоимость: {{$order->getFullPrice()}} руб.</p>

    <form action="{{route('basket-confirm')}}" method="POST">
        @csrf
        <div class="row justify-content-center">
            @error('country')
            <p class="text-red-500">{{$message}}</p>
            @enderror
            <div class="col-3 mb-3">
                <label for="country" class="form-label">Страна</label>
                <input type="text" class="form-control" id="country" name="country" value="{{old('country')}}">
            </div>
            <div class="w-100"></div>
            @error('city')
            <p class="text-red-500">{{$message}}</p>
            @enderror
            <div class="col-3 mb-3">
                <label for="city" class="form-label">Город</label>
                <input type="text" class="form-control" id="city" name="city" value="{{old('city')}}">
            </div>
            <div class="w-100"></div>
            @error('address')
            <p class="text-red-500">{{$message}}</p>
            @enderror
            <div class="col-3 mb-3">
                <label for="address" class="form-label">Адрес</label>
                <input type="text" class="form-control" id="address" name="address" value="{{old('address')}}">
            </div>
            <div class="w-100"></div>
            @error('postal_code')
            <p class="text-red-500">{{$message}}</p>
            @enderror
            <div class="col-3 mb-3">
                <label for="postal_code" class="form-label">Почтовый индекс</label>
                <input type="text" class="form-control" id="postal_code" name="postal_code" value="{{old('postal_code')}}">
            </div>
            <div class="w-100"></div>
            <button type="submit" class="btn btn-primary col-2 mb-3">Submit</button>
        </div>
    </form>
@endsection
