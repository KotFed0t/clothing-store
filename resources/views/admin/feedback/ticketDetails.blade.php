@extends('admin.layouts.master')

@section('content')
    <h1 class="text-center mt-5">Обращение</h1>

    <table class="table table-striped">
        <thead>
        <tr>
            <th scope="col">ID</th>
            <th scope="col">Имя</th>
            <th scope="col">Email</th>
            <th scope="col">Телефонн</th>
            <th scope="col">Сообщение</th>
            <th scope="col">Дата обращения</th>
            <th scope="col">Статус</th>
        </tr>
        </thead>
        <tbody>
        @isset($ticket)
            <tr>
                <td>{{$ticket->id}}</td>
                <td>{{$ticket->name}}</td>
                <td>{{$ticket->email}}</td>
                <td>{{$ticket->phone}}</td>
                <td style="text-overflow: ellipsis;">{{$ticket->text}}</td>
                <td>{{$ticket->created_at}}</td>
                <td>{{$ticket->status}}</td>
            </tr>
        </tbody>
    </table>

    @isset($responses)
        <h3 class="mt-5">История ответов по данному обращению</h3>
        <table class="table table-striped">
            <thead>
            <tr>
                <th scope="col">Дата ответа</th>
                <th scope="col">Текст ответа</th>
            </tr>
            </thead>
            <tbody>
            @foreach($responses as $response)
                <tr>
                    <td>{{$response->created_at}}</td>
                    <td style="text-overflow: ellipsis;">{{$response->text}}</td>
                </tr>
            @endforeach
            </tbody>
        </table>
    @endisset

    <h3 class="mt-5">Ответить на обращение</h3>

    <form action="{{route('admin.ticketResponse')}}" method="POST">
        <div>
            @csrf

            <br>

            <input type="hidden" name="ticket_id" value="{{$ticket->id}}">

            @error('status')
            <p class="text-red-500">{{$message}}</p>
            @enderror
            <div class="input-group row">
                <label for="status_id" class="col-sm-2 col-form-label">Сменить статус обращения: </label>
                <div class="col-sm-6">
                    <select name="status" id="status_id" class="form-control">
                        <option value="in_progress" selected>В процессе</option>
                        <option value="solved">Решен</option>
                    </select>
                </div>
            </div>
            <br>
            @error('text')
            <p class="text-red-500">{{$message}}</p>
            @enderror
            <div class="input-group row">
                <label for="text_id" class="col-sm-2 col-form-label">Сообщение </label>
                <div class="col-sm-6">
                        <textarea name="text" id="text_id" cols="72"
                                  rows="7"></textarea>
                </div>
            </div>

            <br>
            <br>
            <button class="btn btn-success">Отправить</button>
        </div>
    </form>
    @endisset
@endsection
