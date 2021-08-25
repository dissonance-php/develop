@extends('backend/PackagesBuilding/layout')
<style>
    .full_input {
        width: 85%;
    }
</style>
<form action="{{route('backend:develop::PackagesBuilding.PackagesCreator.create')}}" method="post">
    <fieldset>
        <div class="row">
            <div class="col-sm-12 col-md-4">
                <label for="packages_path">Папка для приложений</label>
            </div>
            <div class="col-sm-12 col-md">
                <select name="packages_path"  class="full_input" >
                    @foreach($packages_paths as $v)
                        <option value="{{$v}}">{{$v}}</option>
                    @endforeach
                </select>
            </div>
        </div>

        <div class="row">
            <div class="col-sm-12 col-md-4">
                <label for="packages_path">Вендор</label>
            </div>
            <div class="col-sm-12 col-md">
                <input type="text" name="vendor"  class="full_input"  value="dissonance">
            </div>
        </div>
        <div class="row">
            <div class="col-sm-12 col-md-4">
                <label for="packages_path">Имя пакета</label>
            </div>
            <div class="col-sm-12 col-md">
                <input type="text" name="package_name" class="full_input" value="test_{{time()}}">
            </div>
        </div>

        <div class="row">
            <div class="col-sm-12 col-md-4">
                <label for="packages_path">Название</label>
            </div>
            <div class="col-sm-12 col-md">
                <input type="text" name="name"  class="full_input"  value="Приложение {{time()}}">
            </div>
        </div>
        <div class="row">
            <div class="col-sm-12 col-md-4">
                <label for="packages_path">С демо экшенами</label>
            </div>
            <div class="col-sm-12 col-md">
                <input type="hidden" name="with_demo"   value="0">
                <input type="checkbox" name="with_demo"   value="1">
            </div>
        </div>
    </fieldset>
<p>TODO: Позже дописать... опции</p>
    <input type="submit" class="primary">
</form>
