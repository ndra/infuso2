<?

namespace Infuso\CMS\Form;
use \Infuso\Core;

/**
 * Базовый класс для форм
 **/
abstract class RecordForm extends Base {

	abstract public function recordClass();

    public function formFields() {
    
        $class = $this->recordClass();
        $item = new $class;
        
        $data = array();
        foreach($item->fields() as $field) {
            $data[] = $field->params();
        }
        
        return $data;
    
    }

}
