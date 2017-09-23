<?

namespace Infuso\Parser\Model;
use Infuso\Core;

class ProjectEditor extends \Infuso\Cms\Reflex\Editor {

	/**
	 * @reflex-root = on
	 * @reflex-group = Парсер
	 **/
	public function all() {
	    return Project::all()->title("Проекты");
	}
    
	/**
	 * @reflex-child = on
	 **/
	public function pages() {
	    return $this->item()->pages()->title("Страницы");
	}
	
	public function itemClass() {
	    return Project::inspector()->className();
	}

}
