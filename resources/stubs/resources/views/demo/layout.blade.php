<html>
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
    <title>@yield('title')</title>
    <!--  Стили из файла текущего приложения  Demo/assets/css/backend/default.css -->
    <!--  полный путь domain.ru/PUBLIC_PATH/FRAMEWORK_PREFIX/assets/#APP_ID#/css/backend/default.css-->
    <link rel="stylesheet" href="{{$this->asset('css/backend/default.css')}}">
    <!--  Получение файла с указанием приложения , например из другого модуля -->
    <link rel="stylesheet" href="{{$this->asset('demo::css/mini.css')}}">

    <!--  Получение ссылок на файлы js выполняется также -->
    <script type="text/javascript" src="{{$this->asset('js/backend.js')}}"></script>
</head>
<body>
<div style="max-width: 1200px;margin: 0 auto;">

    <div class="row">
        <div class="col-sm-12 col-md-2">
            <h3>Меню</h3>
            <ul>
                <a href="{{$this->route('backend:'.$this->getAppId().'::test')}}">Test route</a>
                <a href="{{$this->route('backend:'.$this->getAppId().'::services_monitor')}}">Services test</a>
                <a href="{{$this->route($this->getAppId().'::home')}}">Frontend route</a>
                @section('sidebar')

                @show
            </ul>
        </div>
        <div class="col-sm-12 col-md-10">
            <div class="row">
                <h1>{{$this->app()->getAppName()}}</h1>
            </div>
            <div class="section double-padded">
                <div id="controller-content">@yield('content')</div>
            </div>
        </div>
    </div>

</div>
</body>
</html>