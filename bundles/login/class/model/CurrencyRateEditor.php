<?

namespace Infuso\Site\Model;
use Infuso\Core;

/**
 * Редактор курса валют
 **/
class CurrencyRateEditor extends \Infuso\CMS\Reflex\Editor {

    public function itemClass() {
        return CurrencyRate::inspector()->className();
    }

    /**
     * @reflex-root = on
     **/         
    public function all() {
        return CurrencyRate::all()
            ->title("Курсы валют");
    }
    
}
