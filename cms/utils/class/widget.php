<?

namespace infuso\cms\utils;

class widget extends \admin_widget {

	public function exec() {

		$url = \infuso\core\action::get(sql::inspector()->classname())->url();
		echo "<a href='{$url}' >Консоль SQL</a> ";
		
		$url = \infuso\core\action::get(Handlers::inspector()->classname())->url();
		echo "<a href='{$url}' >События</a></h2>";

	}

	public function test() {
		return \infuso\core\superadmin::check();
	}

}
