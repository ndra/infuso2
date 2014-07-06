<?

namespace Infuso\Cms\UI\Widgets;

class Pager extends Input {

	public function name() {
	    return "Текстовое поле";
	}

	public function execWidget() {

        if(!$this->param("value")) {
            $this->param("value", 1);
        }

		$this->app()->tm()
			->exec("/ui/widgets/pager",array (
			    "widget" => $this,
			));
	}

}
