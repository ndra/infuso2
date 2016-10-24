<?

namespace Infuso\Core\Model;
use infuso\util\util;

/**
 * Класс текстового поля
 **/
class Textarea extends Field {

	public function typeId() {
		return "kbd4-xo34-tnb3-4nxl-cmhu";
	}
	
	public function typeName() {
		return "Текстовое поле";
	}

	public function mysqlType() {
		return "longtext";
	}
    
    public function typeAlias() {
        return array(
            "textarea",
        );
    }    

    public function dbIndex() {
        return array(
            "name" => "+".$this->name(),
            "fields" => $this->name()."(1)",
		);
    }

	public function pvalue($params=array()) {
		return service("content-processor")->process($this->value());
	}

	public function prepareValue($val) {
		return trim($val);
	}
	
}
