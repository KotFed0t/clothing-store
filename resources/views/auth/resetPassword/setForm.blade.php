@extends('layouts.master')

@section('content')
    <section class="vh-100 bg-image">
        <div class="mask d-flex align-items-center h-100 gradient-custom-3">
            <div class="container h-100">
                <div class="row d-flex justify-content-center align-items-center h-100">
                    <div class="col-12 col-md-9 col-lg-7 col-xl-6">
                        <div class="card" style="border-radius: 15px;">
                            <div class="card-body p-5">
                                <h2 class="text-uppercase text-center mb-5">Сменить пароль</h2>

                                <form action="{{route('resetPasswordSet')}}" method="POST">
                                    @csrf
                                    @error('password')
                                    <p class="text-danger">{{$message}}</p>
                                    @enderror
                                    <div class="form-outline mb-5">
                                        <input name="password" type="password" id="form3Example4cg" class="form-control form-control-lg" placeholder="Новый пароль"/>
                                    </div>


                                    @error('password_confirmation')
                                    <p class="text-danger">{{$message}}</p>
                                    @enderror
                                    <div class="form-outline mb-5">
                                        <input name="password_confirmation" type="password" id="form3Example4cdg" class="form-control form-control-lg" placeholder="Повторите пароль"/>
                                    </div>



                                    <div class="d-flex justify-content-center">
                                        <button type="submit"
                                                class="btn bg-dark text-white btn-lg px-5">
                                            сохранить
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
