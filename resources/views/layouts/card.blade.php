<div class="col">
    <div class="card shadow-lg border-0">
        <a class="text-decoration-none text-reset" href="{{route('product', [$product->category->code, $product->code])}}">
        <img src="{{ Storage::url($product->image) }}" width="100%" height="380px">

        <div class="card-body">
            <h5 class="card-text">{{$product->name}}</h5>
            <p class="m-1">бренд: {{$product->values->where('property_id', $propertyIdBrand)->first()->name}}</p>
            <p class="m-1 ">цена: {{$product->price}} руб.</p>
        </div>
        </a>
    </div>
</div>

