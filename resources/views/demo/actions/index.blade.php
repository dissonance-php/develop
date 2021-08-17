@extends('demo/layouts/layout')
{{{$title = 'Главная страница приложения '.$app->getAppName()}}}
{{-- Записываем в секцию макета, там будет выведено через @ yield('title') --}}
@section('title')
{{$title}}
@stop
@section('sidebar')
    @foreach($actions as $k => $v)
        <li>
            <a href="{{route($k)}}" >{{$v}}</a>
        </li>
    @endforeach
@stop