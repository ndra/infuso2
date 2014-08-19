<?

namespace Infuso\Eshop\Form;
use Infuso\Core;
use Infuso\Eshop\Model;

/**
 * Модель группы для интернет-магазина
 **/
class Cart extends \Infuso\CMS\Form\RecordForm {

	public function recordClass() {
	    return Model\Cart::inspector()->className();
	}

}
