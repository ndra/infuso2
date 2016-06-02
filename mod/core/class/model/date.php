<?

namespace Infuso\Core\Model;
use infuso\util\util;

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

	public function editorInx() {
		return array(
		    "type" => "inx.date",
		    "value" => $this->value(),
		);
	}

	public function rvalue() {
		if($this->value()) {
			return $this->pvalue()->num();
		} else {
			return "";
		}
	}

	public function pvalue() {
		return util::date($this->value())->date();
	}

	public function prepareValue($val) {
		if(is_scalar($val) && ($val*1)."" === $val."") {
		    $val = util::date($val)->standart();
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
			return util::now()."";
		}
		return "";
	}

}
