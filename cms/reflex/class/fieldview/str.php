<?

namespace Infuso\Cms\Reflex\FieldView;
use Infuso\Core;

class Str extends View {


	/**
	 * Доолжна вернуть объект шаблона для редактирования поля
	 **/
	public function template() {
		$tmp = \Infuso\Template\Tmp::get("/reflex/fields/textfield");
		$tmp->param("field", $this->field);
		return $tmp;
	}
	
	/**
	 * Доблжна вернуть id типа поля
	 * (Может вернуть массив из нескольких id)
	 **/
	public static function typeID() {
	    return array();
	}

}
