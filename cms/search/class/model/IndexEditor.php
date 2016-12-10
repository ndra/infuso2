<?

namespace Infuso\Cms\Search\Model;
use \Infuso\Core;

/**
 * Редактор индекса поиска
 **/
class IndexEditor extends \Infuso\CMS\Reflex\Editor {

	public function itemClass() {
	    return Index::inspector()->className();
	}

	/**
	 * @reflex-root = on
	 * @reflex-tab = system
	 **/
	public function all() {
	    return Index::all()
			->title("Данные для поиска");
	}
    

}
