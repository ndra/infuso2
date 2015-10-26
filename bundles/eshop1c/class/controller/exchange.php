<?

namespace Infuso\Eshop1C\Controller;
use \Infuso\Core;
use \Infuso\Eshop1C;

/**
 * Контроллер импорта товаров
 * 1С Подаключается к этому классу для обмена товарами и заказами
 **/
class Exchange extends Core\Controller {

    /**
     * Количество позиций, испортируемых за один шаг
     **/
    private static $step = 20;

	/**
	 * Разрешаем работу контроллеру
	 **/
    public static function indexTest() {
        return true;
    }
    
    public function controller() {
        return "1c";
    }
    
	/**
	 * Каталог, к оторый будут записываться файлы импорта
	 **/
    public static function exchangeDir() {
        return app()->varPath()."/1c-import/";
    }

    /**
     * Единый контроллер обмена с 1С
     **/
    public function index() {
    
        $cmd = "$_GET[type]:$_GET[mode]";

        $dir = self::exchangeDir();
        $user = $_SERVER["PHP_AUTH_USER"];
        $password = $_SERVER["PHP_AUTH_PW"];
        $_user = $this->param("login");
        $_password = $this->param("password");

        if(!$_user || !$_password) {
            service("log")->log(array(
				"message" => "Не задан логин и пароль для соедиения с 1С",
				"type" => "1c/exchange"
			));
            return;
        }

        if($user!=$_user || $password != $_password) {
            service("log")->log(array(
				"message" => "Логин и пароль, переданные 1С ($user:$password) не совпадают с указанными в настройках сайта ($_user:$_password).",
				"type" => "1c/exchange"
			));
            return;
        }

        service("log")->log(array(
			"message" => $cmd." ".var_export($_GET,1)." ".Eshop1C\Utils::importCycle(),
			"type" => "1c/exchange"
		));
		
        switch($cmd) {

            case "sale:checkauth":
            case "catalog:checkauth":
                echo "success\n";
                break;

            // Начало выгрузки на сайт
            case "catalog:init":
                Core\File::mkdir($dir);
                Eshop1C\Utils::importBegin();
                self::from(0);
                echo "zip=no\n";
                echo "file_limit=0\n";
                break;

            // Прием файла
            case "catalog:file":
                $str = file_get_contents("php://input");
                $file = Core\File::get("$dir/$_GET[filename]");
                Core\File::mkdir($file->up());
                $file->put($str);

                // Сохраняем имя последнего переданного файла
                // Это понадобится нам позже чтобы определить когда закончить выгрузку
                Core\File::get("{$dir}/last-import-file.txt")->put($_GET["filename"]);

                echo "success";
                break;

            // Разбор файла
            case "catalog:import":       
                      
                $filename = $_GET["filename"];   
                if(preg_match("/import/",$filename)) {    
                    if(self::importCatalog($filename)) {
                        echo "success";
                        return;
                    } else {
                        echo "progress\n";
                        echo self::from();
                        return;
                    }
                }

                if(preg_match("/offers/",$filename)) {
                    if(self::importOffers($filename)) { 
                        if($filename == Core\File::get("{$dir}/last-import-file.txt")->data()) {
                            Eshop1C\Utils::importComplete();
                            service("log")->log(array(
                    			"message" => "Import completed",
                    			"type" => "1c/exchange"
                    		));
                        }
                        echo "success";
                        return;
                    } else {
                        echo "progress\n";
                        echo self::from();
                        return;
                    }
                }

                break;

            // Начало обмена заказами
            case "sale:init":
                echo "zip=no\n";
                echo "file_limit=0\n";
                break;

            // 1с запрашивает заказы у сайта
            case "sale:query":
                header("Content-type: application/xml");
                $xml = self::saleXML();
                $xml = mb_convert_encoding($xml->asXML(),"cp-1251","utf-8");
                echo $xml;
                break;

            // 1с отправляет заказы на сайт. Пока ничего не делаем с этим
            case "sale:file":
                echo "success";
                break;

            default:
                break;
        }
    }

    /**
     * @return Возвращает xml с заказами с сайта
     * Этот xml будет отправлен в 1C
     **/
    public function saleXML() {
    
        $xml = simplexml_load_string("<КоммерческаяИнформация ВерсияСхемы='2.03' ДатаФормирования='".util::now()->notime()."' />");
        $parent = $xml;

        // Выгружаем заказы за последние 90 дней
        $days = 90;
        /*$orders = eshop_order::all()->neq("status",0)->eq("1CExportCompleted",0)->limit(20);

        foreach($orders as $order) {
            $document = $parent->addChild("Документ");
            $order->export1CXML($document);
            $order->data("1CExportCompleted",true);
        } */

        return $xml;
    }

    public static function from($from = 0) {

        if(func_num_args()==0) {
            return Core\File::get(self::exchangeDir()."/step.txt")->data();
        }

        if(func_num_args()==1){
            return Core\File::get(self::exchangeDir()."/step.txt")->put($from);
        }
    }

    /** 
     * Выполняет один шаг обработки файла inport.xml
     **/         
    public static function importCatalog($filename = "import.xml") {
    
        service("log")->log(array(
			"message" => "importCatalog $filename",
			"type" => "1c/exchange"
		));
    
        $vitem = service("ar")->virtual("infuso\\eshop\\model\\item");

        $xml = simplexml_load_file(Core\File::get(self::exchangeDir()."/".$filename)->native());
        $items = $xml->xpath("//Каталог/Товары/Товар");
        $count = sizeof($items);
        $from = self::from();
        $to = $from + self::$step;
        $items = $xml->xpath("//Каталог/Товары/Товар[position()>=$from and position()<=$to]");

        foreach($items as $towar) {
            $vitem->processCatalogXML($towar,$xml);
        }

        self::from($to);
        if($to >= $count) {
            self::from(0);
            return true;
        }
        
        return false;
        
    }

    /** 
     * Выполняет один шаг обработки файла offers.xml
     **/         
    public static function importOffers($filename = "offers.xml") {
    
        service("log")->log(array(
			"message" => "importOffers $filename",
			"type" => "1c/exchange"
		));

        $vitem = service("ar")->virtual("infuso\\eshop\\model\\item");

        $xml = simplexml_load_file(Core\File::get(self::exchangeDir()."/".$filename)->native());
        $items = $xml->xpath("//Предложение");
        $count = sizeof($items);
        $from = self::from();
        $to = $from + self::$step;
        $items = $xml->xpath("//Предложение[position()>=$from and position()<=$to]");
        foreach($items as $offer) {
            $vitem->processOffersXML($offer,$xml);
        }
        self::from($to);
        if($to >= $count) {
            self::from(0);
            return true;
        }
    }

}
