<?

namespace Infuso\Cms\Reflex\FieldView;
use Infuso\Core;

class NumberView extends View {

	/**
	 * Должна вернуть объект шаблона для редактирования поля
	 **/
	public function template() {
		$tmp = \Infuso\Template\Tmp::get("/reflex/fields/integer");
		$tmp->param("field", $this->field);
		return $tmp;
	}
	
	/**
	 * Доблжна вернуть id типа поля
	 * (Может вернуть массив из нескольких id)
	 **/
	public static function typeID() {
		return "gklv-0ijh-uh7g-7fhu-4jtg";
	}
    
    public function colWidth() {
        return 50;
    }

}
