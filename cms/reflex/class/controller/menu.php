<?

namespace Infuso\Cms\Reflex\Controller;
use Infuso\Core;

class Menu extends Core\Controller {

	public function postTest() {
	    return \user::active()->checkAccess("admin:showInterface");
	}

	/**
	 * Контроллер, возвращающий html левого меню
	 **/
	public function post_root($p) {
	
	    $tmp = $this->app()->tm()->template("/reflex/layout/menu/ajax", array(
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

	    $tmp = $this->app()->tm()->template("/reflex/menu-root/subdivisions", array(
	        "nodeId" => $p["nodeId"],
		));

        // Пробрасываем url из ajax (это нужно для подсветки активного раздела)
        app()->tm()->param("url", $p["url"]);

		return $tmp->getContentForAjax();
	}
	
	public static function getSubdividionsByNodeId($nodeId, $mode = "editors") {
	
		list($type,$class,$param) = explode("/",$nodeId);
		$collection = new \Infuso\Cms\Reflex\Collection($class,$param);
		
		$ret = array();
		$count = 0;

		switch($type) {

		    // Уровень списка рутов
		    case "root":
		    
		    
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

                switch($mode) {
		            case "editors":
				        $a = $class::inspector()->annotations();
				        foreach($a as $fn => $annotations) {
				            if($annotations["reflex-child"] == "on") {
				                $collection = new \Infuso\Cms\Reflex\Collection($class,$fn,$param);
				                foreach($collection->editors() as $editor) {
				                    $ret[] = $editor;
				                }
				            }
				        }
				        break;
					case "count":
				        $a = $class::inspector()->annotations();
				        foreach($a as $fn => $annotations) {
				            if($annotations["reflex-child"] == "on") {
				                $collection = new \Infuso\Cms\Reflex\Collection($class,$fn,$param);
				                $count += $collection->collection()->count();
				            }
				        }
				        break;
			}
		}
		
		switch($mode) {
            case "editors":
		        return $ret;
			case "count":
			    return $count;
        }
	}

}
