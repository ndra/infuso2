<?

namespace Infuso\Dao;  
use Infuso\Core;

class Connection extends Core\Service {

	/**
	 * Объект класса PDO, создающийся при соедниении
	 **/
	private $dbh;
	
	/**
	 * Флаг того, что соединение с БД установлено
	 **/
	private $connected = false;
	
	private static $connection;
    
    public static function confDescription() {
        return array(
            "components" => array(
                strtolower(get_class()) => array(
                    "params" => array(
                        "dsn" => "dsn",
                        "user" => "user",
                        "password" => "password",
    				),
    			),
    		),
    	);
    }
	
	public static function serviceFactory() {
	    if(!self::$connection) {
	        self::$connection = new self;
	    }
	    return self::$connection;
	}
	
	public function defaultService() {
	    return "db";
	}
	
	public function query($query) {
	    return new command($this,$query);
	}
	
	/**
	 * Устанавливает соединение с базой данных
	 **/
	public function connect() {
	
	    if($this->connected) {
	        return;
	    }
	    $this->connected = true;
	    
		$dsn = $this->param("dsn");
		$user = $this->param("user");
		$password = $this->param("password");
		
	    $this->dbh = new \PDO($dsn, $user, $password);
	    
	    // Устанавливаем кодировку
	    $this->dbh->exec("set names utf8");
	}
	
	public function quote($str) {
	    Core\Profiler::beginOperation("dao","quote",$str);
	    $ret = $this->dbh()->quote($str);
	    Core\Profiler::endOperation();
	    return $ret;
	    
	}
	
	public function tablePrefix() {
	    return "infuso_";
	}
	
	/**
	 * Создает соединение (если оно еще не было создано)
	 * Возвращает объект класса PDO, создающийся при соедниении
	 **/
	public function dbh() {
	    $this->connect();
	    return $this->dbh;
	}

}
