<?

namespace Infuso\Core\Model;
use infuso\util\util;

class Select extends Field {

	public function typeID() {
		return "fahq-we67-klh3-456t-plbo";
	}
	
	public function typeName() {
		return "Список";
	}

	public function mysqlType() {
		return "bigint(20)";
	}
	
	public function mysqlIndexType() {
		return "index";
	}

	public function editorInx() {
		return array(
		    "type" => "inx.mod.reflex.fields.select",
		    "value" => $this->value(),
		);
	}

	// Возвращает текстовое значение элемента списка
	public function tableRender() {
		return $this->pvalue();
	}

	// Возвращает текстовое значение элемента списка
	public function pvalue() {
		$values = $this->options();
		$ret = $values[$this->value()];
		if($ret===null) {
			$ret = "";
		}
		return $ret;
	}

	// Возвращает текстовое значение элемента списка
	public function rvalue() {
		return $this->pvalue();
	}

	/**
	 * Возвращает список значений ввиде массива $ключ => $значение
	 **/
	public function options($options=null) {
	
	    if(func_num_args()==0) {
	
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
		
	    if(func_num_args()==1) {
			$this->param("values",$options);
			return $this;
		}

	}

}
