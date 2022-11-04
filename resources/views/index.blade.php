@extends('layouts.master')

@section('content')

    <img class="d-block w-100 pb-5" src="mainBanner.png" alt="Second slide">

    <h3 class="small text-muted small text-uppercase mb-1">Дизайнерские коллекции</h3>
    <h2 class="h5 text-uppercase mb-4">Большой выбор ассортимента</h2>

    <div class="container mt-5 mb-5">
        <div class="row g-0">
            <div class="col-md-6">
                <a href="{{route('categoryGender', 'woman')}}">
                    <div><img class="img-fluid" src="her.png" width="790" alt="..."></div>
                </a>
            </div>
            <div class="col-md-6">
                <a href="{{route('categoryGender', 'man')}}">
                    <div><img class="img-fluid" src="him.png" width="790" alt="..."></div>
                </a>
            </div>
        </div>
    </div>

    <h2 class="h5 text-uppercase text-start mb-5">Популярные товары</h2>



    <div class="row row-cols-2 row-cols-sm-3 row-cols-md-4 g-3">
        @foreach($products as $product)
            @include('layouts.card', compact('product'))
        @endforeach
    </div>

@endsection




