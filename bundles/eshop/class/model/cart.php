<?

namespace Infuso\Eshop\Model;
use Infuso\Core;

/**
 * Модель группы для интернет-магазина
 **/
class Cart extends \Infuso\ActiveRecord\Record {

	public static function recordTable() {
        return array (
      		'name' => 'eshop_cart',
      		'fields' => array (
			    array (
					'name' => 'id',
					'type' => 'jft7-kef8-ccd6-kg85-iueh',
					'label' => 'Первичный ключ',
					'indexEnabled' => '0',
				),
            ),
        );
    }


}
