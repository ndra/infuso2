<?php
/**
 * Created by PhpStorm.
 * User: AKopleman
 * Date: 21.04.2015
 * Time: 11:42
 */

namespace NDRA\Plugins;


class Theme extends \Infuso\Template\Theme {

    public function path() {
        return self::inspector()->bundle()->path()."/theme/";
    }

    public function base() {
        return "ndraplugins";
    }

    public function autoload() {
        return true;
    }

    public function name() {
        return "Стандартная тема Плагинов";
    }

}