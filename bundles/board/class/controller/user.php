<?

namespace Infuso\Board\Controller;
use \Infuso\Core;

class User extends Base {
    
    public function index($p) { 
        $user = \User::get($p["id"]); 
        app()->tm()->exec("/board/user", array(
            "user" => $user,
        ));
    }
    
    public function post_listUsers($p) {
    
        $ret = array(
            "items" => array(),
        );
        $projects = service("user")->all()->like("email", $p["query"]);
        foreach($projects as $project) {
            $ret["items"][] = array(
                "id" => $project->id(),
                "title" => $project->title(), 
            );
        }
        return $ret;
    
    }
        
}
