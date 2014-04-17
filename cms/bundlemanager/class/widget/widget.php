<?

class moduleManager_widget extends Infuso\Cms\Admin\Widgets\Widget {

	public function exec() {

		$url = mod_action::get("moduleManager")->url();
		echo "<h2><a href='{$url}' >Управление модулями</a></h2>";

	}

	public function test() {
		return mod_superadmin::check();
	}

}
