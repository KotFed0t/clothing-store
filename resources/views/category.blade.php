@extends('layouts.master')

@section('content')
    <h2 class="text-center mt-5">{{ $category->name }} - category page</h2>

    <div class="album py-5">
        <div class="container">
            <div class="row row-cols-1 row-cols-sm-2 row-cols-md-3 g-3">
                @foreach($category->products as $product)
                    @include('layouts.card')
                @endforeach
            </div>
        </div>
    </div>
@endsection


