<?

namespace Infuso\ActiveRecord\Migration;

use Infuso\Core;

class Index extends Core\Component {

	public function initialParams() {
	    return array(
	        "type" => "index",
		);
	}

	public function __construct($data=array()) {
		$this->params($data);
	}
	
	public function dataWrappers() {
	    return array(
	        "name" => "mixed",
	        "fields" => "mixed",
	        "length" => "mixed",
		);
	}

	public static function create() {
		return new self();
	}

	/**
	 * Возвращает / устанавливает тип индекса
	 * Тип индекса - это строка, которая может принимать два значения:
	 * "index" или "fulltext"
	 **/
	public function type($type = null) {

		if(func_num_args()==0) {
		
		    if(in_array($this->param("type"), array("index", "fulltext", "primary"))) {
		        return $this->param("type");
		    }
			
		    return "index";
	    }

	    if(func_num_args() == 1) {
	        $this->param("type",$type);
	        return $this;
		}
	}
	
}
