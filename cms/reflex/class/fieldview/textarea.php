<?

namespace Infuso\Cms\Reflex\FieldView;
use Infuso\Core;

class Textarea extends View {

	/**
	 * Должна вернуть объект шаблона для редактирования поля
	 **/
	public function template() {
		$tmp = app()->tm("/reflex/fields/textarea");
		$tmp->param("field", $this->field);
		$tmp->param("view", $this);
		return $tmp;
	}
	
	/**
	 * Доблжна вернуть id типа поля
	 * (Может вернуть массив из нескольких id)
	 **/
	public static function typeID() {
	    return "kbd4-xo34-tnb3-4nxl-cmhu";
	}
    
    public function colWidth() {
        return 100;
    }
    
    public function filterTemplate() {
    	$tmp = app()->tm("/reflex/field-filters/textfield");
		$tmp->param("name", $this->field()->name());
		return $tmp;
    }

}
