<?

namespace Infuso\Cms\Reflex\FieldView;
use Infuso\Core;

abstract class View extends Core\Component {

	const LABEL_ALIGN_LEFT  = 1;
	const LABEL_ALIGN_TOP  = 2;
	const LABEL_ALIGN_CHECKBOX  = 3;

	protected $field = null;
	protected $editor = null;

	public function __construct($field) {
	    $this->field = $field;
	}
	
	public static function get($field) {
	    $typeID = $field->typeID();
	    foreach(Core\Mod::service("classmap")->classes(get_class()) as $class) {
			$ids = $class::typeID();
			if(!is_array($ids)) {
			    $ids = array($ids);
			}
			if(in_array($typeID,$ids)) {
			    return new $class($field);
			}
	    }
	    return new Str($field);
	}
	
	/**
	 * Доолжна вернуть объект шаблона для редактирования поля
	 **/
	abstract public function template();
	
	/**
	 * Доблжна вернуть id типа поля
	 * (МОжет вернуть массив из нескольких id)
	 **/
	abstract public static function typeID();
	
	/**
	 * Возвращает типа расположения метки поля в форме
	 * Переопределите метод в дочернем классе, если нужно изменить расположение метки в форме
	 **/
	public function labelAlign() {
	    return self::LABEL_ALIGN_LEFT;
	}
	
	public function setEditor($editor) {
	    $this->editor = $editor;
	}
	
	public function editor() {
		return $this->editor;
	}

}
