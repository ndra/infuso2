<?

namespace Infuso\Core\Model;
use infuso\util\util;

/**
 * Класс текстового поля
 **/
class Textarea extends Field {

	public function typeID() {
		return "kbd4-xo34-tnb3-4nxl-cmhu";
	}
	
	public function typeName() {
		return "Текстовое поле";
	}

	public function mysqlType() {
		return "longtext";
	}

    public function dbIndex() {
        return array(
            "name" => "+".$this->name(),
            "fields" => $this->name()."(1)",
		);
    }

	public function editorInx() {
		return array(
		    "type" => "inx.mod.reflex.fields.textarea",
		    "value" => $this->value(),
		);
	}

	public function pvalue($params=array()) {
		return service("content-processor")->process($this->value());
	}

	public function prepareValue($val) {
		return trim($val);
	}
	
}
