Вами был сформирован заказ с id:{{$order->id}} на сайте Clothing-store.<br>
Детали заказа:
<table>
    <tr>
        <th>товар</th>
        <th>количество</th>
        <th>цена</th>
        <th>стоимость</th>
    </tr>
@foreach($order->products as $product)
        <tr>
            <td>{{$product->name}}</td>
            <td>{{$product->pivot->count}}</td>
            <td>{{$product->price}} руб.</td>
            <td>{{$product->getPriceForCount()}} руб.</td>
        </tr>
@endforeach
    <tr>
        <td>Общая стоимость:</td>
        <td>{{$order->getFullPrice()}} руб.</td>
    </tr>
</table>
Если все верно - то для продолжения оформления заказа введите код подтверждения: <strong>{{$code}}</strong> на сайте.
