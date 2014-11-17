<?

namespace Infuso\Board\Controller;
use \Infuso\Core;

class Report extends Base {
    
    public function index_users($p) {
        app()->tm("/board/report/users")->exec();
    }
    
    public function index_projects($p) {
        app()->tm("/board/report/projects")->exec();
    }
        
}
