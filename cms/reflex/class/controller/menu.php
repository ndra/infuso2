<?

namespace Infuso\Cms\Reflex\Controller;
use Infuso\Core;

class Menu extends Core\Controller {

	public function postTest() {
	    return app()->user()->checkAccess("admin:showInterface");
	}

	/**
	 * Контроллер, возвращающий html левого меню
	 **/
	public function post_root($p) {
	
	    $tmp = app()->tm()->template("/reflex/layout/menu/ajax", array(
            "stored" => $p["stored"],
            "tab" => $p["tab"],
		));

        // Пробрасываем url из ajax (это нужно для подсветки активного раздела)
        app()->tm()->param("url", $p["url"]);

		return $tmp->getContentForAjax();
	}

	/**
	 * Контроллер, возвращающий html подразделов дерева в левом меню
	 **/
	public function post_subdivisions($p) {

	    $tmp = app()->tm()->template("/reflex/menu-root/subdivisions", array(
	        "nodeId" => $p["nodeId"],
		));

        // Пробрасываем url из ajax (это нужно для подсветки активного раздела)
        app()->tm()->param("url", $p["url"]);

		return $tmp->getContentForAjax();
	}
	
	public static function getSubdividionsByNodeId($nodeId, $mode = "editors") {
	
		list($type) = explode("/", $nodeId);
        
		$ret = array();
		$count = 0;

		switch($type) {

		    // Уровень списка рутов
		    case "root":            
                list($type, $class, $method) = explode("/", $nodeId);
                $collection = new \Infuso\Cms\Reflex\Collection($class, $method);    
		        switch($mode) {
		            case "editors":
				        foreach($collection->editors() as $editor) {
				            $ret[] = $editor;
				        }
				        break;
					case "count":
					    $count += $collection->collection()->count();
					    break;
		        } 		        
		        break;

		    // Уровень вложенных редакторов
		    case "child":

                list($type, $class, $id) = explode("/", $nodeId);
                $editor = \Infuso\CMS\Reflex\Editor::get($class.":".$id);
                switch($mode) {
		            case "editors":
                        foreach($editor->childrenCollections() as $collection) {
                            if($collection->collection()->param("menu") != false) {
    			                foreach($collection->editors() as $editor) {
    			                    $ret[] = $editor;
                                }
                            }
                        }              
				        break;
					case "count":
                        foreach($editor->childrenCollections() as $collection) {
                            if($collection->collection()->param("menu") != false) {
                                $count += $collection->collection()->count();
                            }
                        }
				        break;
                }
                break;
        }
		
		switch($mode) {
            case "editors":
		        return $ret;
			case "count":
			    return $count;
        }
	}

}
