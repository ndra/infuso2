<?

namespace Infuso\Cms\Reflex\Model;
use Infuso\Cms\Reflex;
use Infuso\Core;
use Infuso\ActiveRecord;

class RouteEditor extends Reflex\Editor {

	public function itemClass() {
		return Route::inspector()->className();
	}

	/**
	 * @reflex-root = on
	 * @reflex-tab = system
	 **/
	public function all() {
	    return Route::all()->title("Роуты");
	}
    
    public function filters($collection) {
        return array(
            "Пользовательские" => $collection->copy()->eq("hash", ""),
            "Метаданные" => $collection->copy()->neq("hash", ""),
        );
    }
    
    public function metaEnabled() {
        return $this->item()->data("hash")== "";
    }
    
    public function listItemTemplate() {
        return app()->tm("/reflex/route/list-item")
            ->param("editor", $this);
    }

}
