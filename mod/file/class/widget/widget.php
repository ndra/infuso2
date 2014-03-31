<?

class file_widget extends Infuso\Cms\Admin\Widgets\Widget {

	public function exec() {
		$url = mod_action::get("file_tools")->url();
		echo "<a href='{$url}' >Очистка превьюшек</a><br/>";
	}

	public function test() {
		return mod_superadmin::check();
	}

}
