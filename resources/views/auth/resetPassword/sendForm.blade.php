@extends('layouts.master')

@section('content')
    <section class="vh-100 bg-image">
        <div class="mask d-flex align-items-center h-100 gradient-custom-3">
            <div class="container h-100">
                <div class="row d-flex justify-content-center align-items-center h-100">
                    <div class="col-12 col-md-9 col-lg-7 col-xl-6">
                        <div class="card" style="border-radius: 15px;">
                            <div class="card-body p-5">
                                <h2 class="text-uppercase text-center mb-5">Войти</h2>

                                <form action="{{route('resetPasswordSend')}}" method="POST">
                                    @csrf

                                    <div class="form-outline mb-4">
                                        <input name="email" type="email" value="{{old('email')}}" id="form3Example3cg" class="form-control form-control-lg"/>
                                        <label class="form-label" for="form3Example3cg">Email</label>
                                    </div>

                                    @error('email')
                                    <p class="text-red-500">{{$message}}</p>
                                    @enderror


                                    <img class="mb-2" src="data:image/png;base64,{{$captchaImg}}" style="width: 200px; border-radius: .25rem;">
                                    <div class="form-outline mb-4">
                                        <input name="captcha" type="text" id="form3Example3cg" class="form-control form-control-lg"/>
                                        <label class="form-label" for="form3Example3cg">Введите текст капчи</label>
                                    </div>

                                    @error('captcha')
                                    <p class="text-red-500">{{$message}}</p>
                                    @enderror

                                    <div class="d-flex justify-content-center">
                                        <button type="submit"
                                                class="btn btn-success btn-block btn-lg gradient-custom-4 text-body">
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