<?

namespace Infuso\Cms\Log;
use Infuso\Core;
use Infuso\ActiveRecord;
use Infuso\Cms\Reflex;


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
