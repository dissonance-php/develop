@extends('demo/layout')
<!-- РАсширяем меню макета  -->
@section('sidebar')
    <a href="{{$this->route('backend:'.$this->getAppId().'::test')}}">Test route</a>
    <a href="{{$this->route($this->getAppId().'::home')}}">Frontend route</a>
    @parent
@endsection

<p>Сервис Singleton: {{$singleton->getQuantityInstances()}} создано объектов</p>
<p>Сервис Live: {{$live->getQuantityInstances()}} создано объектов</p>
<p>Сервис Cloning: {{$cloning->getQuantityInstances()}} создано объектов, {{$cloning->getQuantityClones()}} клонирований</p>


