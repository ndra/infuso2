<?

namespace Infuso\Cms\Admin;

/**
 * Обработчик событий модуля admin
 **/
class Handler implements \Infuso\Core\Handler {

	/** 
	 * @handler = infusoInit
	 **/	 	
    public function onInit() {
    
        $op = \user_operation::create("admin:showInterface");
        $op->appendTo("reflex:contentManager");
    
    }

}
