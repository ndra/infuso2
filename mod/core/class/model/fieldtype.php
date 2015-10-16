<?

namespace Infuso\Core\Model;
use infuso\util\util;

class FieldType extends Select {

	public function typeID() {
		return "z34g-rtfv-i7fl-zjyv-iome";
	}
	
	public function typeName() {
		return "Тип поля";
	}

	public function mysqlType() {
		return "varchar(50)";
	}
	
	public function mysqlIndexType() {
		return "index";
	}

	public function prepareValue($val) {
		return trim($val);
	}

	public function options() {
	    $options = array();
	    $classes = service("classmap")->map("infuso\\core\\model\\field");
	    foreach($classes as $class) {
	        $field = new $class;
	        $options[$field->typeId()] = $field->typeName();
	    }
	    return $options;
	}

	public function pvalue() {
		return Field::get(array(
		    "editable" => 1,
		    "name" => "field",
		    "type" => $this->value(),
		));
	}

}
