<?

namespace Infuso\Cms\Reflex\FieldView;
use Infuso\Core;

class Multiselect extends View {

	/**
	 * Должна вернуть объект шаблона для редактирования поля
	 **/
	public function template() {
		$tmp = app()->tm("/reflex/fields/multiselect");
		$tmp->param("field", $this->field);
		return $tmp;
	}
	
	/**
	 * Доблжна вернуть id типа поля
	 * (Может вернуть массив из нескольких id)
	 **/
	public static function typeID() {
	    return "ZMDh1GXeiTRw";
	}
    
}
