<?

namespace Infuso\Cms\Reflex\Model;
use Infuso\Cms\Reflex;
use Infuso\Core;
use Infuso\ActiveRecord;

/**
 * Редактор домена
 **/
class LogEditor extends Reflex\Editor {

	public function itemClass() {
		return Log::inspector()->className();
	}

	/**
	 * @reflex-root = on
	 **/
	public function all() {
	    return Log::all()->title("Лог");
	}

}
