<?

namespace Infuso\CMS\Form;
use \Infuso\Core;

/**
 * Базовый класс для форм
 **/
abstract class Base extends Core\Model\Model {

    abstract public function formFields();

    public function fieldFactory($name) {
		$ret = null;
		foreach($this->formFields() as $fieldDescr) {
		    if($fieldDescr["name"] == $name) {
		        $ret = Core\Model\Field::get($fieldDescr);
		    }
		}
		return $ret;
    }
    
    public function fieldNames() {
    
        $model = $this->formFields();        
       
		foreach($model as $fieldDescr) {
		    $names[] = $fieldDescr["name"];
		}
        
		return $names;
    }
    
    public function handleRecordDataChanged() {
        // do nothing;
    }
    
    public function builder() {
        return new Builder($this);
    }

}
