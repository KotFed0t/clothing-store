@extends('layouts.master')

@section('content')

{{--    <h3 class="text-center mt-5 mb-2">Отправьте нам сообщение</h3>--}}

{{--    <p class="text-center mb-5">Если у вас есть вопросы или предложения - заполните форму ниже</p>--}}

{{--    <form action="{{route('saveFeedback')}}" method="POST">--}}
{{--        @csrf--}}
{{--        <div class="row justify-content-center">--}}
{{--            @error('name')--}}
{{--            <p class="text-red-500">{{$message}}</p>--}}
{{--            @enderror--}}
{{--            <div class="col-3 mb-3">--}}
{{--                <label for="name" class="form-label">Имя</label>--}}
{{--                <input type="text" class="form-control" id="name" name="name" value="{{old('name')}}">--}}
{{--            </div>--}}
{{--            <div class="w-100"></div>--}}
{{--            @error('email')--}}
{{--            <p class="text-red-500">{{$message}}</p>--}}
{{--            @enderror--}}
{{--            <div class="col-3 mb-3">--}}
{{--                <label for="email" class="form-label">Email</label>--}}
{{--                <input type="text" class="form-control" id="email" name="email" value="{{old('email')}}">--}}
{{--            </div>--}}
{{--            <div class="w-100"></div>--}}
{{--            @error('phone')--}}
{{--            <p class="text-red-500">{{$message}}</p>--}}
{{--            @enderror--}}
{{--            <div class="col-3 mb-3">--}}
{{--                <label for="phone" class="form-label">Телефон</label>--}}
{{--                <input type="tel" class="form-control" id="phone" name="phone" value="{{old('phone')}}">--}}
{{--            </div>--}}

{{--            <div class="w-100"></div>--}}
{{--            @error('captcha')--}}
{{--            <p class="text-red-500">{{$message}}</p>--}}
{{--            @enderror--}}
{{--            <img class="mb-3" src="data:image/png;base64,{{$captchaImg}}" style="width: 200px; border-radius: .25rem;">--}}
{{--            <div class="w-100"></div>--}}
{{--            <div class="form-outline col-3 mb-3">--}}
{{--                <input name="captcha" type="text" id="form3Example3cg" class="form-control form-control-lg"/>--}}
{{--                <label class="form-label" for="form3Example3cg">Введите текст капчи</label>--}}
{{--            </div>--}}

{{--            <div class="w-100"></div>--}}
{{--            @error('text')--}}
{{--            <p class="text-red-500">{{$message}}</p>--}}
{{--            @enderror--}}
{{--            <div class="col-3 mb-3">--}}
{{--                <label for="postal_code" class="form-label">Сообщение</label>--}}
{{--                <textarea type="text" class="form-control" id="text" name="text">{{old('text')}}</textarea>--}}
{{--            </div>--}}
{{--            <div class="w-100"></div>--}}
{{--            <button type="submit" class="btn btn-primary col-2 mb-3">Отправить</button>--}}
{{--        </div>--}}
{{--    </form>--}}

    <section class="vh-100 bg-image">
        <div class="mask d-flex align-items-center h-100 gradient-custom-3">
            <div class="container h-100">
                <div class="row d-flex justify-content-center align-items-center h-100">
                    <div class="col-12 col-md-9 col-lg-7 col-xl-6">
                        <div class="card" style="border-radius: 15px;">
                            <div class="card-body p-5">
                                <h2 class="text-uppercase text-center mb-5">Отправьте нам сообщение</h2>

                                <form action="{{route('saveFeedback')}}" method="POST">
                                    @csrf
                                    @error('name')
                                    <p class="text-danger">{{$message}}</p>
                                    @enderror
                                    <div class="form-outline mb-5">
                                        <input name="name" value="{{old('name')}}" type="text" id="form3Example1cg" class="form-control form-control-lg" placeholder="Имя"/>
                                    </div>


                                    @error('email')
                                    <p class="text-danger">{{$message}}</p>
                                    @enderror
                                    <div class="form-outline mb-5">
                                        <input name="email" value="{{old('email')}}" type="email" id="form3Example3cg" class="form-control form-control-lg" placeholder="Email" />
                                    </div>


                                    @error('phone')
                                    <p class="text-danger">{{$message}}</p>
                                    @enderror
                                    <div class="form-outline mb-5">
                                        <input name="phone" value="{{old('phone')}}" type="tel" id="form3Example3cg" class="form-control form-control-lg" placeholder="Телефон"/>
                                    </div>




                                    <img class="mb-2" src="data:image/png;base64,{{$captchaImg}}" style="width: 200px; border-radius: .25rem;">
                                    @error('captcha')
                                    <p class="text-danger">{{$message}}</p>
                                    @enderror
                                    <div class="form-outline mb-5">
                                        <input name="captcha" type="text" id="form3Example3cg" class="form-control form-control-lg" placeholder="Введите текст капчи"/>
                                    </div>



                                    @error('text')
                                    <p class="text-danger">{{$message}}</p>
                                    @enderror
                                    <div class="form-outline mb-5">
                                        <textarea type="text" class="form-control" id="text" name="text" placeholder="Введите сообщение">{{old('text')}}</textarea>
                                    </div>



                                    <div class="d-flex justify-content-center">
                                        <button type="submit"
                                                class="btn bg-dark text-white btn-lg px-5">
                                            Отправить
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
