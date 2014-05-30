<?

namespace Infuso\Cms\BundleManager\Controller;
use \Infuso\Core;

/**
 * Стандартная тема модуля reflex
 **/

class Theme extends Core\Controller {

	public function postTest() {
	    return true;
	}
    
    /**
     * @todo Сделать проверку безопасности: чтобы $class явлся классом темы
     **/        
    public static function getTheme($class) {
        return \Infuso\Template\Theme::get($class);
    }
	
	public function post_right($p) {
        $theme = self::getTheme($p["theme"]);
        return \tmp::get("/bundlemanager/theme-right")
            ->param("theme", $theme)
            ->getContentForAjax();
	}
    
	public function post_list($p) {
        return \tmp::get("/bundlemanager/theme-right/nodes")
            ->param("theme", self::getTheme($p["theme"]))
            ->param("path", $p["path"])
            ->getContentForAjax();
	}
    
    public function post_editor($p) {
        return \tmp::get("/bundlemanager/template-editor")
            ->param("template", self::getTheme($p["theme"])->template($p["template"]))
            ->getContentForAjax();
    }
    
        
    public function post_save($p) {
		$tmp = self::getTheme($p["theme"])->template($p["template"]);
		switch($p["type"]) {
		    default:
			case "php":
				$tmp->setCode($p["content"]);
				$tmp->compile();
				break;
			case "js":
				$tmp->setJS($p["content"]);
				\Infuso\Template\Render::clearRender();
				break;
			case "css":
				$tmp->setCSS($p["content"]);
				\Infuso\Template\Render::clearRender();
				break;
		}
		
		app()->msg("Шаблон сохранен");
    }   
    
}
