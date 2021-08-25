@extends('backend/PackagesBuilding/layout')


{{{$route_prefix = 'backend:develop::PackagesBuilding.PackagesCreator.'}}}
<h1>Создание пакетов для нагрузки</h1>
<p>
    Нагрузочные пакеты полезны для проверки скорости работы ядра фреймворка.
    При написании расщирения для ядра необходимо тестировать минимум на 1000 пакетов приложений и
    150 пакетов расширяющих фреймворк.
</p>
<p>Все созданные тестовые пакеты можно массово удалить!
    Но чтобы было удобее, тестовые пакеты рекомендуется генерировать в отдельную папку,
    ее можно добавить в конфиге в ключе <strong>"packages_paths"</strong>.
</p>

<form action="{{route($route_prefix.'test_create')}}" method="post">

    <fieldset>
        <div class="row">
            <div class="col-sm-12 col-md-4">
                <label for="packages_path">Папка для приложений</label>
            </div>
            <div class="col-sm-12 col-md">
                <select name="packages_path">
                    @foreach($packages_paths as $v)
                        <option value="{{$v}}">{{$v}}</option>
                    @endforeach
                </select>
            </div>
        </div>
        <div class="row">
            <div class="col-sm-12 col-md-4">
                <label for="count_apps"> Количество пакетов приложений</label>
            </div>
            <div class="col-sm-12 col-md">
                <input type="text" name="count_apps" value="500">
            </div>
        </div>
        <div class="row">
            <div class="col-sm-12 col-md-4">
                <label for="count_bootstraps">Количество пакетов c бутстраперами</label>
            </div>
            <div class="col-sm-12 col-md">
                <input type="text" name="count_bootstraps" value="70">
            </div>
        </div>
        <div class="row">
            <div class="col-sm-12 col-md-4">
                <label for="count_core_providers">Количество пакетов c корневыми провайдерами</label>
            </div>
            <div class="col-sm-12 col-md">
                <input type="text" name="count_core_providers" value="70">
            </div>
        </div>

    </fieldset>

    <input type="submit" class="primary" value="Создать">
</form>

<a href="{{route($route_prefix.'test_delete')}}">Удалить тестовые приложения</a>