<?

namespace Infuso\Cms\Reflex\FieldView;
use Infuso\Core;

class Price extends NumberView {

	/**
	 * Должна вернуть объект шаблона для редактирования поля
	 **/
	public function template() {
		$tmp = app()->tm("/reflex/fields/integer");
		$tmp->param("field", $this->field);
		return $tmp;
	}
	
	/**
	 * Доблжна вернуть id типа поля
	 * (Может вернуть массив из нескольких id)
	 **/
	public static function typeID() {
		return "nmu2-78a6-tcl6-owus-t4vb";
	}
    
    public function colWidth() {
        return 50;
    }

}
