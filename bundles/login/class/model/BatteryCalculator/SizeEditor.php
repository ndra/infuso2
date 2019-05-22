<?

namespace Infuso\Site\Model\BatteryCalculator;
use Infuso\Core;

/**
 * Редактор типоразмера
 **/
class SizeEditor extends \Infuso\CMS\Reflex\Editor {

    public function itemClass() {
        return Size::inspector()->className();
    }

    /**
     * @reflex-root = on
     **/         
    public function all() {
        return Size::all()
            ->title("Типоразмеры");
    }
    
    /**
     * @reflex-child = on
     **/         
    public function prices() {
        return $this->item()
            ->prices()
            ->title("Цены");
    }
    
}
