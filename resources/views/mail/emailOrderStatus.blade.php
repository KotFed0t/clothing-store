@if($order->status != 0)
    Ваш заказ с id:{{$order->id}} перешел в статус: {{$order->getStatusName()}}. <br>
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
@else
    По вашему заказу с id:{{$order->id}} не прошла оплата, просим вас попробовать оформить заказ еще раз. <br>
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
@endif
