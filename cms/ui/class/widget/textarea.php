<?

namespace Infuso\Cms\UI\Widgets;

class Textarea extends Input {

	public function name() {
	    return "Текстовое поле";
	}

	public function execWidget() {
		$this->app()->tmp()
			->exec("/ui/widgets/textarea",array (
			    "widget" => $this,
			));
	}

}
