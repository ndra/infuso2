<?

namespace Infuso\CMS\Form;
use \Infuso\Core;

/**
 * Базовый класс для форм
 **/
abstract class Base extends Core\Model\Model {

    abstract public function formFields();

    public function fieldParams($name) {
		foreach($this->formFields() as $fieldDescr) {
		    if($fieldDescr["name"] == $name) {
		        return $fieldDescr;
		    }
		}
    }
    
    /**
     * Возвращает массив с именами полей
     **/
    public function fieldNames() {
        $model = $this->formFields();
		foreach($model as $fieldDescr) {
		    $names[] = $fieldDescr["name"];
		}
		return $names;
    }
    
    /**
     * Метод выполняется при изменении данных модели
     **/
    public function handleModelDataChanged() {
        // do nothing;
    }
    
    public function builder() {
        return new Builder($this);
    }

}
