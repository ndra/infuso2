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
	
	public function userId($id) {
	    $this->param("userId", $id);
	    return $this;
	}
	
	public function execWidget() {
	
        $workflow = \Infuso\Board\Model\Workflow::all()
            ->visible()
            ->limit(0);
            
        if($id = $this->param("taskId")) {
            $workflow->eq("taskId", $id);
        }
        
        if($id = $this->param("userId")) {
            $workflow->eq("userId", $id);
        }
        
        if($from = $this->param("from")) {
            $workflow->geq("date(begin)", $from);
        }
        
        if($to = $this->param("to")) {
            $workflow->leq("date(begin)", $to);
        }
	
	    app()->tm("/board/widget/timeline")
	        ->param("widget", $this)
	        ->param("workflow", $workflow)
	        ->param("from", $from)
	        ->param("to", $to)
			->exec();
	}

}
