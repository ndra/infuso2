<?

namespace Infuso\Cms\Utils;

class Widget extends \Infuso\Cms\Admin\Widgets\Widget {

	public function exec() {
	
		$url = \infuso\core\action::get(Heartbeat\Controller::inspector()->classname())->url();
		echo "<a href='{$url}' >Пульс</a> ";

		$url = \infuso\core\action::get(Sql::inspector()->classname())->url();
		echo "<a href='{$url}' >Консоль SQL</a> ";
		
		$url = \infuso\core\action::get(Handlers::inspector()->classname())->url();
		echo "<a href='{$url}' >События</a> ";
        
		$url = \infuso\core\action::get(Services::inspector()->classname())->url();
		echo "<a href='{$url}' >Службы</a> ";        
		
		$url = \infuso\core\action::get(Cron::inspector()->classname())->url();
		echo "<a href='{$url}' >Крон</a> ";

	}

	public function test() {
		return \infuso\core\superadmin::check();
	}

}
