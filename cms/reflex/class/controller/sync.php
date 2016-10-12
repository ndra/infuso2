<?

namespace Infuso\Cms\Reflex\Controller;
use \Infuso\Core;

/**
 * Контролле рсихронизации
 **/
class Sync extends \Infuso\Core\Controller {

	public static function confDescription() {
	    return array(
	        "components" => array(
	            strtolower(get_class()) => array(
	                "params" => array(
	                    "remoteToken" => "Токен удаленной машины",
	                    "remoteHost" => "Хост удаленной машины",
                        "removeScheme" => "Схема удаленной машины (http или https)",
	                    "skip" => "[yaml] Пропустить модули",
	                    "remoteLimit" => "Сколько строк скачивать за раз",
	                    "syncFiles" => "Синхронизировать файлы",
					),
				),
			),
		);
	}
    
    public function initialParams() {
        return array(
            "remoteScheme" => "http",
            "replaceExistingFiles" => false,
        );
    }

    public static function indexTest() {
        return Core\Superadmin::check();
    }

    public static function postTest() {
        return Core\Superadmin::check();
    }

    public function index() {
		app()->tm("/reflex/admin/sync")->param("classes",$this->getClassList())->exec();
    }

    /**
     * Возвращает список классов
     **/
    public function getClassList() {

        $skip = $this->param("skip");
        if(!is_array($skip)) {
            $skip = array();
        }

        $skip[] = "reflex_none";

        $ret = array();

        foreach(service("classmap")->classes("Infuso\\ActiveRecord\\Record") as $class) {
            if(!in_array($class,$skip)) {
                $ret[] = $class;
            }
        }

        return $ret;
    }      
        
    /**
     * Контроллер, запрашивающий данные
     **/
    public function post_syncStep($p) {

        $class = $p["className"];
        
        if(!$scheme = $this->param("remoteScheme")) {
            throw new \Exception("Scheme missing");
        }

        if(!$token = $this->param("remoteToken")) {
            throw new \Exception("Token missing");
        }

        if(!$host = $this->param("remoteHost")) {
            throw new \Exception("Host missing");
        }

        $limit = $this->param("remoteLimit");

        if(!$limit) {
            $limit = 100;
        }

        $url = Core\Mod::url("{$scheme}://$host/infuso/cms/reflex/controller/syncserver");
        $url->query("class", $class);
        $url->query("id", $p["fromId"]);
        $url->query("token", $token);
        $url->query("limit", $limit);

        $http = Core\File::http($url);
        $compressedData = $http->data();        
        $info = $http->info();

        if(!$compressedData) {
            app()->msg("No data received",1);
            return false;
        }      

        $data = gzuncompress($compressedData);

        if(!$data) {
            app()->trace(array(
                "message" => var_export($info, 1)."\n\n--------\n\n".$compressedData,
                "type" => "reflex/sync-error",
            ));
            throw new \Exception("Data received but unzip failed. Possible wrong format. See log for details.");
        }

        $data = json_decode($data,1);
        if($data === null) {
            throw new \Exception("Json decode failed");
        }

        if($data["completed"]) {
            return array(
                "action" => "nextClass",
				"log" => array(
	                "class" => md5($class),
	                "message" => "done"
            	),
            );
        }

        $v = new $class;
        $table = $v->prefixedTableName();

		// Если индекс нулевой - очищаем таблицу
        if($p["fromId"] == 0) {
            $q = "truncate table `$table` ";
            service("db")->query($q)->exec();
        }

        foreach($data["rows"] as $row) {

            $insert = array();
            foreach($row["data"] as $key => $val) {

                // Не забываем разкодировать данные из base64
                $val = $val !== null ? base64_decode($val) : null;

                $insert["`".$key."`"] = $val !== null ? service("db")->quote($val) : "null";
            }

            // Вставляем в таблицу
            $itemData = array();
            $insert = " (".implode(",",array_keys($insert)).") values (".implode(",",$insert).") ";
            $query = "insert into `$table` $insert ";
            $id = service("db")->query($query)->exec()->lastInsertId();

			if($this->param("syncFiles")) {
	            $item = service("ar")->get($class, $id);
	            if($row["files"]) {
		            foreach($row["files"] as $file) {
		                $dest = Core\File::get($item->storage()->path()."/".$file["rel"]); 
                        if($this->param("replaceExistingFiles") || !$dest->exists()) {
    		                $content = Core\File::http("http://$host/".$file["url"])->data();
    		                Core\File::mkdir(Core\File::get($dest)->up());
    						Core\File::get($dest)->put($content);
                        }
		            }
	            }
            }     
        }

        return array(
            "action" => "nextId",
            "nextId" => $data["nextId"],
            "log" => array(
                "class" => md5($class),
                "message" => $class.": {$data[nextId]} total {$data[total]}"
            ),
        );

    }

}
