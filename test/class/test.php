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
		
		echo 1;
	
        \util::profiler();

		\tmp::footer();
        
    }

}
