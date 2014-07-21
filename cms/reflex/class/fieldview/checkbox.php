<?

namespace Infuso\Cms\Reflex\FieldView;
use Infuso\Core;

class Checkbox extends View {

	/**
	 * Доолжна вернуть объект шаблона для редактирования поля
	 **/
	public function template() {
		$tmp = app()->tm("/reflex/fields/checkbox");
		$tmp->param("field", $this->field);
		return $tmp;
	}
	
	/**
	 * Доблжна вернуть id типа поля
	 * (Может вернуть массив из нескольких id)
	 **/
	public static function typeID() {
	    return "fsxp-lhdw-ghof-1rnk-5bqp";
	}
	
	public function labelAlign() {
	    return self::LABEL_ALIGN_CHECKBOX;
	}
    
    public function colWidth() {
        return 20;
    }

}
