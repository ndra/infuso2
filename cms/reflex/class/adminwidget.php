<?

namespace Infuso\Cms\Reflex;
use Infuso\Core;

/**
 * Виджет меню для интернет-магазина
 **/
class adminWidget extends \Infuso\Cms\Admin\Widgets\Widget {

	public function test() {
		return true;
	}

	public function exec() {

		$url = $url = Core\Action::get("infuso\\cms\\reflex\\controller")->url();
		echo "<a href='{$url}' >Каталог</a> ";
		
		$url = $url = Core\Action::get("infuso\\cms\\reflex\\controller\\sync")->url();
		echo "<a href='{$url}' >Синхронизация</a>";

	}

}
