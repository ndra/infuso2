<?

namespace infuso\test;

class tester extends \infuso\core\controller implements \Infuso\Core\Handler {

	/**
	 * @handler=infusoInit(-100)
	 **/
    public function indexTest() {
        return true;
    }
    
    public function index($p) {

		\tmp::header();
		
		$a = self::inspector()->annotations();
		var_export($a);
	
        \util::profiler();

		\tmp::footer();
        
    }

}
