@extends('layout')
<?php
/**
 * @var \Exception $exception
 */
?>
@section('title')
Error: {{$exception->getMessage()}}
@stop
<div class="center">
    <h1>Error: #{{$exception->getCode()}} {{$exception->getMessage()}}</h1>
    <p style="text-align: left;">{!! nl2br($exception->getTraceAsString()) !!}</p>
</div>