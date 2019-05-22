<?

namespace Infuso\Site\Model\BatteryCalculator;
use Infuso\Core;

/**
 * Редактор цен ячейки
 **/
class CellPriceEditor extends \Infuso\CMS\Reflex\Editor {

    public function itemClass() {
        return CellPrice::inspector()->className();
    }
    
}
