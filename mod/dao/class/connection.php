<?

namespace infuso\dao;  
use Infuso\Core;

class Connection extends Core\Service {

	/**
	 * ������ ������ PDO, ����������� ��� ����������
	 **/
	private $dbh;
	
	/**
	 * ���� ����, ��� ���������� � �� �����������
	 **/
	private $connected = false;
	
	private static $connection;
	
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
	 * ������������� ���������� � ����� ������
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
	    
	    // ������������� ���������
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
	 * ������� ���������� (���� ��� ��� �� ���� �������)
	 * ���������� ������ ������ PDO, ����������� ��� ����������
	 **/
	public function dbh() {
	    $this->connect();
	    return $this->dbh;
	}

}
