<html>
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
    <title>@section('title')</title>
    <link rel="stylesheet" href="{{asset('css/backend/app.css')}}">

    <!--  Получение ссылок на файлы js выполняется также -->
   <script type="text/javascript" src="{{asset('js/app.js')}}"></script>
</head>
<body>
<div style="max-width: 1200px;margin: 0 auto;">

    <div class="row">
        <div class="col-sm-12 col-md-2">
            <ul>
                @section('sidebar')
                    <li><a href="{{route('backend:#APP_ID#::home')}}"></a></li>
                @show
            </ul>
        </div>
        <div class="col-sm-12 col-md-10">
            <div class="section double-padded">
                <div id="controller-content">@yield('content')</div>
            </div>
        </div>
    </div>

</div>
</body>
</html>