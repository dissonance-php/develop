@extends('ui_backend::layout')

@section('sidebar')
        <li>
            <a href="{{route('backend:develop::index')}}" >Монитор</a>
        </li>
        <li>
            <a href="{{route('backend:develop::apps.index')}}" >Приложения</a>
        </li>
        <li>
            <a href="{{route('backend:develop::docs.index')}}" >Документация</a>
        </li>
        <li>
            <a href="{{route('backend:develop::monitor.phpinfo')}}" >PhpInfo</a>
        </li>

        <li>
            <a href="{{route('backend:develop::cache_clean')}}" >Очистка кеша</a>
        </li>
@stop
