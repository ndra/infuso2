<?

namespace Infuso\Board\Controller;
use \Infuso\Core;

class User extends Base {
    
    public function index($p) {

        $user = \User::get($p["id"]);

        $this->app()->tmp()->exec("/board/user", array(
            "user" => $user,
        ));
    }
        
}
