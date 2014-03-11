<?

namespace Infuso\Cms\Reflex\FieldView;
use Infuso\Core;

class Textarea extends View {

	/**
	 * Доолжна вернуть объект шаблона для редактирования поля
	 **/
	public function template() {
		$tmp = \Infuso\Template\Tmp::get("/reflex/fields/textarea");
		$tmp->param("field", $this->field);
		return $tmp;
	}
	
	/**
	 * Доблжна вернуть id типа поля
	 * (Может вернуть массив из нескольких id)
	 **/
	public static function typeID() {
	    return "kbd4-xo34-tnb3-4nxl-cmhu";
	}

}