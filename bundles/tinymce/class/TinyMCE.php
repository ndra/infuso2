<?php
/**
 * Created by PhpStorm.
 * User: AKopleman
 * Date: 21.04.2015
 * Time: 10:45
 */

namespace Infuso\TinyMCE;
use \Infuso\Core;
use Infuso\Core\Model\Field as Field;

class TinyMCE extends Field {

    public function typeID() {
        return "6g9f-o2x7-o263-e5va-ul3g";
    }

    public function typeName() {
        return "Текстовое поле(TinyMCE)";
    }

    public function mysqlType() {
        return "longtext";
    }

    public function typeAlias() {
        return "tinymce";
    }

    public function dbIndex() {
        return array(
            "name" => "+".$this->name(),
            "fields" => $this->name()."(1)",
        );
    }

    public function pvalue($params=array()) {
        return reflex_content_processor::getDefault()->params($params)->process($this->value());
    }

    public function prepareValue($val) {
        return trim($val);
    }

}