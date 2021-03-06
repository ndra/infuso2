<?

namespace Infuso\Core\Model;
use infuso\util\util;

class Id extends Field {

	public function typeID() {
		return "jft7-kef8-ccd6-kg85-iueh";
	}

	public function typeName() {
		return "Первичный ключ";
	}

	public function mysqlType() {
		return "bigint(20)";
	}

    public function dbIndex() {
        return array(
            "type" => "primary",
            "name" => "PRIMARY",
            "fields" => $this->name(),
		);
    }

	public function mysqlAutoincrement() {
		return true;
	}

	public function prepareValue($val) {
		return floor($val);
	}

}
