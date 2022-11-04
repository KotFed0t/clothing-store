@extends('layouts.master')

@section('content')
    <section class="vh-100 bg-image">
        <div class="mask d-flex align-items-center h-100 gradient-custom-3">
            <div class="container h-100">
                <div class="row d-flex justify-content-center align-items-center h-100">
                    <div class="col-12 col-md-9 col-lg-7 col-xl-6">
                        <div class="card" style="border-radius: 15px;">
                            <div class="card-body p-5">
                                <h2 class="text-uppercase text-center mb-5">Двухфакторная аутентификация</h2>

                                @isset($fromLogin)
                                    <form action="{{route('loginCheck2Fa')}}" method="POST">
                                @endisset

                                @isset($fromResetPassword)
                                    <form action="{{route('resetPasswordCheck2Fa')}}" method="POST">
                                @endisset

                                @isset($fromOrder)
                                    <form action="{{route('orderCheck2Fa')}}" method="POST">
                                @endisset

                                    @csrf
                                    <div class="form-outline mb-4">
                                        <input name="email_code" value="{{old('email_code')}}" id="form3Example3cg" class="form-control form-control-lg"/>
                                        <label class="form-label" for="form3Example3cg">Введите код, отправленный вам на почту</label>
                                    </div>

                                    @error('email_code')
                                    <p class="text-red-500">{{$message}}</p>
                                    @enderror

                                    <div class="form-outline mb-4">
                                        <input name="googleAuthCode"  value="{{old('googleAuthCode')}}" id="form3Example4cg"
                                               class="form-control form-control-lg"/>
                                        <label class="form-label" for="form3Example4cg">Введите код из Google Authenticator</label>
                                    </div>

                                    @error('googleAuthCode')
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
