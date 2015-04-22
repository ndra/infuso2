<?php
/**
 * Created by PhpStorm.
 * User: AKopleman
 * Date: 21.04.2015
 * Time: 11:42
 */

namespace Infuso\TinyMCE;


class theme extends \tmp_theme {

    public function path() {
        return self::inspector()->bundle()->path()."/theme/";
    }

    public function base() {
        return "tinymce";
    }

    public function autoload() {
        return true;
    }

    public function name() {
        return "Default";
    }

}