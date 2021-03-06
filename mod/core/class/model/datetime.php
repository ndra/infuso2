<?

namespace Infuso\Core\Model;
use infuso\util\util;

class Datetime extends Date {

	public function typeID() {
		return "x8g2-xkgh-jc52-tpe2-jcgb";
	}
	
	public function typeName() {
		return "Дата и время";
	}

	public function mysqlType() {
		return "datetime";
	}

	public function editorInx() {
		return array(
		    "type" => "inx.date",
		    "time" => 1,
		    "value" => $this->value(),
		);
	}
	
	public function filterType() {
		return "datetime";
	}

	public function pvalue() {
		return util::date($this->value());
	}

}
