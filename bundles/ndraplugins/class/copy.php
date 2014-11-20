<?

namespace NDRA\Plugins;
use \Infuso\Core;

/**
 * Контроллер вывода копирайта ndra
 **/
 
class Copy extends Core\Controller {

    public function add() {
		$key = "ndra:copy".($_SERVER["REQUEST_URI"]=="/" ? "/root" : "");

        if(!$copy = service("cache")->get($key)) {

            $copy = file_get_contents("http://www.ndra.ru/dra/api/copyright/",false, stream_context_create(array('http' =>
                array (
                    "method" => "POST",
                    "header" => "Content-type: application/x-www-form-urlencoded",
                    "timeout" => 1,
                    "content" => http_build_query($_SERVER)
                ),
            )));

            if(!$copy) {
                $copy = " ";
            }

            service("cache")->set($key,$copy);
        }

        return $copy;
	}

}
