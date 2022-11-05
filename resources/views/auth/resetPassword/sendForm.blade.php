@extends('layouts.master')

@section('content')
    <section class="vh-100 bg-image">
        <div class="mask d-flex align-items-center h-100 gradient-custom-3">
            <div class="container h-100">
                <div class="row d-flex justify-content-center align-items-center h-100">
                    <div class="col-12 col-md-9 col-lg-7 col-xl-6">
                        <div class="card" style="border-radius: 15px;">
                            <div class="card-body p-5">
                                <h2 class="text-uppercase text-center mb-5">Восстановить пароль</h2>

                                <form action="{{route('resetPasswordSend')}}" method="POST">
                                    @csrf
                                    @error('email')
                                    <p class="text-danger">{{$message}}</p>
                                    @enderror
                                    <div class="form-outline mb-4">
                                        <input name="email" type="email" value="{{old('email')}}" id="form3Example3cg" class="form-control form-control-lg" placeholder="Email"/>
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
