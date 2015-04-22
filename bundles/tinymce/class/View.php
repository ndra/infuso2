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
        $params = $this->param("tinymce");
        if($this->field->param("content_css")){
            $params["content_css"] = $this->field->param("content_css");
        }
        if($this->field->param("plugins")){
            $params["plugins"] = $this->field->param("plugins");
        }
        $tmp = app()->tm("/tinymce/layout/");
        $tmp->param("field", $this->field);
        $tmp->param("view", $this);
        $tmp->param("params", $params);
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