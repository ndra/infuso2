<?

namespace infuso\test;

class tester extends \infuso\core\controller implements \Infuso\Core\Handler {

    public function indexTest() {
        return true;
    }
    
    public function index($p) {
		\tmp::add("center","/reflex/test");
		\tmp::exec("/reflex/layout");
    }

}
