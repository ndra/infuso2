<?

namespace Infuso\Site\Model\BatteryCalculator;
use Infuso\Core;

/**
 * Редактор химии
 **/
class ChemistryEditor extends \Infuso\CMS\Reflex\Editor {

    public function itemClass() {
        return Chemistry::inspector()->className();
    }

    /**
     * @reflex-root = on
     **/         
    public function all() {
        return Chemistry::all()
            ->title("Химия");
    }
    
    public function metaEnabled() {
        return true;
    }
    
}
