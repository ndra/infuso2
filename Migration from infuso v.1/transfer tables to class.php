<?

namespace infuso\test;

class tester extends \infuso\core\controller {

    public function indexTest() {
        return true;
    }
    
    public function index($p) {

		\tmp::header();
		
		$map = \mod::service("classmap");
            
        foreach($map->map("Infuso\ActiveRecord\Record") as $class) {
            $path = $class::inspector()->path();
            $code = \file::get($path)->data();
            if(!preg_match("/function\s+reflex_table/",$code)) {
                $tablesPath = $class::inspector()->bundle()->path()."/tables";
                echo $class."<br/>";
                foreach(\file::get($tablesPath)->dir() as $table) {
                    $table = $table->inc();
                    $name = $table["name"];
                    if(strtolower($name) == strtolower($class)) {
                        $fn = function($matches) use ($table) {
                            $ret = $matches[0];
                            
                            $ret.= "\n\n";
                            $ret.= "public static function reflex_table() {";
                            $ret.= "return ".var_export($table,1).";";
                            $ret.= "}";
                            $ret.= "\n\n";
                            return $ret;
                        };
                        $code = preg_replace_callback("/extends\s+[\_a-zA-Z0-9\\\\]+\s+(implements\s+mod_handler\s*)?\{\s*/im",$fn,$code);
						\file::get($path)->put($code);
                        echo "<pre>";
                        echo \util::str($code)->esc();
                        echo "</pre>";
                    }
                }
                echo "<hr/>";
            }
        }

		\util::profiler();

		\tmp::footer();
        
    }

}
