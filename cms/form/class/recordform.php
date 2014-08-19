<?

namespace Infuso\CMS\Form;
use \Infuso\Core;

/**
 * Базовый класс для форм
 **/
abstract class RecordForm extends Base {

	abstract public function recordClass();

    public function formFields() {
    
        //$item = new self::recordClass();
        foreach($item->fields() as $field) {
        
        }
    
    }

}
