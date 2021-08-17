<html>
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
    <!--  Заголовок из контроллера или берем название приложения -->
    <!--  Название приложения ставится в файле Demo/composer.json
                     -> extra
                       -> dissonance
                        -> app
                          -> name
                      -->
    <?php
    /**
     * @method  \Dissonance\Contracts\App\ApplicationInterface app()
     * @uses  \Dissonance\View\app()
     */
    ?>
    <title>{{(!empty($meta_title) ? $meta_title:  app()->getAppTitle())}}</title>

<?php
/**
 * @method string asset()
 * @uses  \Dissonance\View\asset()
 * FRAMEWORK_PREFIX = настройка в конфиге prefix_uri
 */
?>
<!--  Стили из файла текущего приложения  Demo/assets/css/mini.css -->
    <!--  полный путь domain.ru/PUBLIC_PATH/FRAMEWORK_PREFIX/assets/APP_ID/css/mini.css -->
    <!--  Получение файла с указанием приложения , например из другого модуля -->
    <link rel="stylesheet" href="{{asset('demo::css/mini.css')}}">

    <!--  Получение ссылок на файлы js выполняется также -->
    <script type="text/javascript" src="{{asset('js/app.js')}}"></script>
</head>
<body>
<div style="max-width: 1200px;margin: 0 auto;">
    <div class="row">
        <div class="col-sm-12 col-md-2">

        </div>
        <?php var_dump($this->sections);?>
        <div class="col-sm-12 col-md-10">
            <div class="section double-padded">
                <div id="controller-content">@yield('content')</div>
            </div>
        </div>
    </div>

</div>
</body>
</html>