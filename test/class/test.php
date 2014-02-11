<?

namespace infuso\test;

class tester extends \infuso\core\controller {

    public function indexTest() {
        return true;
    }
    
    public function index($p) {

		\tmp::header();
	
	    echo "hallo";

		\util::profiler();

		\tmp::footer();
        
    }

}
