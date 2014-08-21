<?

namespace Infuso\CMS\Form;
use \Infuso\Core;

/**
 * Базовый класс для форм
 **/
abstract class Base extends Core\Model\Model {

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
