<?

namespace Infuso\Board\Widget;
use \Infuso\Core;

/**
 * Виджет списка задач
 **/
class TaskList extends \Infuso\Template\Helper {

    public function status($status) {
        $this->param("status", $status);
        return $this;
    }
    
    public function toolbar() {
        $this->param("toolbar", true);
        return $this;
    }
    
	public function sortable() {
        $this->param("sortable", true);
        return $this;
    }
    
    public function execWidget() {
        app()->tm("/board/widget/task-list")
            ->param("widget", $this)
            ->params($this->params())
            ->exec();
    }

}
