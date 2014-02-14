<?

namespace Infuso\ActiveRecord\Migration;

use Infuso\Core;

class Index extends Core\Component {

	public function __construct($data=array()) {
		$this->params($data);
	}
	
	public function dataWrappers() {
	    return array(
	        "name" => "mixed",
	        "fields" => "mixed",
	        "automatic" => "mixed",
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
	public function type($type=null) {

		if(func_num_args()==0) {
			if($this->param("type")=="fulltext") {
				return "fulltext";
			}
		    return "index";
	    }

	    if(func_num_args()==1) {
	        $this->param("type",$type);
	        return $this;
		}
	}

	public function fulltext() {
		return $this->type("fulltext");
	}

	public final function table() {
		return $this->table;
	}

	public final function setTable($table) {
	    $this->table = $table;
	}

}
