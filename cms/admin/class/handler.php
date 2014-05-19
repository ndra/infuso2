<?

namespace Infuso\Cms\Admin;

/**
 * Обработчик событий модуля admin
 **/
class Handler implements \Infuso\Core\Handler {

	/** 
	 * @handler = infusoDeploy
	 **/	 	
    public function onDeploy() {
    
        $op = \user_operation::create("admin:showInterface");
        $op->appendTo("reflex:content-manager");
    
    }

}
