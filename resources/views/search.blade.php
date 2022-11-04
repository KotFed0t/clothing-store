@extends('layouts.master')

@section('content')
    @if($products->isempty())
        <h3>По вашему запросу не нашлось товаров</h3>
    @else
        <h3 class="mb-5">Найденные товары по запросу "{{request()->get('search')}}"</h3>
        <div class="row row-cols-2 row-cols-sm-3 row-cols-md-4 g-3 mb-5">
            @foreach($products as $product)
                @include('layouts.card', compact('product'))
            @endforeach
        </div>
        <div class="d-flex align-items-center justify-content-center">{{ $products->links() }}</div>
    @endif
@endsection
