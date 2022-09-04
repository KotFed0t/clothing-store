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
                                    <div class="form-outline mb-4">
                                        <input name="name" value="{{old('name')}}" type="text" id="form3Example1cg" class="form-control form-control-lg" />
                                        <label class="form-label" for="form3Example1cg">Имя</label>
                                    </div>

                                    @error('name')
                                        <p class="text-red-500">{{$message}}</p>
                                    @enderror

                                    <div class="form-outline mb-4">
                                        <input name="email" value="{{old('email')}}" type="email" id="form3Example3cg" class="form-control form-control-lg" />
                                        <label class="form-label" for="form3Example3cg">Email</label>
                                    </div>

                                    @error('email')
                                    <p class="text-red-500">{{$message}}</p>
                                    @enderror

                                    <div class="form-outline mb-4">
                                        <input name="phone" value="{{old('phone')}}" type="tel" id="form3Example3cg" class="form-control form-control-lg" />
                                        <label class="form-label" for="form3Example3cg">Телефон</label>
                                    </div>

                                    @error('phone')
                                    <p class="text-red-500">{{$message}}</p>
                                    @enderror

                                    <div class="form-outline mb-4">
                                        <input name="password" type="password" id="form3Example4cg" class="form-control form-control-lg" />
                                        <label class="form-label" for="form3Example4cg">Пароль</label>
                                    </div>

                                    @error('password')
                                    <p class="text-red-500">{{$message}}</p>
                                    @enderror

                                    <div class="form-outline mb-4">
                                        <input name="password_confirmation" type="password" id="form3Example4cdg" class="form-control form-control-lg" />
                                        <label class="form-label" for="form3Example4cdg">Повторите пароль</label>
                                    </div>

                                    @error('password_confirmation')
                                    <p class="text-red-500">{{$message}}</p>
                                    @enderror

                                    <div class="d-flex justify-content-center">
                                        <button type="submit"
                                                class="btn btn-success btn-block btn-lg gradient-custom-4 text-body">Зарегистрироваться</button>
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
