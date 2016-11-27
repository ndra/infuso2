<?

namespace Infuso\Cms\Reflex\FieldView;
use Infuso\Core;

class Links extends View {

	/**
	 * Должна вернуть объект шаблона для редактирования поля
	 **/
	public function template() {
		$tmp = app()->tm($this->field()->param("template") ?: "/reflex/fields/links");
		$tmp->param("field", $this->field());
        $tmp->param("editor", $this->editor());
		return $tmp;
	}
	
	/**
	 * Доблжна вернуть id типа поля
	 * (Может вернуть массив из нескольких id)
	 **/
	public static function typeID() {
	    return  "car3-mlid-mabj-mgi3-8aro";
	}

}
