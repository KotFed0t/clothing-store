@extends('layouts.master')

@section('content')
    <h3 class="text-center mt-5">Детали заказа</h3>

    <table class="table table-striped mt-3">
        <thead>
        <tr>
            <th scope="col">ID</th>
            <th scope="col">Имя</th>
            <th scope="col">Телефон</th>
            <th scope="col">Дата</th>
            <th scope="col">Адрес доставки</th>
            <th scope="col">Сумма</th>
            <th scope="col">Статус</th>
        </tr>
        </thead>
        <tbody>
        @isset($order)
            <tr>

                <td>{{$order->id}}</td>
                <td>{{$order->user->name}}</td>
                <td>{{$order->user->phone}}</td>
                <td>{{$order->updated_at}}</td>
                <td>{{"$order->country, $order->city, $order->address. Индекс: $order->postal_code"}}</td>
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
            <th scope="col">Бренд</th>
            <th scope="col">Размер</th>
            <th scope="col">Количество</th>
            <th scope="col">Цена</th>
            <th scope="col">Стоимость</th>
        </tr>
        </thead>
        <tbody>
        @isset($products)
            @foreach($products as $product)
                <tr>
                    <td valign="middle"><img src="{{Storage::url($product->image)}}" width="80px" height="80px"> <a class="text-decoration-none"
                            href="{{route('product', [$product->category->code, $product->code])}}">{{$product->name}}</a></td>
                    <td valign="middle">{{$product->category->name}}</td>
                    <td valign="middle">{{$product->values->where('property_id', $propertyIdBrand)->first()->name}}</td>
                    <td valign="middle">{{\App\Models\Value::getSizeName($product->pivot->size_id)}}</td>
                    <td valign="middle">{{$product->pivot->count}}</td>
                    <td valign="middle">{{$product->price}}</td>
                    <td valign="middle">{{$product->getPriceForCount()}}</td>
                </tr>
            @endforeach
        @endisset
        </tbody>
    </table>
@endsection
