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
		
		$user = \user::get(4);
		
		$user->data("email","xxx");
		$user->Store();
		echo $user->recordStatus();
	
        \util::profiler();

		\tmp::footer();
        
    }

}
