@extends('backend/apps/layout')
<?php
/**
 * @var  \Symbiotic\Apps\ApplicationInterface $app
 * @var  \Symbiotic\Routing\RouteInterface[][] $routes
 * @var  \Symbiotic\Routing\RouteInterface[] $type
 * @var  \Symbiotic\Routing\RouteInterface $route
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
                @foreach($data as $k => $route)
                    @if(!is_array($route))
                        <div class="col-sm-8 col-md-8">{{$k}}</div>
                        <div class="col-sm-4 col-md-4">
                            @if($route->isStatic())
                                <a href="{{$this->route($type==='frontend'? $app->getId().'::'.$route->getName():($type ==='default'? 'default::'.$route->getName():$type.':'.$app->getId().'::'.$route->getName()))}}" target="_blank">
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
