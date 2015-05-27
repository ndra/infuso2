<?

namespace Infuso\Cms\Reflex\Model;
use Infuso\Cms\Reflex;
use Infuso\Core;
use Infuso\ActiveRecord;

/**
 * Редактор домена
 **/
class ConfEditor extends Reflex\Editor {

	public function itemClass() {
		return Conf::inspector()->className();
	}

	/**
	 * @reflex-root = on
	 * @reflex-tab = system
	 **/
	public function all() {
	    return Conf::all()->param("sort",true)->title("Настройки");
	}

}
