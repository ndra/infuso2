<?

namespace Infuso\Cms\UI\Widgets;

class Textfield extends Input {

	public function name() {
	    return "Текстовое поле";
	}

    public function clearButton() {
        $this->param("clearButton", true);
        return $this;
    }

	public function execWidget() {
		$this->app()->tmp()
			->exec("/ui/widgets/textfield",array (
			    "widget" => $this,
			));
	}

}
