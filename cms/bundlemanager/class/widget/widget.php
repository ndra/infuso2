<?

class moduleManager_widget extends Infuso\Cms\Admin\Widgets\Widget {

	public function exec() {

		$url = \Infuso\Core\Action::get("infuso\\cms\\bundlemanager\\controller\\main")->url();
		echo "<h2><a href='{$url}' >Управление модулями</a></h2>";
        
        $url = \Infuso\Core\Action::get("infuso\\cms\\bundlemanager\\controller\\main", "todo")->url();
        echo "<a href='{$url}' >todo</a> ";
        
        $url = \Infuso\Core\Action::get("infuso\\cms\\bundlemanager\\controller\\doc")->url();
        echo "<a href='{$url}' >Документация</a>";

	}

	public function test() {
		return mod_superadmin::check();
	}

}
