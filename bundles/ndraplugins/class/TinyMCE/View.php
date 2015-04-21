<?php
/**
 * Created by PhpStorm.
 * User: AKopleman
 * Date: 21.04.2015
 * Time: 10:54
 */

namespace NDRA\Plugins\TinyMCE;
use Infuso\Cms\Reflex\FieldView\View as FieldView;

class View extends FieldView{

    /**
     * Должна вернуть объект шаблона для редактирования поля
     **/
    public function template() {
        $tmp = app()->tm("/ndraplugins/TinyMCE/");
        $tmp->param("field", $this->field);
        $tmp->param("view", $this);
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