<?

namespace Infuso\Cms\Reflex\Model;
use Infuso\Cms\Reflex;
use Infuso\Core;
use Infuso\ActiveRecord;

/**
 * Редактор домена
 **/
class DomainEditor extends Reflex\Editor {

	public function itemClass() {
		return Domain::inspector()->className();
	}

	/**
	 * @reflex-root = on
	 **/
	public function all() {
	    return Domain::all()->title("Домены");
	}

}
