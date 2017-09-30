<?

namespace Infuso\Site\Controller;
use Infuso\Core;

/**
 * Тестовый контроллер
 **/
class TestExport extends Core\Controller {

    public function controller() {
        return "test-export";
    }

	public function indexTest() {
		return true;
	}
	
	public function index() {
    
		//$list = reflex_collection::unserialize($p["collection"])->limit($limit)->page($page);
		
		$list = \Infuso\Site\Model\membereditor::allOpenDate();
		$list->limit(0);
		
		
	    $f = fopen(Core\File::get("/bundles/site/res/export.csv")->native(), "w+");

	    // Записываем строки таблицы
	    $n = 0;
	    foreach($list as $item) {
	        $row = array();
	        foreach($item->fields() as $field) {
	            $row[] = self::escape($field->rvalue());
	        }
	        $row = implode(";",$row)."\n";
		    $row = mb_convert_encoding($row,"cp-1251","utf-8");
		    fwrite($f,$row);
		    $n++;
	    }
	    
	    echo $n;
	    
		//} else {
		//	$f = fopen(file::get("/reflex/export/".$name)->native(),"a+");
  
	}
	
	public static function escape($str) {

		// Заменяем точку на запятую в числах
		if(is_float($str))
		    $str = strtr($str,array("."=>","));

		if(preg_match("/[\;\n\"]/",$str)) {
			$str = strtr($str,array('"'=>'""'));
			$str = '"'.$str.'"';
		}
	    return $str;
	}

}