<?

namespace Infuso\Cms\Reflex\FieldView;
use Infuso\Core;

class Select extends View {

	/**
	 * Должна вернуть объект шаблона для редактирования поля
	 **/
	public function template() {
		$tmp = app()->tm("/reflex/fields/select");
		$tmp->param("field", $this->field);
		return $tmp;
	}
	
	/**
	 * Доблжна вернуть id типа поля
	 * (Может вернуть массив из нескольких id)
	 **/
	public static function typeID() {
	    return array("fahq-we67-klh3-456t-plbo", "uR7kW3UhmhC");
	}
    
    public function colWidth() {
        return 100;
    }

}
