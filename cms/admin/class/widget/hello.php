<?

namespace Infuso\Cms\Admin\Widgets;
use Infuso\Core;

class Hello extends Widget {

	/**
	 * Выполняет виджет
	 **/
	public function exec() {
		tmp::exec("/admin/hello");
	}

	public function width() {
		return 600;
	}

	public function inMenu() {
		return false;
	}

	public function inStartPage() {
		return true;
	}

}
