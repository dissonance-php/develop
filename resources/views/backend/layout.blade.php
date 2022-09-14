@extends('ui_backend::layout')

@section('sidebar')
        <li>

              <i class="ti-dashboard"></i>
          <a href="{{$this->route('backend:develop::index')}}" >Монитор</a>
        </li>
        <li>
            <i class="ti-layout-grid3"></i>
            <a href="{{$this->route('backend:develop::apps.index')}}" >Приложения</a>
        </li>
        <li>
            <i class="ti-info-alt"></i>   <a href="{{$this->route('backend:develop::docs.index')}}" >Документация</a>
        </li>

        <li>
            <a href="{{$this->route('backend:develop::PackagesBuilding.PackagesCreator.index')}}" >Генерация пакетов</a>
        </li>
        <li>
            <a href="{{$this->route('backend:develop::cache.clean')}}" >Очистка кеша</a>
        </li>
@stop
@yield('content')
