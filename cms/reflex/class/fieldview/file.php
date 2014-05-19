<?

namespace Infuso\Cms\Reflex\FieldView;
use Infuso\Core;

class File extends View {

	/**
	 * Доолжна вернуть объект шаблона для редактирования поля
	 **/
	public function template() {
		$tmp = \Infuso\Template\Tmp::get("/reflex/fields/file");
		$tmp->param("field", $this->field);
		$tmp->param("view", $this);
		return $tmp;
	}
	
	/**
	 * Доблжна вернуть id типа поля
	 * (Может вернуть массив из нескольких id)
	 **/
	public static function typeID() {
	    return "knh9-0kgy-csg9-1nv8-7go9";
	}
    
    public function colWidth() {
        return 50;
    }

}
