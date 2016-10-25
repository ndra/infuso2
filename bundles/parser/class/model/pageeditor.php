<?

namespace Infuso\Parser\Model;
use Infuso\Core;

class PageEditor extends \Infuso\Cms\Reflex\Editor {

	/**
	 * @reflex-root = on
	 * @reflex-group = Парсер
	 **/
	public function all() {
	    return Page::all()->title("Страницы");
	}
	
	public function itemClass() {
	    return Page::inspector()->className();
	}
    
    public function filters($collection) {
        return array(
            "Все" => $collection->copy(),
            "Готово" => $collection->copy()->eq("status", 1),
            "Не готово" => $collection->copy()->eq("status", 0),
            "Ошибка" => $collection->copy()->eq("status", 2),
        );
    }

}
