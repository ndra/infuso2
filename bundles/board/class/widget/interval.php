<?

namespace Infuso\Board\Widget;
use \Infuso\Core;

/**
 * Виджет списка задач
 **/
class Interval extends \Infuso\Template\Widget {

	public function name() {
	    return "Интервал";
	}
	
	public function nameFrom($name) {
	    $this->param("nameFrom", $name);
	    return $this;
	}

	public function nameTo($name) {
	    $this->param("nameTo", $name);
	    return $this;
	}
	
	public function valueFrom($name) {
	    $this->param("valueFrom", $name);
	    return $this;
	}

	public function valueTo($name) {
	    $this->param("valueTo", $name);
	    return $this;
	}

	public function execWidget() {
	    app()->tm("/board/widget/interval")
	        ->param("widget", $this)
			->exec();
	}

}
