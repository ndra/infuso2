<?

namespace Infuso\Site\Model\BatteryCalculator;
use Infuso\Core;

/**
 * Редактор пресета
 **/
class BatteryPresetEditor extends \Infuso\CMS\Reflex\Editor {

    public function itemClass() {
        return BatteryPreset::inspector()->className();
    }

    /**
     * @reflex-root = on
     **/         
    public function all() {
        return BatteryPreset::all()
            ->title("Готовые батареи")
            ->param("sort", true);
    }
    
}
