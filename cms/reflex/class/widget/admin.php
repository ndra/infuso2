<?

namespace Infuso\Cms\Reflex\Widget;
use Infuso\Core;

/**
 * Виджет меню для каталога
 **/
class Admin extends \Infuso\Cms\Admin\Widgets\Widget {

	public function test() {
		return true;
	}
    
    public function width() {
        return 100;
    }

	public function exec() {

		$url = $url = Core\Action::get("infuso\\cms\\reflex\\controller")->url();
		echo "<h2><a href='{$url}' >Каталог</a></h2> ";
		
        if(Core\Superadmin::check()) {
    		$url = $url = Core\Action::get("infuso\\cms\\reflex\\controller\\sync")->url();
    		echo "<a href='{$url}' >Синхронизация</a>";
        }

	}

}
