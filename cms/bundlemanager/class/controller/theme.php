<?

namespace Infuso\Cms\BundleManager\Controller;
use \Infuso\Core;

/**
 * Контроллер редактирования шаблонов
 **/
class Theme extends Core\Controller {

	public function postTest() {
	    return true;
	}
    
    /**
     * @todo Сделать проверку безопасности: чтобы $class явлся классом темы
     **/        
    public static function getTheme($class) {
        return new $class;
    }
	
	/**
     * Возвращает html списка шаблонов (для правой панели редактора бандлов)
     **/
	public function post_right($p) {
        $theme = self::getTheme($p["theme"]);
        return \tmp::get("/bundlemanager/theme-right")
            ->param("theme", $theme)
            ->getContentForAjax();
	}

	/**
     * Возвращает html списка шаблонов (для дерева)
     **/
	public function post_list($p) {
        $template = self::getTheme($p["theme"])->template($p["path"]);
        return \tmp::get("/bundlemanager/theme-right/nodes")
            ->param("template", $template)
            ->getContentForAjax();
	}

	/**
     * Возвращает html редактора элемента
     **/
    public function post_editor($p) {
        return \tmp::get("/bundlemanager/template-editor")
            ->param("template", self::getTheme($p["theme"])->template($p["template"]))
            ->getContentForAjax();
    }        

	/**
     * Сохраняет шаблон
     **/
    public function post_save($p) {
    
        $theme = self::getTheme($p["theme"]);
		$tmp = $theme->template($p["template"]);
        
		switch($p["type"]) {
		    default:
			case "php":
				$tmp->setContents("php", $p["content"]);
				//$tmp->compile();
				break;
			case "js":
				$tmp->setContents("js", $p["content"]);
				\Infuso\Template\Render::clearRender();
				break;
			case "css":
				$tmp->setContents("css", $p["content"]);
				\Infuso\Template\Render::clearRender();
				break;
		}  		
        $theme->compile();
		app()->msg("Шаблон сохранен");
    }   
    
    /**
     * Добавляет шаблон
     **/
    public function post_addTemplate($p) {
        $theme = self::getTheme($p["theme"]);
	    $tmp = $theme->template($p["parent"]);
		$tmp->add($p["name"]);
        $theme->compile();
		return array(
		    "refresh" => $tmp->relName(),
		);
    }
    
    public function post_removeTemplates($p) {
    
		$superFolder = function($strings) {

		    $strings = array_values($strings);

		    if(sizeof($strings) == 0) {
		        return "";
		    }

			if(sizeof($strings) == 1) {
		        return $strings[0];
		    }

		    foreach($strings as $key => $val) {
		        $strings[$key] = explode("/", $val);
		    }

		    for($n = 0; $n <= 100; $n++) {
				foreach($strings as $string) {
				    if($string[$n] != $strings[0][$n]) {
				        break 2;
				    }
				}
		    }

			$super = array_slice($strings[0],0,$n);
		    return implode("/",$super);

		};
    
	    $theme = self::getTheme($p["theme"]);
	    
	    $parents = array_map(function($a) use ($theme) {
	        return $theme->template($a)->parent()->relName();
		}, $p["templates"]);

	    $parent = $superFolder($parents);
        
        foreach($p["templates"] as $relName) {
            $theme->template($relName)->delete();
        }
        
        $theme->compile();

	    return array(
            "refresh" => $parent,
        );
    }
    
}
