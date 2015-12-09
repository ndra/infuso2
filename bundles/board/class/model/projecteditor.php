<?

namespace Infuso\Board\Model;
use Infuso\Core;

class ProjectEditor extends \Infuso\Cms\Reflex\Editor {

	public function itemClass() {
	    return Project::inspector()->className();
	}

	public function beforeEdit() {
	    return Core\Superadmin::check();
	}
	
	 /**
	 * @reflex-root = on
	 **/
	public function all() {
	    return Project::all()->title("Проекты");
	}

}
