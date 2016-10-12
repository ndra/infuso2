<?

namespace Infuso\Cms\Reflex\Controller;
use \Infuso\Core;

/**
 * Контролле рсихронизации
 **/
class SyncServer extends \Infuso\Core\Controller {      

    public static function indexTest() {
        return true;
    }

    /**
     * Контроллер, отдающий данные
     **/
    public function index($p) {

        $sync = new Sync();
        $token = trim($sync->param("token"));
        
        if(!$token) {
            throw new \Exception("Token not set");
        }

        if($token != $p["token"]) {
            throw new \Exception("Bad token");
        }

        // Сюда будем складывать данные
        $data = array(
            "rows" => array(),
        );

        $class = $p["class"];

        $limit = $p["limit"] * 1;
        if(!$limit) {
            $limit = 100;
        }
        
        $startTime = time();

        if(service("classmap")->testClass($class)) {

            $items = service("ar")
                ->collection($class)
                ->asc("id")
                ->limit($limit);

            $data["total"] = $items->count();
            
            $items->gt("id",$p["id"]);

            $done = true;
            foreach($items as $item) {
            
                $done = false;

                // Собираем данные
                $itemData = $item->data();
                foreach($itemData as $key => $val) {
                    $itemData[$key] = $val !== null ? base64_encode($val) : null;
                }

                $files = array();
                foreach($item->storage()->allFiles() as $file) {
                    $files[] = array(
                        "rel" => $file->rel($item->storage()->root()),
                        "url" => $file->url(),
                    );
                }

                $data["rows"][] = array(
                    "data" => $itemData,
                    "files" => $files,
                );
                $data["nextId"] = $item->id();
                
                if(time() - $startTime > 2) {
                    break;
                }
                
            }

            // Если записано 0 строк, мы закончили с этим классом
            if($done) {
                $data["completed"] = true;
            }

        } else {

            $data["completed"] = true;

        }

        // Отправляем данные
        header("content-type:application/json");
        $data = json_encode($data);
        $data = gzcompress($data);
        echo $data;   
    }          

}
