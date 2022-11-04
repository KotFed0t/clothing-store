@extends('layouts.master')

@section('content')
    <h1 class="text-center mt-5">Корзина</h1>

    <table class="table table-striped">
        <thead>
        <tr>
            <th scope="col">Название</th>
            <th scope="col">Бренд</th>
            <th scope="col">Размер</th>
            <th scope="col">Количество</th>
            <th scope="col">Цена</th>
            <th scope="col">Стоимость</th>
        </tr>
        </thead>
        <tbody>
        @isset($order)
            @foreach($order->products as $product)
                <tr>
                    <td valign="middle" scope="row">
                        <img src="{{Storage::url($product->image)}}" width="80px" height="80px">
                        <a class="text-decoration-none" href="{{route('product', [$product->category->code, $product->code])}}">{{$product->name}}</a>
                    </td>
                   <td valign="middle">{{$product->values->where('property_id', $propertyIdBrand)->first()->name}}</td>

                    <td valign="middle" scope="row">
                        <p>{{\App\Models\Value::getSizeName($product->pivot->size_id)}}</p>
                    </td>
                    <td valign="middle">
                        <span class="badge bg-dark">{{$product->pivot->count}}</span>
                        <div class="btn-group">
                            <form action="{{route('basket-add', [$product, $product->pivot->size_id])}}" method="POST">
                                <button type="submit" class="btn btn-outline-secondary">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor"
                                         class="bi bi-plus-square" viewBox="0 0 16 16">
                                        <path
                                            d="M14 1a1 1 0 0 1 1 1v12a1 1 0 0 1-1 1H2a1 1 0 0 1-1-1V2a1 1 0 0 1 1-1h12zM2 0a2 2 0 0 0-2 2v12a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V2a2 2 0 0 0-2-2H2z"></path>
                                        <path
                                            d="M8 4a.5.5 0 0 1 .5.5v3h3a.5.5 0 0 1 0 1h-3v3a.5.5 0 0 1-1 0v-3h-3a.5.5 0 0 1 0-1h3v-3A.5.5 0 0 1 8 4z"></path>
                                    </svg>
                                    <span class="visually-hidden">Кнопка</span>
                                </button>
                                @csrf
                            </form>
                            <form action="{{route('basket-remove', [$product, $product->pivot->size_id])}}" method="POST">
                                <button type="submit" class="btn btn-outline-secondary">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor"
                                         class="bi bi-dash-square" viewBox="0 0 16 16">
                                        <path
                                            d="M14 1a1 1 0 0 1 1 1v12a1 1 0 0 1-1 1H2a1 1 0 0 1-1-1V2a1 1 0 0 1 1-1h12zM2 0a2 2 0 0 0-2 2v12a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V2a2 2 0 0 0-2-2H2z"/>
                                        <path d="M4 8a.5.5 0 0 1 .5-.5h7a.5.5 0 0 1 0 1h-7A.5.5 0 0 1 4 8z"/>
                                    </svg>
                                    <span class="visually-hidden">Кнопка</span>
                                    @csrf
                                </button>
                            </form>

                        </div>
                    </td>
                    <td valign="middle">{{$product->price}} руб.</td>
                    <td valign="middle">{{$product->getPriceForCount()}} руб.</td>
                </tr>
            @endforeach
            <tr>
                <td colspan="3">Общая стоимость:</td>
                <td>{{$order->getFullPrice()}} руб.</td>
            </tr>
        @endisset

        </tbody>
    </table>
    <br>
    <div class="btn-group float-end">
        <a href="{{route('basket-place')}}" type="button" class="btn btn-dark">Оформить заказ</a>
    </div>
@endsection
