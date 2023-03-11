@extends('layouts.app')

@section('content')
    <div class="container mt-5">

        <h1>Мои сессии</h1>

        <div class="row mt-3">
            <div class="col-sm-12 col-md-6">
                <p>Количество сессий: {{ $sessions->count() }}</p>
            </div>
            <div class="col-sm-12 col-md-6 text-right">
                {{--    пример для создание сессии--}}
                <form action="{{ route('sessions.store') }}" method="POST">
                    @csrf
                    <button type="submit" class="btn btn-success">Начать новую сессию</button>
                </form>
            </div>
        </div>

        <ul class="list-group mt-4">
            @foreach ($sessions as $session)
                <li class="list-group-item d-flex justify-content-between align-items-center mx-auto" style="width: 60%">
                    {{ $session->created_at->format('d.m.Y H:i:s') }} (IP-адрес: {{ $session->ip_address }})
                    <form action="{{ route('sessions.endsession', $session->id) }}" method="post">
                        @csrf
                        @method('PUT')
                        <button type="submit" class="btn btn-danger btn-sm">Завершить</button>
                    </form>
                </li>
            @endforeach
        </ul>


        <div class="row mt-5">
            <div class="col-sm-12 col-md-6">
                {{-- кнопка для завершения всех сессий --}}
                <a href="{{ route('sessions.endallsessions') }}" class="btn btn-warning">Завершить все сессии</a>
            </div>
            <div class="col-sm-12 col-md-6 text-right">
                @if($sessions->first())
                    <form action="{{ route('sessions.endallsessionsexceptcurrent', $sessions->first()) }}" method="POST">
                        @csrf
                        @method('PUT')
                        <button type="submit" class="btn btn-danger">Завершить все сессии, кроме текущей</button>
                    </form>
                @endif
            </div>
        </div>

    </div>

    <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script

@endsection
