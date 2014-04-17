<?

use infuso\core\superadmin;

class moduleManager extends mod_controller{

	public static function indexTest() {
        return superadmin::check();
    }
	
	public static function index() {

	    admin::header("Управление модулями");

	    $tree = array();

        // Модуль
        $module = array(
            "text" => "/",
            "id" => "/",
            "children" => array(),
        );

        // Файлы
        $module["children"][] = array(
            "text" => "Файлы",
            "icon" => self::inspector()->bundle()->path()."/icons/files.png",
            "editor" => array(
	            "basedir" => "/",
	            "type" => "inx.mod.moduleManager.fileManager",
            ),
        );

        $tree[] = $module;

	    foreach(mod::service("bundle")->all() as $bundle) {
	    
	        $m = trim($bundle->path(),"/");

	        // Модуль
	        $module = array(
	            "text" => "<span style='font-weight:bold;'>$m<span>",
	            "id" => $m,
	            "children" => array(),
	        );

	        // Файлы
	        $module["children"][] = array(
	            "text" => "Файлы",
	            "icon" => self::inspector()->bundle()->path()."/icons/files.png",
                "editor" => array(
    	            "basedir" => $m,
    	            "type" => "inx.mod.moduleManager.fileManager",
                ),
	        );

	        // Шаблоны
	        foreach(mod::service("classmap")->classes("Infuso\Template\Theme") as $class) {
	            $theme = new $class;
	            if(trim($theme->bundle()->path(),"/") == $m) {
		            $module["children"][] = array(
		                "text" => $theme->name(),
		                "editor" => array(
							"themeID" => $class,
                            "type" => "inx.mod.moduleManager.templateManager",
						),
		                "icon" => "template"
		            );
                }
            }

	        // Inx
	        if($bundle->conf("inx","path")) {
	            $module["children"][] = array(
	                "text"=>"inx",
	                "icon" => self::inspector()->bundle()->path()."/res/inx.gif",
                    "editor" => array(
                        "module" => $m,
                        "type" => "inx.mod.moduleManager.inx.manager",
                    ),
	            );
            }

	        if(sizeof($module[children])) {
	            $tree[] = $module;
            }

	    }

	    $sort = function($a,$b) {

	        if($a["text"]=="/") {
	            return -1;
	        }

	        if($b["text"]=="/") {
	            return 1;
	        }

		    if($a["system"]!=$b["system"]) {
		        return $a<$b;
	        }
		    return strcmp(strtolower($a["text"]),strtolower($b["text"]));
		};

	    usort($tree,$sort);

	    inx::add(array(
	        "type" => "inx.mod.moduleManager.manager",
	        tree=>$tree
	    ));
	    
	    tmp::exec("admin:footer");
	}

	public static function indexFailed() {
        admin::fuckoff();
    }

	public static function postTest() {
        return mod_superadmin::check();
    }
	
	public static function post_build() {
        mod::app()->deploy();
	}

}
