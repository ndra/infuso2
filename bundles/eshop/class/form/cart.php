<?

namespace Infuso\Eshop\Form;
use Infuso\Core;
use Infuso\Eshop\Model;

/**
 * Модель группы для интернет-магазина
 **/
class Cart extends \Infuso\CMS\Form\Base {

	public static function model() {
	    return Model\Cart::model();
	}

}
