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

}
