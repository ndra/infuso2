<?

namespace Infuso\Core\Model;
use infuso\util\util;

class Html extends Field {

	public function typeID() { return "fgkn-o95h-uikx-c878-k4bi"; }
	public function mysqlType() { return "longtext"; }

	public function mysqlIndexFields() {
		return $this->name()."(1)";
	}

	public function editorInx() {
		return array(
		    "type" => "inx.code",
		    "value" => $this->value(),
		);
	}

	public function typeName() { return "Код HTML"; }

}
