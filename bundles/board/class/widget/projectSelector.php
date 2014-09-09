<?

namespace Infuso\Board\Widget;
use \Infuso\Core;

/**
 * Виджет списка задач
 **/
class ProjectSelector extends \Infuso\Template\Helper {

    public function fieldName() {
        return $this;
    }
    
    public function value() {
        return $this;
    }
   
    public function execWidget() {
        app()->tm("/board/widget/project-selector")
            ->param("widget", $this)
            ->params($this->params())
            ->exec();
    }

}
