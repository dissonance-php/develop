{{{@ $server = app('server')}}}
{{{@  $filesystem = app('filesystem')}}}
{{{@ $current_dir = $filesystem->getCurrentDir()}}}
{{{@  $drive = $server->getDrive($filesystem->getBasePath())  }}}
{{{@  $drives = $server->get('drives')   }}}



<table class="info" cellpadding="0" cellspacing="0" width="100%">
    <tr>
        <td>Uname:</td>
        <td>{{$server->get('uname')}}</td>
        <td></td>
    </tr>
    <tr>
        <td>Php:</td>
        <td>
            {{$server->get('phpversion')}} <span>Safe mode: </span>
             {{($server->get('safe_mode')? 'on' : 'off')}}
                <a href="{{route('backend::filesmanager.phpinfo')}}">[phpinfo]</a>
            <span>Datetime:</span>
            {{date('Y-m-d H:i:s')}}
            <span>Memory_limit:</span>
            {{@ini_get('memory_limit') }}
            <span>Execution time:</span>
            {{ @ini_get('max_execution_time') }}


        </td>
        <td><span>Server IP:</span></td>
    </tr>
    <tr>
        <td>Hdd:</td>
        <td><span> Total: </span>{{$drive[ 'total_space' ]}}
            <span> Free: </span>{{$drive[ 'free_space' ]}}  ( {{$drive[ 'percent' ]}} %)
        </td>
        <td> {{$server->get("SERVER_ADDR") }}</td>
    </tr>
    <tr>
        <td>Cwd:</td>
        <td>
            {{{@  $nav = explode("/", $current_dir)}}}
            {{{@$nav_dir = ''}}}
            @foreach($nav as $v)
                {{{@$nav_dir .= ($v.'/')}}}
<a href="{{route('backend::filesmanager.files.dir', ['dir' => $nav_dir])}}">{{$v}}/</a>
            @endforeach
             <a href="{{route('backend::filesmanager.files.dir', ['dir' => $filesystem->getBasePath()])}}">[HOME]</a>
        </td>
		<td><span>Client IP</span></td></tr><tr><td> {{!empty($drives) ? 'Drives' : ''}}</td><td>
@if( !empty($drives))
    @foreach($drives as $name => $path)
       <a href="{{route('backend::filesmanager.files.dir', ['dir' => $path])}}">{{$name}}</a>
    @endforeach
@endif
</td><td>{{$_SERVER[ 'REMOTE_ADDR' ]}}</td></tr>
</table>
