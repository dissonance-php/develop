@extends('backend/apps/layout')
<?php
/**
 * @var  \Dissonance\Contracts\App\ApplicationInterface $app
 * @var  \Dissonance\Contracts\Routing\RouteInterface[][] $routes
 * @var  \Dissonance\Contracts\Routing\RouteInterface[] $type
 * @var  \Dissonance\Contracts\Routing\RouteInterface $route
 */
?>
<div class="row">
    <div class="col-md-12 col-sm-12">
        <h2>Роутинг</h2>
    </div>
    @foreach($routes as $type => $data)
        @if(!empty($data))
            <div class="col-md-12 col-sm-12">
                <h3>{{$type}}</h3>
            </div>
            <div class="col-sm-12 col-md-6 row">
                @foreach($data as $route)
                    @if(!is_array($route))
                        <div class="col-sm-8 col-md-6">{{$route->getName()}}</div>
                        <div class="col-sm-4 col-md-6">
                            @if($route->isStatic())
                                <a href="{{route(($type==='frontend'?$app->getId():$type.':'.$app->getId()).'::'.$route->getName())}}" target="_blank">
                                    {{$route->getPath()}}
                                </a>
                            @else
                                <mark class="secondary"> {{$route->getPath()}}</mark>
                            @endif
                        </div>

                    @endif
                @endforeach
            </div>
@endif
@endforeach
