<?

namespace Infuso\Site\Model;
use Infuso\Core;

/**
 * Редактор страницы
 **/
class PageEditor extends \Infuso\CMS\Reflex\Editor {

    public function itemClass() {
        return Page::inspector()->className();
    }

    /**
     * @reflex-root = on
     **/         
    public function all() {
        return Page::all()
            ->title("Страницы")
            ->param("sort", true);
    }
    
    public function metaEnabled() {
        return true;
    }
    
}
