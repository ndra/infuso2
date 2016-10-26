<?

namespace Infuso\Core\Model;
use infuso\util\util;

class StringX extends Field {

	public function typeID() {
		return "v324-89xr-24nk-0z30-r243";
	}

	public function typeName() {
		return "Строка";
	}

	public function typeAlias() {
	
	    if(get_called_class() == get_class()) {
		    return array(
		        "string",
		        "textfield"
			);
		} else {
		    return parent::typeAlias();
		}
	}
    
    public function dbIndex() {
    
        $prefix = "";
        if($this->length() > 255) {
            $prefix = "(255)";
        }
    
        return array(
            "name" => "+".$this->name(),
            "fields" => $this->name().$prefix,
		);
    }

	public function mysqlType() {
		return "varchar(".$this->length().")";
	}

	public function prepareValue($val) {
		return trim($val);
	}

	public function length() {
		$l = $this->param("length");
		if(!$l) {
		    $l = 255;
		}
		return $l;
	}

}
