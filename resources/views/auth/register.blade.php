@extends('layouts.master')

@section('content')
    <section class="vh-100 bg-image">
        <div class="mask d-flex align-items-center h-100 gradient-custom-3">
            <div class="container h-100">
                <div class="row d-flex justify-content-center align-items-center h-100">
                    <div class="col-12 col-md-9 col-lg-7 col-xl-6">
                        <div class="card" style="border-radius: 15px;">
                            <div class="card-body p-5">
                                <h2 class="text-uppercase text-center mb-5">Зарегистрироваться</h2>

                                <form action="{{route('register_process')}}" method="POST">
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


                                    @error('password')
                                    <p class="text-danger">{{$message}}</p>
                                    @enderror
                                    <div class="form-outline mb-5">
                                        <input name="password" type="password" id="form3Example4cg" class="form-control form-control-lg" placeholder="Пароль"/>
                                    </div>


                                    @error('password_confirmation')
                                    <p class="text-danger">{{$message}}</p>
                                    @enderror
                                    <div class="form-outline mb-4">
                                        <input name="password_confirmation" type="password" id="form3Example4cdg" class="form-control form-control-lg" placeholder="Повторите пароль"/>
                                    </div>



                                    <img class="mb-2" src="data:image/png;base64,{{$captchaImg}}" style="width: 200px; border-radius: .25rem;">
                                    @error('captcha')
                                    <p class="text-danger">{{$message}}</p>
                                    @enderror
                                    <div class="form-outline mb-5">
                                        <input name="captcha" type="text" id="form3Example3cg" class="form-control form-control-lg" placeholder="Введите текст капчи"/>
                                    </div>



                                    <div class="d-flex justify-content-center">
                                        <button type="submit"
                                                class="btn bg-dark text-white btn-block btn-lg px-5">Зарегистрироваться</button>
                                    </div>

                                    <p class="text-center text-muted mt-5 mb-0">Уже есть аккаунт? <a href="{{route('login')}}"
                                                                                                            class="fw-bold text-body"><u>Войти</u></a></p>

                                </form>

                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection
