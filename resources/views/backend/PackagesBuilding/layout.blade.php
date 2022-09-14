@extends('backend/layout')


{{{$PackagesCreator = 'backend:develop::PackagesBuilding.PackagesCreator.'}}}
{{{$SetBuildCreator = 'backend:develop::PackagesBuilding.SetBuildCreator.'}}}

<div class="row">
    <div class="col-sm-12 col-md-2 sidebar">

        <ul class="menu">
            <li><a href="{{$this->route($PackagesCreator.'index')}}">Создать пакет/приложение </a></li>
            <li><a href="{{$this->route($PackagesCreator.'test_packages')}}">Создать тестовые приложения</a></li>
            <li><a href="{{$this->route($PackagesCreator.'test_delete')}}">Удалить тестовые приложения</a></li>
            <li><a href="{{$this->route($SetBuildCreator.'index')}}">Создать сборку из пакетов</a></li>
        </ul>
    </div>
    <div class="col-md-8">
        @yield('content')
    </div>
</div>

