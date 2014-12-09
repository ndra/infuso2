<?

namespace Infuso\Cms\Reflex\Controller;
use \Infuso\Core;

/**
 * Контролле рсихронизации
 **/
class Sync extends \Infuso\Core\Controller {

	public function confDescription() {
	    return array(
	        "components" => array(
	            strtolower(get_class()) => array(
	                "params" => array(
	                    "remoteToken" => "Токен удаленной машины",
	                    "remoteHost" => "Хост удаленной машины",
	                    "skip" => "[yaml] Пропустить модули",
	                    "remoteLimit" => "Сколько строк скачивать за раз",
	                    "syncFiles" => "Синхронизировать файлы",
					),
				),
			),
		);
	}

    public static function indexTest() {
        return true;
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

        foreach(Core\Mod::service("classmap")->classes("Infuso\\ActiveRecord\\Record") as $class) {
            if(!in_array($class,$skip)) {
                $ret[] = $class;
            }
        }

        return $ret;
    }

    /**
     * Контроллер, отдающий данные
     **/
    public function index_get($p) {

        $token = trim($this->param("token"));
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

        if(Core\Mod::service("classmap")->testClass($class)) {

            $items = \reflex::get($class)
                ->asc("id")
                ->gt("id",$p["id"])
                ->limit($limit);

            $data["total"] = $items->count();

            $n = 0;
            foreach($items as $item) {

                // Собираем данные
                $itemData = $item->data();
                foreach($itemData as $key => $val) {
                    $itemData[$key] = base64_encode($val);
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
                $n++;
            }

            // Если записано 0 строк, мы закончили с этим классом
            if($n == 0) {
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

    /**
     * Контроллер, запрашивающий данные
     **/
    public function post_syncStep($p) {

        $class = $p["className"];

        if(!$token = $this->param("remoteToken")) {
            throw new \Exception("Token missing");
        }

        if(!$host = $this->param("remoteHost")) {
            throw new \Exception("Host missing");
        }

        $limit = $this->param("remoteLimit");

        if(!$limit) {
            $limit = 50;
        }

        $url = Core\Mod::url("http://$host/infuso/cms/reflex/controller/sync/get");
        $url->query("class", $class);
        $url->query("id", $p["fromId"]);
        $url->query("token", $token);
        $url->query("limit", $limit);

        $data = Core\File::http($url)->data();

        if(!$data) {
            app()->msg("No data received",1);
            return false;
        }

        $data = @gzuncompress($data);

        if(!$data) {
            throw new \Exception("Data received but unzip failed. Possible wrong format.");
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
                $val = base64_decode($val);

                $insert["`".$key."`"] = service("db")->quote($val);
            }

            // Вставляем в таблицу
            $itemData = array();
            $insert = " (".implode(",",array_keys($insert)).") values (".implode(",",$insert).") ";
            $query = "insert into `$table` $insert ";
            app()->trace($query);
            $id = service("db")->query($query)->exec()->lastInsertId();

			if($this->param("syncFiles")) {
	            $item = service("ar")->get($class, $id);
	            if($row["files"]) {
		            foreach($row["files"] as $file) {
		                $dest = $item->storage()->path()."/".$file["rel"];
		                $content = Core\File::http("http://$host/".$file["url"])->data();
		                Core\File::mkdir(Core\File::get($dest)->up());
						Core\File::get($dest)->put($content);
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
