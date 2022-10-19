@extends('admin.layouts.master')

@isset($value)
    @section('title', 'Редактировать значение свойства ' . $value->name)
@else
    @section('title', 'Создать новое значение свойства')
@endisset

@section('content')
    <div class="col-md-12">
        @isset($value)
            <h1 class="mb-5">Редактировать значение свойства <b>{{ $value->name }}</b></h1>
        @else
            <h1>Добавить новое значение свойства</h1>
        @endisset

        <form method="POST"
              @isset($value)
              action="{{ route('admin.editPropertyValue', $value->id) }}"
              @else
              action="{{ route('admin.createPropertyValue', $propertyId) }}"
            @endisset
        >
            <div>
                @csrf
                <br>
                <div class="input-group row">
                    <label for="name" class="col-sm-2 col-form-label">Название: </label>
                    <div class="col-sm-6">
                        @error('name')
                        <div class="alert alert-danger">{{ $message }}</div>
                        @enderror
                        <input type="text" class="form-control" name="name" id="name"
                               value="@isset($value){{ $value->name }}@endisset">
                    </div>
                </div>

                <br>

                <button class="btn btn-success">Сохранить</button>
            </div>
        </form>
    </div>
@endsection
