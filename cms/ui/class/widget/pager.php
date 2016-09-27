<?

namespace Infuso\Cms\UI\Widgets;

class Pager extends Input {

	public function name() {
	    return "Пейджер";
	}

	public function execWidget() {
		app()->tm()->js(Pager::inspector()->bundle()->path()."/res/js/pager.js");

        if(!$this->param("value")) {
            $this->param("value", 1);
        }

		app()->tm()
			->exec("/ui/widgets/pager",array (
			    "widget" => $this,
			));
	}

}
