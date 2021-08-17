<html>
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
    <title>@yield('title')</title>
    <!--  Стили из файла текущего приложения  #APP_ID#/assets/css/app.css -->
    <!--  полный путь domain.ru/PUBLIC_PATH/FRAMEWORK_PREFIX/assets/#APP_ID#/css/app.css -->
    <link rel="stylesheet" href="{{asset('css/app.css')}}">
    <!--  Получение ссылок на файлы js выполняется также -->
    <script type="text/javascript" src="{{asset('js/app.js')}}"></script>
</head>
<body>
<div style="max-width: 1000px;margin: 0 auto;">
    <h1>@yield('title')</h1>
    <div id="controller-content">@yield('content')</div>
</div>
</body>
</html>