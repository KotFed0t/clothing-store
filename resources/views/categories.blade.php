@extends('layouts.master')

@section('content')
    @foreach($categories as $category)
        <div class="container alert alert-secondary align-content-center">
            <a href="{{route('category', $category->code)}}">{{$category->name}}</a>
            <p>{{$category->description}}</p>
        </div>
        @endforeach
@endsection


