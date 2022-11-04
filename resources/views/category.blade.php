@extends('layouts.master')

@section('content')
    @isset($genderOnly)
        <h2 class="text-center ">Одежда для @if($genderOnly == 'man') мужчин@endif @if($genderOnly == 'woman') женщин@endif</h2>
    @endisset
    @isset($category)
        <h2 class="text-center">{{ $category->name }} для @if($gender == 'man') мужчин@endif @if($gender == 'woman') женщин@endif</h2>
    @endisset
    <div class="row">
        <div class="col-md-3 mt-5">
            <form action="" method="get">

                <h5>Сортировать по:</h5>
                <select name="sort" class="form-select mb-4" aria-label="Default select example">
                    <option value="0">По умолчанию</option>
                    <option value="price_asc" @if(request()->sort == 'price_asc') selected @endif>По возрастанию цены</option>
                    <option value="price_desc" @if(request()->sort == 'price_desc') selected @endif>По убыванию цены</option>
                    <option value="name_asc" @if(request()->sort == 'name_asc') selected @endif>Название (А - Я)</option>
                    <option value="name_desc" @if(request()->sort == 'name_desc') selected @endif>Название (Я - А)</option>
                </select>
                <!-- Section: Sidebar -->
                <h5 class="mb-4">Фильтровать по:</h5>
                @foreach($properties as $property)
                    <section class="mb-4">
                        <h6 class="font-weight-bold mb-3">{{$property->name}}</h6>
                        @foreach($property->values as $value)
                            <div class="form-check mb-2">
                                <input name="{{$property->name}}_id[]" class="form-check-input" type="checkbox" value="{{$value->id}}"
                                       @if(request()->has($property->name.'_id'))
                                           @if(in_array($value->id, request()->get($property->name.'_id')))
                                               checked
                                           @endif
                                       @endif id="condition-checkbox">
                                <label class="form-check-label text-uppercase small text-muted" for="condition-checkbox">
                                    {{$value->name}}
                                </label>
                            </div>
                        @endforeach
                    </section>
                @endforeach
                <button class="btn btn-dark">Применить</button>
                <a href="{{request()->url()}}" class="btn btn-outline-secondary"><span class="text-dark">Сбросить фильтры</span></a>
            </form>
        </div>

        <div class="col-md-9">
            <div class="album py-5">
                <div class="container">
                    <div class="row row-cols-1 row-cols-sm-2 row-cols-md-3 g-3">
                        @foreach($products as $product)
                            @include('layouts.card')
                        @endforeach
                    </div>
                </div>
            </div>
            <div class="d-flex align-items-center justify-content-center">{{ $products->links() }}</div>
        </div>
    </div>
@endsection


