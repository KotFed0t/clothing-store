@extends('admin.layouts.master')

@section('content')
    <h1 class="text-center mb-5">Обращения</h1>

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
            <th scope="col">Действия</th>
        </tr>
        </thead>
        <tbody>
        @isset($tickets)
            @foreach($tickets as $ticket)
                <tr>

                    <td>{{$ticket->id}}</td>
                    <td>{{$ticket->name}}</td>
                    <td>{{$ticket->email}}</td>
                    <td>{{$ticket->phone}}</td>
                    <td style="text-overflow: ellipsis;">{{$ticket->text}}</td>
                    <td>{{$ticket->created_at}}</td>
                    <td>{{$ticket->status}}</td>
                    <td><a href="{{route('admin.ticketDetails', $ticket->id)}}" class="btn bg-dark text-white">Открыть</a></td>
                </tr>
            @endforeach
        @endisset
        </tbody>
    </table>
@endsection
