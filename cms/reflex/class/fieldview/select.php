<?

namespace Infuso\Cms\Reflex\FieldView;
use Infuso\Core;

class Select extends View {

	/**
	 * Должна вернуть объект шаблона для редактирования поля
	 **/
	public function template() {
		$tmp = \Infuso\Template\Tmp::get("/reflex/fields/select");
		$tmp->param("field", $this->field);
		return $tmp;
	}
	
	/**
	 * Доблжна вернуть id типа поля
	 * (Может вернуть массив из нескольких id)
	 **/
	public static function typeID() {
	    return "fahq-we67-klh3-456t-plbo";
	}
    
    public function colWidth() {
        return 100;
    }

}
