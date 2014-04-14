<?

namespace Infuso\Cms\UI\Widgets;

abstract class Input extends \Infuso\Template\Helper {

	public function name() {
	    return "Текстовое поле";
	}
	
	public final function fieldName($name) {
	    $this->param("name", $name);
	    return $this;
	}
	
	public final function value($value) {
	    $this->param("value", $value);
	    return $this;
	}
	
}
