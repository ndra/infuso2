<?

/**
 * Виджет для меню в админке
 **/
class geo_admin_widget extends Infuso\Cms\Admin\Widgets\Widget {

	public function test() {
	    return mod_superadmin::check();
	}

	public function exec() {
		$url = mod::action("geo_admin_load")->url();
		echo "<a href='$url' >Загрузить города</a>";
	}

}
