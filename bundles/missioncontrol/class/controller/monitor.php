<?

namespace Infuso\Missioncontrol\Controller;
use Infuso\Site\Model;
use Infuso\Core;

/**
 * Дефолтный контроллер Сайта
 **/
class Monitor extends Core\Controller {

	public function indexTest() {
	    return true;
	}
    
    public function controller() {
        return "missioncontrol";
    }
    
    public function index() {
        echo app()->tm("/missioncontrol/sites")
            ->exec();
    }
    
    public function index_server() {
        echo app()->tm("/missioncontrol/server")
            ->exec();
    }
    
    public function index_logsaver() {
    
        set_time_limit(100);
        sleep(rand()%60);
    
        // Данные из top
        ob_start();
        passthru('/usr/bin/top -b -n 1');
        $data = ob_get_clean();
        $data = explode("\n", $data);
        $data = array_splice($data, 7);
        $top = array();
        
        foreach($data as $key => $val) {
            $pid = (int) substr($val, 0, 5);
            $top[$pid] = array(
                "cpu" => (int) substr($val, 42, 3),
            );
        }
        
        // Данные из server-status
        
        $contents = \Infuso\Core\File::http("http://localhost/server-status")->data();
        $html = new \Infuso\Missioncontrol\HTML($contents);
        $table = $html->xpath("table")->first();
        $data = array();
        
        foreach($table->xpath("tr") as $tr) {
            $cpu = (double)$tr->xpath("td[position() = 5]")->innerHTML();
            $host = $tr->xpath("td[position() = 12]")->innerHTML();
            $ip = $tr->xpath("td[position() = 11]")->innerHTML();
            $path = $tr->xpath("td[position() = 13]")->innerHTML();
            $path = preg_replace("/^GET\s*/", "", $path);
            $pid = $tr->xpath("td[position() = 2]")->innerHTML();
            if($ip != "::1" && $host != "?" && $host != "" && $top[$pid]["cpu"] > 0) {
                $data[] = array(
                    "ip" => $ip,
                    "host" => $host,
                    "cpu" => $top[$pid]["cpu"],
                    "pid" => $pid,
                    "path" => $path,
                );
            }
        }
        service("ar")->create("Infuso\\Missioncontrol\\Model\\ServerStatusLog", array(
            "log" => json_encode($data),
        ));
        
    }
	
}
