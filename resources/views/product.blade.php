@extends('layouts.master')

@section('content')
    <h1 class="text-center mt-5">Product page</h1>
    <h2>Название продукта: {{$product->name}}</h2>
    <h3>Описание продукта:</h3>
    <p>{{$product->description}}</p>
    <form action="{{route('basket-add', $product->id)}}" method="POST">
        @csrf
        <div class="input-group row">
            <label for="size_id" class="col-sm-2 col-form-label">Размер: </label>
            <div class="col-sm-6">
                <select name="size_id" id="size_id" class="form-control">
                    @foreach($sizeValues as $value)
                        <option value="{{ $value->id }}">{{ $value->name }}</option>
                    @endforeach
                </select>
            </div>
        </div>
        <button class="btn btn-success mt-3">Добавить в корзину</button>
    </form>

@endsection

