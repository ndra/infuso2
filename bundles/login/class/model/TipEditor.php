<?

namespace Infuso\Site\Model;
use Infuso\Core;

/**
 * Редактор всплывающих подсказок
 **/
class TipEditor extends \Infuso\CMS\Reflex\Editor {

    public function itemClass() {
        return Tip::inspector()->className();
    }

    /**
     * @reflex-root = on
     **/         
    public function all() {
        return Tip::all()
            ->title("Подсказки");
    }
    
    public function listItemTemplate() {
        return app()->tm("/site/admin/tip-list-item")         
            ->param("editor", $this);
    }
    
}
