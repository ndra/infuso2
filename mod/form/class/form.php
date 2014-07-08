<?

namespace Infuso\Core;
use \Infuso\Core;

/**
 * Базовый класс для форм
 **/
class Form extends Core\Model\Model {

    public function fieldFactory($name) {
		$model = $this->recordTable();
		$ret = null;
		foreach($model["fields"] as $fieldDescr) {
		    if($fieldDescr["name"] == $name) {
		        $ret = Model\Field::get($fieldDescr);
		    }
		}
		return $ret;
    }
    
    public function fieldNames() {
    }
    
    public function handleRecordDataChanged() {
    }

}
