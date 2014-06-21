<?

namespace Infuso\Template;
use Infuso\Core;

class Handler implements Core\Handler {

	/**
	 * @handler = infusoDeploy
	 **/
	public function onDeploy() {
	    app()->msg("clear css and js render");
        Render::clearRender();
	}
    
    
    /**
     * Обработчик события Хартбит - теста системы
     * @handler = Infuso/Admin/Heartbeat
     **/
    public function onHeartbeat($event) {    
        
        $render = new \Infuso\Template\Render;
        $cache = $render->param("cache");
        
        if($cache) {
            $event->message("Кэш рендера css и js активен");
        } else {
            $event->warning("Кэш рендера css и js выключен");
        }
        
    }

}
