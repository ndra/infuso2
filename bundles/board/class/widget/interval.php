<?

namespace Infuso\Board\Widget;
use \Infuso\Core;

/**
 * Виджет списка задач
 **/
class Interval extends \Infuso\Template\Widget {

	public function name() {
	    return "Интервал";
	}

	public function execWidget() {
	    app()->tm("/board/widget/interval")
			->exec();
	}

}
