<?

namespace Infuso\Core\Model;
use infuso\util\util;

class Multiselect extends Field {

	public function typeID() {
		return "ZMDh1GXeiTRw";
	}
	
	public function typeName() {
		return "Мультисписок";
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
    
    public function isOptionSelected($key) {
        return in_array($key, $this->pdata());
    }
    
    public function pdata() {
        $options = $this->options();
        $ret = array();
        foreach(explode(" ", $this->value()) as $key) {
            if(array_key_exists($key, $options)) {
                $ret[] = $key;
            }
        } 
        return $ret;
    }
    
	/**
	 * Возвращает список значений ввиде массива $ключ => $значение
	 **/
	public function options($options = null) {       
	
		// Вызов метода
		if($fn = $this->param("method")) {
		    return call_user_func(array($this->model(),$fn));
		}
		
        $options = $this->param("values");
        if(!$options) {
            $options = $this->param("list");
        }
		
		// Разбор значений из строки
		if(!is_array($options)) {
			$ret = array();
			foreach(util::splitAndTrim($options,",") as $key => $val) {
			    $ret[$key+1] = $val;
			}
			$options = $ret;
		}
		
		return $options;		

	}

}
