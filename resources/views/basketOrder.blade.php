@extends('layouts.master')

@section('content')

{{--    <h3 class="text-center mt-5 mb-2">Введите адрес доставки и подтвердите заказ</h3>--}}

{{--    <p class="text-center mb-5">Общая стоимость: {{$order->getFullPrice()}} руб.</p>--}}

{{--    <form action="{{route('basket-confirm')}}" method="POST">--}}
{{--        @csrf--}}
{{--        <div class="row justify-content-center">--}}
{{--            @error('country')--}}
{{--            <p class="text-red-500">{{$message}}</p>--}}
{{--            @enderror--}}
{{--            <div class="col-3 mb-3">--}}
{{--                <label for="country" class="form-label">Страна</label>--}}
{{--                <input type="text" class="form-control" id="country" name="country" value="{{old('country')}}">--}}
{{--            </div>--}}
{{--            <div class="w-100"></div>--}}
{{--            @error('city')--}}
{{--            <p class="text-red-500">{{$message}}</p>--}}
{{--            @enderror--}}
{{--            <div class="col-3 mb-3">--}}
{{--                <label for="city" class="form-label">Город</label>--}}
{{--                <input type="text" class="form-control" id="city" name="city" value="{{old('city')}}">--}}
{{--            </div>--}}
{{--            <div class="w-100"></div>--}}
{{--            @error('address')--}}
{{--            <p class="text-red-500">{{$message}}</p>--}}
{{--            @enderror--}}
{{--            <div class="col-3 mb-3">--}}
{{--                <label for="address" class="form-label">Адрес</label>--}}
{{--                <input type="text" class="form-control" id="address" name="address" value="{{old('address')}}">--}}
{{--            </div>--}}
{{--            <div class="w-100"></div>--}}
{{--            @error('postal_code')--}}
{{--            <p class="text-red-500">{{$message}}</p>--}}
{{--            @enderror--}}
{{--            <div class="col-3 mb-3">--}}
{{--                <label for="postal_code" class="form-label">Почтовый индекс</label>--}}
{{--                <input type="text" class="form-control" id="postal_code" name="postal_code" value="{{old('postal_code')}}">--}}
{{--            </div>--}}
{{--            <div class="w-100"></div>--}}
{{--            <button type="submit" class="btn btn-primary col-2 mb-3">Submit</button>--}}
{{--        </div>--}}
{{--    </form>--}}

    <section class="vh-100 bg-image">
        <div class="mask d-flex align-items-center h-100 gradient-custom-3">
            <div class="container h-100">
                <div class="row d-flex justify-content-center align-items-center h-100">
                    <div class="col-12 col-md-9 col-lg-7 col-xl-6">
                        <div class="card" style="border-radius: 15px;">
                            <div class="card-body p-5">
                                <h3 class="text-uppercase text-center mb-3">Введите адрес доставки и подтвердите заказ</h3>
                                <p class="text-center mb-5">Общая стоимость: {{$order->getFullPrice()}} руб.</p>
                                <form action="{{route('basket-confirm')}}" method="POST">
                                    @csrf

                                    @error('country')
                                    <p class="text-danger">{{$message}}</p>
                                    @enderror
                                    <div class="form-outline mb-5">
                                        <input name="country" value="{{old('country')}}" type="text" id="form3Example1cg" class="form-control form-control-lg" placeholder="Страна"/>
                                    </div>


                                    @error('city')
                                    <p class="text-danger">{{$message}}</p>
                                    @enderror
                                    <div class="form-outline mb-5">
                                        <input name="city" value="{{old('city')}}" type="text" id="form3Example3cg" class="form-control form-control-lg" placeholder="Город" />
                                    </div>

                                    @error('address')
                                    <p class="text-danger">{{$message}}</p>
                                    @enderror
                                    <div class="form-outline mb-5">
                                        <input name="address" value="{{old('address')}}" type="text" id="form3Example3cg" class="form-control form-control-lg" placeholder="Адрес"/>
                                    </div>


                                    @error('postal_code')
                                    <p class="text-danger">{{$message}}</p>
                                    @enderror
                                    <div class="form-outline mb-5">
                                        <input name="postal_code" type="text" id="form3Example3cg" class="form-control form-control-lg" placeholder="Почтовый индекс"/>
                                    </div>



                                    <div class="d-flex justify-content-center">
                                        <button type="submit"
                                                class="btn bg-dark text-white btn-lg px-5">
                                            Далее
                                        </button>
                                    </div>

                                </form>

                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection
