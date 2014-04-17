<?

namespace Infuso\Cms\UI\Widgets;

class Textfield extends Input {

	public function name() {
	    return "Текстовое поле";
	}

	public function execWidget() {

		$this->app()->tmp()
			->exec("/ui/widgets/textfield",array (
			    "widget" => $this,
			));
	}

}
