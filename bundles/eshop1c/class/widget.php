<?

namespace Infuso\Eshop1C;
use \Infuso\Core;

/**
 * Набор утилит для импорта товаров
 **/ 
class Widget extends \Infuso\CMS\Admin\Widgets\Widget {

	public function exec() { 	
		$url = \infuso\core\action::get(Controller\Import::inspector()->classname())->url();
		echo "<a href='{$url}' >Выгрузка в 1С</a> "; 
	}

	public function test() {
		return \infuso\core\superadmin::check();
	}

}
