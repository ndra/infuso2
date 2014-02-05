<?

namespace infuso\dao;

use Infuso\Core;

class connection extends \infuso\core\service {

	/**
	 * ������ ������ PDO, ����������� ��� ����������
	 **/
	private $dbh;
	
	/**
	 * ���� ����, ��� ���������� � �� �����������
	 **/
	private $connected = false;

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
		$dsn = $this->param("dsn");
		$user = $this->param("user");
		$password = $this->param("password");
	    $this->dbh = new \PDO($dsn, $user, $password);
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
	
	    if(!$this->connected) {
		    $this->connect();
		    return $this->dbh;
	    }
	}

}
