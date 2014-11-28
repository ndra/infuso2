<?

namespace Infuso\Board\Controller;
use \Infuso\Core;
use \Infuso\Board\Model;

class Report extends Base {
    
    public function index_users($p) {
        app()->tm("/board/report/users")->exec();
    }
    
    public function index_projects($p) {
    
        $from = $p["from"];
        if(!$from) {
            $from = \util::now()->date()->shiftMonth(-1);
		}
        
        $to = $p["to"];
        if(!$to) {
        	$to = \util::now()->date();
        }
    
        app()->tm("/board/report/projects")
            ->param("from", $from)
            ->param("to", $to)
			->exec();
    }
    
    public function index_project($p) {
        $project = Model\Project::get($p["project"]);
        app()->tm("/board/report/project")
            ->param("from", $p["from"])
            ->param("to", $p["to"])
            ->param("project", $project)
			->exec();
    }
        
}
