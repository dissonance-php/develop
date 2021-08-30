@extends('demo/layout')
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
<div class="section">
    <div class="row">
        <div class="col-md-12 col-sm-12"><h3>Контроллер:</h3></div>
    </div>
    <div class="row">
        <div class="col-sm-3 col-md-3"><b>Класс:</b></div>
        <div class="col-sm-9 col-md-9">{{$controller['class']}}</div>
    </div>
    <div class="row">
        <div class="col-sm-3 col-md-3"><b>Метод:</b></div>
        <div class="col-sm-9 col-md-9">{{$controller['method']}}</div>
    </div>
    <div class="row">
        <div class="col-sm-3 col-md-3"><b>Template:</b></div>
        <div class="col-sm-9 col-md-9">{{$controller['view']}}</div>
    </div>
</div>

<div class="section">
    <div class="row">
        <div class="col-md-12 col-sm-12"><h3>Роут:</h3></div>
    </div>
    <?php
    /**
     * @var \Symbiotic\Routing\RouteInterface $route
     */
    ?>
    <div class="row">
        <div class="col-sm-3 col-md-3"><b>Домен:</b></div>
        <div class="col-sm-9 col-md-9">"{{$route->getDomain()}}"</div>
    </div>
    <div class="row">
        <div class="col-sm-3 col-md-3"><b>Паттерн:</b></div>
        <div class="col-sm-9 col-md-9">"{{$route->getPath()}}"</div>
    </div>
    <div class="row">
        <div class="col-sm-3 col-md-3"><b>Имя:</b></div>
        <div class="col-sm-9 col-md-9">"{{$route->getName()}}"</div>
    </div>
    <div class="row">
        <div class="col-sm-3 col-md-3"><b>Мидлвары:</b></div>
        <div class="col-sm-9 col-md-9">
            @foreach($route->getMiddlewares() as $v)
                "{{$v}}"<br>
            @endforeach
        </div>
    </div>
    <div class="row">
        <div class="col-sm-3 col-md-3"><b>Обработчик:</b></div>
        <div class="col-sm-9 col-md-9">"{{$route->getHandler()}}"</div>
    </div>
</div>

<div class="section">
    <?php
    /**
     * @var  \Symbiotic\Apps\ApplicationInterface $app
     */
    ?>
    <div class="row">
        <div class="col-md-12 col-sm-12"><h3>Приложение:</h3></div>
    </div>
    <div class="row">
        <div class="col-sm-3 col-md-3"><b>Id:</b></div>
        <div class="col-sm-9 col-md-9">"{{$app->getId()}}"</div>
    </div>
    <div class="row">
        <div class="col-sm-3 col-md-3"><b>Name:</b></div>
        <div class="col-sm-9 col-md-9">"{{$app->getAppName()}}"</div>
    </div>
    <div class="row">
        <div class="col-sm-3 col-md-3"><b>Title:</b></div>
        <div class="col-sm-9 col-md-9">"{{$app->getAppName()}}"</div>
    </div>
    <div class="row">
        <div class="col-sm-3 col-md-3"><b>Parent app:</b></div>
        <div class="col-sm-9 col-md-9">"{{$app->getParentAppId()}}"</div>
    </div>
    <div class="row">
        <div class="col-sm-3 col-md-3"><b>Routing provider:</b></div>
        <div class="col-sm-9 col-md-9">"{{$app->getRoutingProvider()}}"</div>
    </div>
</div>