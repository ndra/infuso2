<?

namespace Infuso\Board\Controller;
use \Infuso\Board\Model;
use \Infuso\Core;

class Access extends Base {

	public function controller() {
	    return "board/access";
	}

	/**
	 * Основной контроллер управления доступом
	 **/
    public function index($p) {
        app()->tm("board/access")->exec();
    }
}
