<?

namespace Infuso\Site\Model\BatteryCalculator;
use Infuso\Core;

/**
 * Редактор производителя
 **/
class VendorEditor extends \Infuso\CMS\Reflex\Editor {

    public function itemClass() {
        return Vendor::inspector()->className();
    }

    /**
     * @reflex-root = on
     **/         
    public function all() {
        return Vendor::all()
            ->title("Производители");
    }
    
}
