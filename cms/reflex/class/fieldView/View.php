<?

namespace Infuso\Cms\Reflex\FieldView;
use Infuso\Core;

abstract class View extends Core\Component {

	protected $field = null;

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

}
