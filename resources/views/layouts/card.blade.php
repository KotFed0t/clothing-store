<div class="col">
    <div class="card shadow-sm">
        <img src="{{ Storage::url($product->image) }}" width="100%" height="225px">

        <div class="card-body">
            <h5 class="card-text">{{$product->name}}</h5>
            <p>категория: {{$product->category->name}}</p>
            <p>цена: {{$product->price}} руб.</p>
            <div class="d-flex justify-content-between align-items-center">
                <div class="btn-group">
                    <form action="{{route('basket-add', $product)}}" method="POST">
                        <button type="submit" class="btn btn-sm btn-outline-secondary">В корзину
                        </button>
                        <a type="button" href="{{route('product', [$product->category->code, $product->code])}}" class="btn btn-sm btn-outline-secondary">Подронее</a>
                        @csrf
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

