<?

namespace Infuso\Core\Model;
use infuso\util\util;

class StringSelect extends StringX {

	public function typeID() {
		return "uR7kW3UhmhC";
	}
	
	public function typeName() {
		return "Список (строковые ключи)";
	}
    
    public function typeAlias() {
        return array("stringselect");
    }    

	/**
	 * Возвращает текстовое значение элемента списка
	 **/
	public function pvalue() {
		$values = $this->options();
		$ret = $values[$this->value()];
		if($ret === null) {
			$ret = "";
		}
		return $ret;
	}

	/**
	 * Возвращает текстовое значение элемента списка
	 **/
	public function rvalue() {
		return $this->pvalue();
	}

	/**
	 * Возвращает список значений ввиде массива $ключ => $значение
	 **/
	public function options($options = null) {
	
	    if(func_num_args() == 0) {
	
			// Вызов метода
			if($fn = $this->param("method")) {
			    return call_user_func(array($this->model(), $fn));
			}
			
            $options = $this->param("values");
            if(!$options) {
                $options = $this->param("list");
            }
			
			// Разбор значений из строки
			if(!is_array($options)) {
				$ret = array();
				foreach(util::splitAndTrim($options, ",") as $key => $val) {
				    $ret[$key + 1] = $val;
				}
				$options = $ret;
			}
			
			return $options;  		
		}
		
	    if(func_num_args() == 1) {
			$this->param("values", $options);
			return $this;
		}

	}

}
