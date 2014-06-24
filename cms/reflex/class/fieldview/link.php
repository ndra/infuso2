<?

namespace Infuso\Cms\Reflex\FieldView;
use Infuso\Core;

class Link extends View {

	/**
	 * Доолжна вернуть объект шаблона для редактирования поля
	 **/
	public function template() {
		$tmp = \Infuso\Template\Tmp::get("/reflex/fields/link");
		$tmp->param("field", $this->field);
		$tmp->param("editor", $this->editor());
		return $tmp;
	}
	
	/**
	 * Доблжна вернуть id типа поля
	 * (Может вернуть массив из нескольких id)
	 **/
	public static function typeID() {
	    return "pg03-cv07-y16t-kli7-fe6x";
	}
    
    public function colWidth() {
        return 50;
    }

}
