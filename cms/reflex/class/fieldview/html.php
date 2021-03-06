<?

namespace Infuso\Cms\Reflex\FieldView;
use Infuso\Core;

class HTML extends View {

	/**
	 * Должна вернуть объект шаблона для редактирования поля
	 **/
	public function template() {
		$tmp = app()->tm("/reflex/fields/textarea");
		$tmp->param("field", $this->field);
		$tmp->param("view", $this);
        $tmp->param("html", true);
		return $tmp;
	}
	
	/**
	 * Доблжна вернуть id типа поля
	 * (Может вернуть массив из нескольких id)
	 **/
	public static function typeID() {
	    return "fgkn-o95h-uikx-c878-k4bi";
	}
    
    public function colWidth() {
        return 100;
    }

}
