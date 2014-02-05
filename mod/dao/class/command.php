<?

namespace Infuso\Dao;
use Infuso\Core;

class Command extends \Infuso\Core\Component {

	private $query;
	private $connection;

	public function __construct($connection, $query) {
	    $this->query = $query;
	    $this->connection = $connection;
	}
	
	public function connection() {
	    return $this->connection;
	}
	
	public function exec() {
	
	    Core\Profiler::beginOperation("dao","exec",$this->query);
	
	    $dbh = $this->connection()->dbh();
	    $result = $dbh->query($this->query);
	    
	    $error = $dbh->errorInfo();
	    if($error[0] != "00000") {
	        Core\Profiler::endOperation();
	        throw new \Exception($this->query." ".$error[2]);
	    }
	    
	    Core\Profiler::endOperation();
	    return new reader($result,$dbh->lastInsertId());
	}

}
