@extends('admin.layouts.master')

@isset($product)
    @section('title', 'Редактировать товар ' . $product->name)
@else
    @section('title', 'Создать товар')
@endisset

@section('content')
    <div class="col-md-12">
        @isset($product)
            <h1>Редактировать товар <b>{{ $product->name }}</b></h1>
        @else
            <h1>Добавить товар</h1>
        @endisset
        <form method="POST" enctype="multipart/form-data"
              @isset($product)
              action="{{ route('admin.editProduct', $product) }}"
              @else
              action="{{ route('admin.createProduct') }}"
            @endisset
        >
            <div>
                @csrf
                <div class="input-group row">
                    <label for="code" class="col-sm-2 col-form-label">Код: </label>
                    <div class="col-sm-6">
                        <input type="text" class="form-control" name="code" id="code"
                               value="@isset($product){{ $product->code }}@endisset">
                    </div>
                </div>
                <br>
                <div class="input-group row">
                    <label for="name" class="col-sm-2 col-form-label">Название: </label>
                    <div class="col-sm-6">
                        <input type="text" class="form-control" name="name" id="name"
                               value="@isset($product){{ $product->name }}@endisset">
                    </div>
                </div>
                <br>
                <div class="input-group row">
                    <label for="category_id" class="col-sm-2 col-form-label">Категория: </label>
                    <div class="col-sm-6">
                        <select name="category_id" id="category_id" class="form-control">
                            @foreach($categories as $category)
                                <option value="{{ $category->id }}"
                                        @isset($product)
                                        @if($product->category_id == $category->id)
                                        selected
                                    @endif
                                    @endisset
                                >{{ $category->name }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
                <br>
                <div class="input-group row">
                    <label for="category_id" class="col-sm-2 col-form-label">Гендер: </label>
                    <div class="col-sm-6">
                        <select name="gender" id="category_id" class="form-control">
                            <option value="man" @isset($product) @if($product->gender == 'man') selected @endif @endisset>man</option>
                            <option value="woman" @isset($product) @if($product->gender == 'woman') selected @endif @endisset>woman</option>
                        </select>
                    </div>
                </div>
                <br>
                @foreach($properties as $property)
                    @if($property->name != 'размер')
                        <div class="input-group row">
                            <label for="category_id" class="col-sm-2 col-form-label">{{$property->name}}: </label>
                            <div class="col-sm-6">
                                <select name="values_id[]" id="category_id" class="form-control">
                                    @foreach($property->values as $value)
                                        <option value="{{ $value->id }}"
                                                @isset($product)
                                                    @if($product->values->contains('id', $value->id))
                                                        selected
                                            @endif
                                            @endisset
                                        >{{ $value->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <br>
                    @else
                        <div class="input-group row">
                            <label for="category_id" class="col-sm-2 col-form-label">{{$property->name}}: </label>
                            <div class="col-sm-6">
                                <select multiple size="6" name="values_id[]" id="category_id" >
                                    <option disabled>Выберите значение</option>
                                    @foreach($property->values as $value)
                                        <option value="{{ $value->id }}"
                                                @isset($product)
                                                    @if($product->values->contains('id', $value->id))
                                                        selected
                                            @endif
                                            @endisset
                                        >{{ $value->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <br>
                    @endif
                @endforeach
                <div class="input-group row">
                    <label for="description" class="col-sm-2 col-form-label">Описание: </label>
                    <div class="col-sm-6">
                        <textarea name="description" id="description" cols="72"
                                  rows="7">@isset($product){{ $product->description }}@endisset</textarea>
                    </div>
                </div>
                <br>
                <div class="input-group row">
                    <label for="price" class="col-sm-2 col-form-label">Цена: </label>
                    <div class="col-sm-6">
                        <input type="number" step="0.01" class="form-control" name="price" id="price"
                               value="@isset($product){{ $product->price }}@endisset">
                    </div>
                </div>
                <br>
                <div class="input-group row">
                    <label for="image" class="col-sm-2 col-form-label">Картинка: </label>
                    <div class="col-sm-2">
                        <label class="btn btn-default btn-file">
                            Загрузить <input type="file" style="display: none;" name="image" id="image">
                        </label>
                    </div>
                </div>
                <br>
                <br>
                <button class="btn btn-success">Сохранить</button>
            </div>
        </form>
    </div>
@endsection
