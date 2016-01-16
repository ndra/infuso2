<?

namespace Infuso\Poll;

/**
 * Виджет опроса
 **/
class Widget extends \Infuso\Template\Helper {

	public function name() {
		return "Опрос";
	}
    
    public function alias() {
        return "poll";
    }

	public function execWidget() {
    
        $content = app()->tm("/poll/widget")
            ->rexec();

        $this->tag("div");
        $this->param("content", $content);
        
        parent::execWidget();

	}

}
