<?

namespace Infuso\Core\Model;
use infuso\util\util;

class Bigint extends Field {

	public function typeID() {
		return "gklv-0ijh-uh7g-7fhu-4jtg";
	}

	public function typeName() {
		return "Большое целое";
	}
    
    public function typeAlias() {
        return array(
            "bigint",
            "integer"
        );
    }

	public function mysqlType() {
		return "bigint(20)";
	}

	public function mysqlIndexType() {
		return "index";
	}

	public function filterType() {
		return "number";
	}

	public function prepareValue($val) {
		return floor($val);
	}

	public function defaultValue() {
		return intval($this->prepareValue($this->param("default")));
	}

}
