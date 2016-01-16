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
        $this->style("border", "1px solid red");
        $this->param("content", $content);
        
        parent::execWidget();

	}

}
