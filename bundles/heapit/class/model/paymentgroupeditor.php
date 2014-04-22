<?

namespace Infuso\Heapit\Model;
use \Infuso\Core;

class PaymentGroupEditor extends \Infuso\Cms\Reflex\Editor {

	/**
	 * @reflex-root = on
	 **/
	public function all() {
	    return PaymentGroup::all()->title("Статьи доходов / расходов");
	}

	public function itemClass() {
	    return PaymentGroup::inspector()->className();
	}

}

