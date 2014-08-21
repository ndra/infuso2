<?

namespace Infuso\Eshop\Form;
use Infuso\Core;
use Infuso\Eshop\Model;

/**
 * Модель группы для интернет-магазина
 **/
class Cart extends \Infuso\CMS\Form\RecordForm {

	public static function model() {
	    return Model\Cart::model();
	}

	public function recordClass() {
	    return Model\Cart::inspector()->className();
	}

}
