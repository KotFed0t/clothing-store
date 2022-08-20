@extends('layouts.master')

@section('content')
    <div class="album py-5">
        <div class="container">
            <div class="row row-cols-1 row-cols-sm-2 row-cols-md-3 g-3">
                @foreach($products as $product)
                    @include('layouts.card', compact('product'))
                @endforeach
            </div>
        </div>
    </div>
@endsection



