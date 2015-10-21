<?

namespace Infuso\Poll;

/**
 * Виджет опроса
 **/
class Widget extends \Infuso\Template\Widget {

	public function name() {
		return "Опрос";
	}
    
    public function alias() {
        return "poll";
    }

	public function execWidget() {
        app()->tm("/poll/widget")
            ->exec();
	}

}
