@extends('backend/apps/layout')
<?php
/**
 * @var  \Symbiotic\Apps\ApplicationInterface $app
 * @var  \Symbiotic\Routing\RouteInterface[][] $routes
 * @var  \Symbiotic\Routing\RouteInterface[] $type
 * @var  \Symbiotic\Routing\RouteInterface $route
 */
?>
<h3>{{$app->getId()}}</h3>
<div class="row">
    <div class="col-md-12 col-sm-12">
        <h2>Инфо</h2>
    </div>
    <div class="col-sm-12 col-md-6 row">
        <div class="col-sm-8 col-md-6">ID:</div>
        <div class="col-sm-4 col-md-6">{{$app->getId()}}</div>
        <div class="col-sm-8 col-md-6">Родительское приложение:</div>
        <div class="col-sm-4 col-md-6">{{$app->hasParentApp()?$app->getParentAppId():'Нет'}}</div>
        <div class="col-sm-8 col-md-6">Роутинг провайдер:</div>
        <div class="col-sm-4 col-md-6">{{$app->getRoutingProvider()}}</div>
        <div class="col-sm-8 col-md-6">Бекенд:</div>
        <div class="col-sm-4 col-md-6">{{!empty($routes['backend'])?'Да':'Нет'}}</div>
        <div class="col-sm-8 col-md-6">Фронтенд:</div>
        <div class="col-sm-4 col-md-6">{{!empty($routes['frontend'])?'Да':'Нет'}}</div>
        <div class="col-sm-8 col-md-6">Апи:</div>
        <div class="col-sm-4 col-md-6">{{!empty($routes['frontend'])?'Да':'Нет'}}</div>
        <div class="col-sm-8 col-md-6">Корневые роуты:</div>
        <div class="col-sm-4 col-md-6">{{!empty($routes['default'])?'Да':'Нет'}}</div>
        <div class="col-sm-8 col-md-6">Класс контейнера приложения:</div>
        <div class="col-sm-4 col-md-6">{{$app('config::app_class','Нет')}}</div>
    </div>
    <div class="col-md-12 col-sm-12">
        <a href="{{route('backend:develop::apps.routes', ['app_id' => $app->getId()])}}" target="_blank">
            <h2>Просмотр роутинга</h2>
        </a>
    </div>

</div>