@layout('filesmanager::layouts/index')
{{{@ $filesystem = app('filesystem')}}}
{{$filesystem->getCurrentDir()}}
{{$session_var}}
@foreach($filesystem->drive()->getRecursiveDirectoryIterator($filesystem->getCurrentDir()) as $v)
    {{$v->getFilename()}}<br>
@endforeach
