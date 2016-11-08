<?

namespace Infuso\CMS\Profiler;

class Controller extends \Infuso\Core\Controller {

    public function postTest() {
        return \Infuso\Core\Superadmin::check();
    }

    public function post_info($p) {
        return app()
            ->tm("/cms/profiler/profiler")
            ->param("id", $p["id"])
            ->param("data", self::loadData($p["id"]))
            ->getContentForAjax();
    }
    
    public function post_short($p) {
        return app()
            ->tm("/cms/profiler/profiler-short")
            ->param("id", $p["id"])
            ->param("data", self::loadData($p["id"]))
            ->getContentForAjax();
    }
    
    public static function storeData() {     
        $key = \Infuso\Core\Profiler::id();
        $data = \Infuso\Core\Profiler::getData();
        $data['variables']["time"] = microtime(1) - $_SERVER["REQUEST_TIME_FLOAT"];
        $data["variables"]["memory-peak"] = memory_get_peak_usage();
        $data["variables"]["memory-limit"] = ini_get("memory_limit");
        $data["variables"]["action"] = app()->action()->ar();
        $data["server"] = $_SERVER;
        $path = \Infuso\Core\File::get(app()->varPath()."/profiler/".$key.".txt");
        \Infuso\Core\File::mkdir($path->up());
        $path->put(serialize($data));     
        
        if(rand() % 20 == 0) {
            $n = 1;
            foreach($path->up()->dir()->tsort() as $file) {
                if($n > 50) {
                    $file->delete();
                }
                $n ++;
            }
        }
                   
    }
    
    public static function loadData($key) {
        $file = \Infuso\Core\File::get(app()->varPath()."/profiler/".$key.".txt");
        return unserialize($file->data());                
    }

}
