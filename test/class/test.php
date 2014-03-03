<?

namespace infuso\test;

class tester extends \infuso\core\controller implements \Infuso\Core\Handler {

	/**
	 * @handler=reflexMenu
	 **/
	public function onReflexMenu($e) {
	    $e->add(array(
	        "template" => "/reflex/menu-item-test/",
		));
	    $e->add(array(
	        "template" => "/reflex/menu-item-test2/",
		));
	    $e->add(array(
	        "template" => "/reflex/menu-item-test/",
		));
	}
	 
    public function indexTest() {
        return true;
    }
    
    public function index($p) {

		\tmp::header();
		
		echo \user::active()->checkAccess("admin:showInterface");
		
		\tmp::footer();
        
    }

}
