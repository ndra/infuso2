<?

namespace Infuso\Cms\UI\Widgets;

class Pager extends Input {

	public function name() {
	    return "Текстовое поле";
	}

	public function execWidget() {
		$this->app()->tmp()
			->exec("/ui/widgets/pager",array (
			    "widget" => $this,
			));
	}

}
