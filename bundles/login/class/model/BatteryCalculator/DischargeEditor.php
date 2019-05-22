<?

namespace Infuso\Site\Model\BatteryCalculator;
use Infuso\Core;

/**
 * Редактор разряда
 **/
class DischargeEditor extends \Infuso\CMS\Reflex\Editor {

    public function itemClass() {
        return Discharge::inspector()->className();
    }     
    
    public function title() {     
        $item = $this->item();
        return $item->data("rate")."C";         
    }
    
    public function listItemTemplate() {
        return app()->tm("/site/admin/discharge-list-item")         
            ->param("editor", $this);
    }
    
}
