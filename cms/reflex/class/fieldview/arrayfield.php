<?

namespace Infuso\Cms\Reflex\FieldView;
use Infuso\Core;

class ArrayField extends View {

	/**
	 * Должна вернуть объект шаблона для редактирования поля
	 **/
	public function template() {
		$tmp = \Infuso\Template\Tmp::get("/reflex/fields/array");
		$tmp->param("field", $this->field);
		return $tmp;
	}
	
	/**
	 * Доблжна вернуть id типа поля
	 * (Может вернуть массив из нескольких id)
	 **/
	public static function typeID() {
	    return "puhj-w9sn-c10t-85bt-8e67";
	}

}
