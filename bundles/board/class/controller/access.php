<?

namespace Infuso\Board\Controller;
use \Infuso\Board\Model;
use \Infuso\Core;

class Access extends Base {

	public function controller() {
	    return "board/access";
	}
    
    public function indexTest() {
        return app()->user()->checkAccess("board/manageAccess");
    }
    
    public function postTest() {
        return app()->user()->checkAccess("board/manageAccess");
    }

	/**
	 * Основной контроллер управления доступом
	 **/
    public function index($p) {
        app()->tm("board/access")->exec();
    }
    
    public function index_new() {
        app()->tm("board/access-new")
            ->param("access", new Model\Access())
            ->exec();
    }
    
    public function post_new($p) {
        service("ar")->create("infuso\\board\\model\\access", array(
            "projectId" => $p["projectId"],
            "userId" => $p["userId"],
        ));
    }
    
}
