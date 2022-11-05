@extends('layouts.master')

@section('content')
    {{--    <h1 class="text-center mt-5">Product page</h1>--}}
    {{--    <h2>Название продукта: {{$product->name}}</h2>--}}
    {{--    <h3>Описание продукта:</h3>--}}
    {{--    <p>{{$product->description}}</p>--}}
    {{--    <form action="{{route('basket-add', $product->id)}}" method="POST">--}}
    {{--        @csrf--}}
    {{--        <div class="input-group row">--}}
    {{--            <label for="size_id" class="col-sm-2 col-form-label">Размер: </label>--}}
    {{--            <div class="col-sm-6">--}}
    {{--                <select name="size_id" id="size_id" class="form-control">--}}
    {{--                    @foreach($sizeValues as $value)--}}
    {{--                        <option value="{{ $value->id }}">{{ $value->name }}</option>--}}
    {{--                    @endforeach--}}
    {{--                </select>--}}
    {{--            </div>--}}
    {{--        </div>--}}
    {{--        <button class="btn btn-success mt-3">Добавить в корзину</button>--}}
    {{--    </form>--}}
    <div class="container py-5">
        <div class="row mb-5">
            <div class="col-lg-6">
                <!-- PRODUCT SLIDER-->
                <div class="row m-sm-0">
                    <div class="col-sm-2 p-sm-0 order-2 order-sm-1 mt-2 mt-sm-0 px-xl-2">
                        <div
                            class="swiper product-slider-thumbs swiper-initialized swiper-vertical swiper-pointer-events swiper-thumbs">
                            <div class="swiper-wrapper" id="swiper-wrapper-a46b430971a0ab79" aria-live="polite"
                                 style="transform: translate3d(0px, 0px, 0px); transition-duration: 0ms;">
                                <div
                                    class="swiper-slide h-auto swiper-thumb-item mb-3 swiper-slide-visible swiper-slide-active swiper-slide-thumb-active"
                                    role="group" aria-label="1 / 4" style="height: 371px;"><img class="w-100"
                                                                                                src="{{Storage::url($product->image)}}"
                                                                                                alt="..."></div>
                                @foreach($product->images() as $image)
                                <div
                                    class="swiper-slide h-auto swiper-thumb-item mb-3 swiper-slide-visible swiper-slide-next"
                                    role="group" aria-label="2 / 4" style="height: 371px;"><img class="w-100"
                                                                                                src="{{Storage::url($image)}}"
                                                                                                alt="..."></div>
                                @endforeach

                            </div>
                            <span class="swiper-notification" aria-live="assertive" aria-atomic="true"></span></div>
                    </div>
                    <div class="col-sm-10 order-1 order-sm-2">
                        <div class="swiper product-slider swiper-initialized swiper-horizontal swiper-pointer-events">
                            <div class="swiper-wrapper" id="swiper-wrapper-878fd211b65ae928" aria-live="polite"
                                 style="transform: translate3d(0px, 0px, 0px); transition-duration: 0ms;">
                                <div class="swiper-slide h-auto swiper-slide-active" role="group" aria-label="1 / 4"
                                     style="width: 428px;"><a class="glightbox product-view"
                                                              href="{{Storage::url($product->image)}}"
                                                              data-gallery="gallery2"
                                                              data-glightbox="Product item 1"><img class="img-fluid"
                                                                                                   src="{{Storage::url($product->image)}}"
                                                                                                   alt="..."></a></div>
                                @foreach($product->images() as $image)
                                <div class="swiper-slide h-auto swiper-slide-next" role="group" aria-label="2 / 4"
                                     style="width: 428px;"><a class="glightbox product-view"
                                                              href="{{Storage::url($image)}}"
                                                              data-gallery="gallery2"
                                                              data-glightbox="Product item 2"><img class="img-fluid"
                                                                                                   src="{{Storage::url($image)}}"
                                                                                                   alt="..."></a></div>
                                @endforeach

                            </div>
                            <span class="swiper-notification" aria-live="assertive" aria-atomic="true"></span></div>
                    </div>
                </div>
            </div>
            <!-- PRODUCT DETAILS-->
            <div class="col-lg-6 px-5">

                <h2 class="text-start">{{$product->name}}</h2>
                <p class="text-secondary text-uppercase text-start">Бренд {{$product->values->where('property_id', $propertyIdBrand)->first()->name}}</p>
                <p class="text-secondary mb-4 text-start">Цена: {{$product->price}} руб.</p>

                <form action="{{route('basket-add', $product->id)}}" method="POST">
                    @csrf
                    <div class="input-group row justify-content-left">
                        <label for="size_id" class="col-sm-2 col-form-label text-secondary">Размер:</label>
                        <div class="col-sm-4 p-0 ">
                            <select name="size_id" id="size_id" class="form-control">
                                @foreach($sizeValues as $value)
                                    <option value="{{ $value->id }}">{{ $value->name }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <div class="text-start mt-2">
                    <button class="btn bg-dark text-white mt-3 ">Добавить в корзину</button>
                    </div>
                </form>

            </div>
        </div>
        <!-- DETAILS TABS-->
        <p class="bg-dark text-white p-2 m-0 text-uppercase w-25">Описание</p>
        <div class="bg-light pb-3">
            <p class="text-start p-3 w-75">
                {{$product->description}}
            </p>
            <h4 class="text-start p-3">Характеристики товара</h4>
            <div class="text-start">
                <div class="row p-3">
                    <div class="col-lg-4 col-xs-12">
                        <p class="mb-0 text-uppercase">Бренд</p>
                        <hr class="p-0 m-0">
                    </div>
                    <div class="col-lg-4 col-xs-12">
                        <p class="mb-0 text-uppercase">{{$product->values->where('property_id', $propertyIdBrand)->first()->name}}</p>
                    </div>
                </div>
                <div class="row p-3">
                    <div class="col-lg-4 col-xs-12">
                        <p class="mb-0 text-uppercase">Материал</p>
                        <hr class="p-0 m-0">
                    </div>
                    <div class="col-lg-4 col-xs-12">
                        <p class="mb-0 text-uppercase">{{$product->values->where('property_id', $propertyIdMaterial)->first()->name}}</p>
                    </div>
                </div>
                <div class="row p-3">
                    <div class="col-lg-4 col-xs-12">
                        <p class="mb-0 text-uppercase">Цвет</p>
                        <hr class="p-0 m-0">
                    </div>
                    <div class="col-lg-4 col-xs-12">
                        <p class="mb-0 text-uppercase">{{$product->values->where('property_id', $propertyIdColor)->first()->name}}</p>
                    </div>
                </div>
                <div class="row p-3">
                    <div class="col-lg-4 col-xs-12">
                        <p class="mb-0 text-uppercase">Размеры</p>
                        <hr class="p-0 m-0">
                    </div>
                    <div class="col-lg-4 col-xs-12">
                        <p class="mb-0 text-uppercase">
                            @foreach($sizeValues as $value)
                                {{ $value->name }} &nbsp;
                            @endforeach
                        </p>
                    </div>
                </div>

            </div>
        </div>
    </div>
@endsection

