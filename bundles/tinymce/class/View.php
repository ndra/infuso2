<?php
/**
 * Created by PhpStorm.
 * User: AKopleman
 * Date: 21.04.2015
 * Time: 10:54
 */

namespace Infuso\TinyMCE;
use Infuso\Cms\Reflex\FieldView\View as FieldView;

class View extends FieldView{

    /**
     * Должна вернуть объект шаблона для редактирования поля
     **/
    public function template() {
        $tmp = app()->tm("/tinymce/layout/");
        $tmp->param("field", $this->field);
        $tmp->param("view", $this);
        $tmp->param("params", $this->param("tinymce"));
        return $tmp;
    }

    /**
     * Доблжна вернуть id типа поля
     * (Может вернуть массив из нескольких id)
     **/
    public static function typeID() {
        return "6g9f-o2x7-o263-e5va-ul3g";
    }

    public function colWidth() {
        return 100;
    }


}