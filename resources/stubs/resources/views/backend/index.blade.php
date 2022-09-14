@extends('backend/layout')
<!-- РАсширяем меню макета  -->
@section('sidebar')
    <a href="{{$this->route('backend:'.$this->getAppId().'::test')}}">Test route</a>
    <a href="{{$this->route($this->getAppId().'::home')}}">Frontend route</a>
    @parent
@endsection

<h2>Backend Index Page</h2>
