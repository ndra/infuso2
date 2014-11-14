<?

namespace Infuso\Board\Widget;
use \Infuso\Core;

/**
 * Виджет списка задач
 **/
class Timeline extends \Infuso\Template\Widget {

	public function name() {
	    return "Таймлайн";
	}
	
	public function taskId($id) {
	    $this->param("taskId", $id);
	    return $this;
	}
	
	public function execWidget() {
	
        $workflow = \Infuso\Board\Model\Workflow::all()
            ->limit(0);
            
        if($id = $this->param("taskId")) {
            $workflow->eq("taskId", $id);
        }
	
	    app()->tm("/board/widget/timeline")
	        ->param("workflow", $workflow)
			->exec();
	}

}
