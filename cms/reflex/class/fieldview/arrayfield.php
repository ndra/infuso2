<?

namespace Infuso\Cms\Reflex\FieldView;
use Infuso\Core;

class ArrayField extends View {

	/**
	 * Должна вернуть объект шаблона для редактирования поля
	 **/
	public function template() {
		$tmp = app()->tm("/reflex/fields/array");
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
    
    public function colWidth() {
        return 100;
    }

}
