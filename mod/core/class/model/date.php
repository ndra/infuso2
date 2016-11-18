<?

namespace Infuso\Core\Model;
use Infuso\Core;

class Date extends Field {

	public function typeID() {
		return "ler9-032r-c4t8-9739-e203";
	}

	public function typeName() {
		return "Дата";
	}

	public function mysqlType() {
		return "date";
	}

	public function mysqlIndexType() {
		return "index";
	}

	public function mysqlNull() {
		return true;
	}

	public function rvalue() {
		if($this->value()) {
			return $this->pvalue()->num();
		} else {
			return "";
		}
	}

	public function pvalue() {
		return (new Core\Date($this->value()))->date();
	}

	public function prepareValue($val) {
    
        if($val === null) {
            return null;
        }
        
        // В MySQL < 5.7 моглы быть такие вот значения даты при не заданном defaultValue
        // Более поздние версии MySQL ругаются на такие значения
        // Преобразуем их к null
        if($val === "0000-00-00 00:00:00") {
            return null;
        }
    
        if($val === "0000-00-00") {
            return null;
        }
    
		if(is_scalar($val) && ($val * 1)."" === $val."") {
		    $val = (new Core\Date($val))->standart();
		}
        
		return $val;
	}

	public function mysqlValue() {
		if(!$this->value()) {
			return "null";
		}
		return parent::mysqlValue();
	}

	public function filterType() {
		return "date";
	}

	public function defaultValue() {
		if(trim($this->param("default")) == "now()") {
			return Core\Date::now()."";
		}
		return "";
	}

}
