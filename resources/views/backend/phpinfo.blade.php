@extends('backend/layout')
<style>
    table:not(.horizontal) {
        overflow: inherit;
        width: 100%;
        max-height: inherit;
    }
</style>
<div class="row cols-sm-12 cols-md-8 col-sm-offset-1">{!! $phpinfo !!}</div>


