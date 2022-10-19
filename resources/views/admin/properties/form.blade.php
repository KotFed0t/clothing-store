@extends('admin.layouts.master')

@isset($property)
    @section('title', 'Редактировать свойство ' . $property->name)
@else
    @section('title', 'Создать свойство')
@endisset

@section('content')
    <div class="col-md-12">
        @isset($property)
            <h1 class="mb-5">Редактировать Свойство <b>{{ $property->name }}</b></h1>
        @else
            <h1>Добавить Свойство</h1>
        @endisset

        <form method="POST"
              @isset($property)
              action="{{ route('admin.editProperty', $property->id) }}"
              @else
              action="{{ route('admin.createProperty') }}"
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
                               value="@isset($property){{ $property->name }}@endisset">
                    </div>
                </div>

                <br>

                <button class="btn btn-success">Сохранить</button>
            </div>
        </form>
    </div>
@endsection
