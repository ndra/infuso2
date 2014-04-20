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
	            get_called_class() => array(
	                "params" => array(
	                    "remoteToken" => "Токен удаленной машины",
	                    "remoteHost" => "Хост удаленной машины",
	                    "skip" => "[yaml] Пропустить модули",
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
        \tmp::exec("/reflex/admin/sync", array(
            "classes" => $this->getClassList(),
        ));
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
            throw new Exception("Token not set");
        }

        if($token != $p["token"]) {
            throw new Exception("Bad token");
        }

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

                $itemData = $item->data();
                foreach($itemData as $key=>$val) {
                    $itemData[$key] = base64_encode($val);
                }

                $data["rows"][] = $itemData;

                $data["nextId"] = $item->id();
                //$this->app()->service("ar")->freeAll();
                $n++;
            }

            // Если записано 0 строк, мы закончили с этим классом
            if($n == 0) {
                $data["completed"] = true;
            }

        } else {

            $data["completed"] = true;

        }

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
            $limit = 500;
        }

        $url = Core\Mod::url("http://$host/infuso/cms/reflex/controller/sync/get");
        $url->query("class", $class);
        $url->query("id", $p["fromID"]);
        $url->query("token", $token);
        $url->query("limit", $limit);

        $data = Core\File::http($url)->data();

        if(!$data) {
            mod::msg("No data received",1);
            return false;
        }

        core\File::get("1.txt")->put($url);
        $data = @gzuncompress($data);

        if(!$data) {
            throw new \Exception("Data received but unzip failed. Possible wrong format.");
        }

        $data = json_decode($data,1);
        if($data === null) {
            Core\Mod::msg("Json decode failed",1);
            return;
        }

        Core\Mod::msg($data);

        if($data["completed"]) {
            return array(
                "action" => "nextClass",
            );
        }

        $v = new $class;
        $table = $v->prefixedTableName();

        if($p["fromID"]==0) {
            $q = "truncate table `$table` ";
            Core\Mod::service("db")->query($q);
            Core\Mod::msg("truncate $class");
        }

        foreach($data["rows"] as $row) {

            foreach($row as $key=>$val) {
                unset($row[$key]);

                // Не забываем разкодировать данные из base64
                $val = base64_decode($val);

                $row["`".$key."`"] = '"'.mysql_real_escape_string($val).'"';
            }

            // Вставляем в таблицу
            $itemData = array();
            $insert = " (".implode(",",array_keys($row)).") values (".implode(",",$row).") ";
            $query = "insert into `$table` $insert ";
            Core\Mod::service("db")->query($query);
        }

        return array(
            "action" => "nextId",
            "nextId" => $data["nextId"],
            "log" => array(
                "class" => $class,
                "message" => $class.": {$data[nextId]} total {$data[total]}"
            ),
        );

    }

}
