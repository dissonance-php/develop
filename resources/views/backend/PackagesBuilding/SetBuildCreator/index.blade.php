@extends('backend/PackagesBuilding/layout')
<?php
/**
 * @var \Symbiotic\Develop\Services\Packages\SetBuilder\Builder $builder
 */
?>
<style>
    .full_input {
        width: 85%;
    }
</style>
<form action="{{$this->route('backend:develop::PackagesBuilding.SetBuildCreator.create')}}" method="post">
    <fieldset>
        <div class="row">
            <div class="col-sm-12 col-md-4">
                <label for="packages_path">Папка для сборки</label>
            </div>
            <div class="col-sm-12 col-md">
                <select name="build_path"  class="full_input" >
                    @foreach($build_paths as $v)
                        <option value="{{$v}}">{{$v}}</option>
                    @endforeach
                </select>
            </div>
        </div>

        <div class="row">
            <div class="col-sm-12 col-md-4">
                <label for="packages_path">Название пакета</label>
            </div>
            <div class="col-sm-12 col-md">
                <input type="text" name="package_name" class="full_input" value="build_{{time()}}">
            </div>
        </div>
        <div class="row">
            <div class="col-sm-12 col-md-4">
                <label for="packages_path">Скомпилировать в один файл<br> <small>(пока не работает)</small></label>
            </div>
            <div class="col-sm-12 col-md">
                <input type="checkbox"  disabled name="single_file" value="1">
            </div>
        </div>
        <div class="row">
            <div class="col-sm-12 col-md-4">
                <label for="packages_path">Пакеты для сборки</label>
            </div>
            <div class="col-sm-12 col-md">
                @foreach($builder->getPackagesConfigs() as $path => $packages)
                    <fieldset>
                        <legend><input type="checkbox" class="select_dir" value="1">{{$path}}</legend>
                        @foreach($packages as $package)
                            <label>
                                <input type="checkbox" class="package_check" name="package_dir[]" value="{{$package['base_path']}}">
                                {{$package['name']}}
                            </label>
                            <br>
                        @endforeach
                    </fieldset>
                @endforeach
            </div>
        </div>
    </fieldset>

    <input type="submit" class="primary">
</form>

<script>
    if (!Element.prototype.matches) Element.prototype.matches = Element.prototype.msMatchesSelector;
    if (!Element.prototype.closest) Element.prototype.closest = function (selector) {
        var el = this;
        while (el) {
            if (el.matches(selector)) {
                return el;
            }
            el = el.parentElement;
        }
    };
    document.querySelectorAll('.select_dir').forEach(function(v){
        v.addEventListener('click', function(e) {
            var check = this.checked;
           this.parentElement.parentElement
                .querySelectorAll('.package_check').forEach(function(pack){
              pack.checked = true;
            });
        });
    });


</script>
