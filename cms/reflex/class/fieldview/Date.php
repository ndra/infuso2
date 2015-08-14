<?php
/**
 * Created by PhpStorm.
 * User: AKopleman
 * Date: 14.08.2015
 * Time: 15:07
 */

namespace Infuso\Cms\Reflex\FieldView;


class Date extends View
{
    /**
     * Должна вернуть объект шаблона для редактирования поля
     **/
    public function template() {
        $tmp = app()->tm("/reflex/fields/date");
        $tmp->param("field", $this->field);
        $tmp->param("editor", $this->editor());
        return $tmp;
    }

    /**
     * Доблжна вернуть id типа поля
     * (Может вернуть массив из нескольких id)
     **/
    public static function typeID() {
        return  "ler9-032r-c4t8-9739-e203";
    }

    public function colWidth() {
        return 100;
    }
}