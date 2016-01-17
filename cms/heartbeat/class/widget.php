<?

namespace Infuso\Cms\Heartbeat;

class Widget extends \Infuso\Cms\Admin\Widgets\Widget {

	public function exec() {
	
		$url = \infuso\core\action::get(Controller::inspector()->classname())->url();
		echo "<a href='{$url}' >Пульс</a> ";

	}

	public function test() {
		return \infuso\core\superadmin::check();
	}

}
