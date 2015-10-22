<?

namespace Infuso\Cms\Reflex\Model;
use Infuso\Cms\Reflex;
use Infuso\Core;
use Infuso\ActiveRecord;

class RedirectEditor extends Reflex\Editor {

	public function itemClass() {
		return Redirect::inspector()->className();
	}

	/**
	 * @reflex-root = on
	 * @reflex-tab = system
	 **/
	public function all() {
	    return Redirect::all()->title("Редиректы");
	}
    
    /*public function filters($collection) {
        return array(
            "Пользовательские" => $collection->copy()->eq("hash", ""),
            "Метаданные" => $collection->copy()->neq("hash", ""),
        );
    }*/

}
