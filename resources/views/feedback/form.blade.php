@extends('layouts.master')

@section('content')

    <h3 class="text-center mt-5 mb-2">Отправьте нам сообщение</h3>

    <p class="text-center mb-5">Если у вас есть вопросы или предложения - заполните форму ниже</p>

    <form action="{{route('saveFeedback')}}" method="POST">
        @csrf
        <div class="row justify-content-center">
            @error('name')
            <p class="text-red-500">{{$message}}</p>
            @enderror
            <div class="col-3 mb-3">
                <label for="name" class="form-label">Имя</label>
                <input type="text" class="form-control" id="name" name="name" value="{{old('name')}}">
            </div>
            <div class="w-100"></div>
            @error('email')
            <p class="text-red-500">{{$message}}</p>
            @enderror
            <div class="col-3 mb-3">
                <label for="email" class="form-label">Email</label>
                <input type="text" class="form-control" id="email" name="email" value="{{old('email')}}">
            </div>
            <div class="w-100"></div>
            @error('phone')
            <p class="text-red-500">{{$message}}</p>
            @enderror
            <div class="col-3 mb-3">
                <label for="phone" class="form-label">Телефон</label>
                <input type="tel" class="form-control" id="phone" name="phone" value="{{old('phone')}}">
            </div>

            <div class="w-100"></div>
            @error('captcha')
            <p class="text-red-500">{{$message}}</p>
            @enderror
            <img class="mb-3" src="data:image/png;base64,{{$captchaImg}}" style="width: 200px; border-radius: .25rem;">
            <div class="w-100"></div>
            <div class="form-outline col-3 mb-3">
                <input name="captcha" type="text" id="form3Example3cg" class="form-control form-control-lg"/>
                <label class="form-label" for="form3Example3cg">Введите текст капчи</label>
            </div>

            <div class="w-100"></div>
            @error('text')
            <p class="text-red-500">{{$message}}</p>
            @enderror
            <div class="col-3 mb-3">
                <label for="postal_code" class="form-label">Сообщение</label>
                <textarea type="text" class="form-control" id="text" name="text">{{old('text')}}</textarea>
            </div>
            <div class="w-100"></div>
            <button type="submit" class="btn btn-primary col-2 mb-3">Отправить</button>
        </div>
    </form>
@endsection
