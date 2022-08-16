<div class="col">
    <div class="card shadow-sm">
        <svg class="bd-placeholder-img card-img-top" width="100%" height="225"
             xmlns="http://www.w3.org/2000/svg" role="img" aria-label="Placeholder: Thumbnail"
             preserveAspectRatio="xMidYMid slice" focusable="false"><title>Placeholder</title>
            <rect width="100%" height="100%" fill="#55595c"></rect>
            <text x="50%" y="50%" fill="#eceeef" dy=".3em">Thumbnail</text>
        </svg>

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

