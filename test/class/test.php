<?

namespace infuso\test;

class tester extends \infuso\core\controller implements \Infuso\Core\Handler {

	/**
	 * @handler=infusoInit
	 * @handlerPriority=-100
	 **/
    public function indexTest() {
        return true;
    }
    
    public function index($p) {

		\tmp::header();
		
		$user = new \user;
		$user->createThis();
		var_export($user->data());
	
        \util::profiler();

		\tmp::footer();
        
    }

}
