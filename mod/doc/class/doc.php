<?

/**
 * ���������� ������������
 **/
class doc extends mod_controller {

	public static function indexTest() {
		return mod_superadmin::check();
	}

	public static function indexFailed() {
		return admin::fuckoff();
	}

	/**
	 * ���������� ������� �������� ������������
	 **/
	public static function index() {
		tmp::add("center","doc:todo");
		tmp::add("left","doc:menu");
		tmp::exec("doc:layout");
	}

	/**
	 * ���������� �������� ������
	 **/
	public static function index_class($p) {
		tmp::add("center","doc:class",$p["class"]);
		tmp::add("left","doc:menu");
		tmp::exec("doc:layout");
	}
	
	/**
	 * ���������� ������� ��� ������ �������� ������
	 **/
	public static function index_package($p) {
		tmp::add("center","doc:package",$p["package"]);
		tmp::add("left","doc:menu");
		tmp::exec("doc:layout");
	}
	
}
