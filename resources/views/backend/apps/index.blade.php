@extends('backend/apps/layout')
<?php
/**
 * @var \Dissonance\Develop\Services\Monitoring\PackagesInfo $packages
 */
?>
<table class="striped hoverable" style="max-height:inherit">
    <caption>Apps</caption>
    <thead>
    <tr>
        <th>ID</th>
        <th>Name</th>
        <th>Routing</th>
        <th>Количество плагинов</th>
        <th>Bootstraps</th>
        <th>Core providers</th>
    </tr>
    </thead>
    <tbody>
    @foreach($packages->getApps() as $v)
        @if(isset($v['app']['parent_app']))
            @continue
        @endif
        <tr>

            <td>
                <a href="{{ route('backend:develop::apps.app',['app_id' => $v['id']]) }}">
                    {{$v['id']}}
                </a>
            </td>
            <td>
                {{isset($v['app']['name'])?$v['app']['name']:'null'}}
            </td>
            <td>{{$v['app']['routing']}}</td>
            <td>{{$packages->getCountAppPlugins($v['id'])}}</td>
            <td>{{ (isset($v['bootstrappers'])?'Да':"") }}</td>
            <td>{{ (isset($v['providers'])?'Да':"") }}</td>
        </tr>
    @endforeach
    </tbody>
</table>
