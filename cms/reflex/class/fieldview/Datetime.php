<?php
/**
 * Created by PhpStorm.
 * User: AKopleman
 * Date: 14.08.2015
 * Time: 16:44
 */

namespace Infuso\Cms\Reflex\FieldView;


class Datetime extends View
{
    /**
     * Должна вернуть объект шаблона для редактирования поля
     **/
    public function template() {
        $tmp = app()->tm("/reflex/fields/datetime");
        $tmp->param("field", $this->field);
        $tmp->param("editor", $this->editor());
        return $tmp;
    }

    /**
     * Доблжна вернуть id типа поля
     * (Может вернуть массив из нескольких id)
     **/
    public static function typeID() {
        return  "x8g2-xkgh-jc52-tpe2-jcgb";
    }

    public function colWidth() {
        return 100;
    }
}