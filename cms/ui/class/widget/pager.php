<?

namespace Infuso\Cms\UI\Widgets;

class Pager extends Input {

	public function name() {
	    return "Пейджер";
	}

	public function execWidget() {
		app()->tm()->js(self::path()."/js/pager.js");

        if(!$this->param("value")) {
            $this->param("value", 1);
        }

		$this->app()->tm()
			->exec("/ui/widgets/pager",array (
			    "widget" => $this,
			));
	}

}
