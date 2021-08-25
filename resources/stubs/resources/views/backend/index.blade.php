@extends('backend/layout')
<!-- РАсширяем меню макета  -->
@section('sidebar')
    <a href="{{route('backend:'.app()->getId().'::test')}}">Test route</a>
    <a href="{{route(app()->getId().'::home')}}">Frontend route</a>
    @parent
@endsection

<h2>Backend Index Page</h2>
