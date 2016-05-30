<?

namespace Infuso\Cms\Reflex\Controller;
use \Infuso\Core;
use Infuso\Cms\Reflex;

/**
 * Основной контроллер каталога
 **/
class Route extends \Infuso\Core\Controller {

    /**
     * Разрешение для POST-команд
     **/
    public static function postTest() {
        return \user::active()->checkAccess("admin:showInterface");
    }

    /**
     * Контроллер создания мета-объекта
     * @todo проверка безопасности     
     **/
    public function post_create($p) {
        $editor = Reflex\Editor::get($p["editor"]);
        
        if(!$editor->beforeEdit()) {
            throw new \Exception("Security error");
        }
        
        $item = $editor->item();
        $hash = get_class($item).":".$item->id();
        $this->service("ar")->create(Reflex\Model\Route::inspector()->className(),array(
            "hash" => $hash,
		));
    }
    
    /**
     * @todo проверка безопасности
     **/         
    public function post_save($p) {
        $editor = Reflex\Editor::get($p["editor"]);
        
        if(!$editor->beforeEdit()) {
            throw new \Exception("Security error");
        }
        
        $route = \Infuso\Cms\Reflex\Model\Route::get($editor->item());
        $route->data("url", $p["url"]);
        service("route")->clearCache();
    }
    
    /**
     * Удаляет роут
     **/         
    public function post_delete($p) {
        $editor = Reflex\Editor::get($p["editor"]);
        
        if(!$editor->beforeEdit()) {
            throw new \Exception("Security error");
        }
        
        $route = \Infuso\Cms\Reflex\Model\Route::get($editor->item());
        $route->delete();
        service("route")->clearCache();         
    }
    
    public function post_getContent($p) {
    
        $editor = Reflex\Editor::get($p["editor"]); 
                
        if(!$editor->beforeEdit()) {
            throw new \Exception("Security error");
        }
        
        return app()->tm("/reflex/meta/url/ajax")
            ->param("editor", $editor)
            ->getContentForAjax();
        
    }


}
