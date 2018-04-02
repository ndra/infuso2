<?

namespace Infuso\Cms\Reflex\Controller;
use \Infuso\Core;

/**
 * Класс для экспорта данных в csv
 **/
class Export extends Core\Controller {

	public static function indexTest() {
	    return app()->user()->checkAccess("admin:showInterface");
	}

	public static function postTest() {
        return app()->user()->checkAccess("admin:showInterface");
	}

	public static function post_doExport($p) {

		$list = \Infuso\Cms\Reflex\Collection::unserialize($p["collection"])
            ->collection()
            ->limit(0);
        $rand = \Infuso\Util\Util::id();  
        $path = app()->publicPath() . "/reflex-export/export_{$rand}.csv";
        $file = Core\File::get($path);
        $file->up()->delete(true);
        Core\File::mkdir($file->up()->path(), true);
	    $f = fopen($file->native(), "w+");

	    // Записываем строки таблицы
	    $n = 0;
	    foreach($list as $item) {
	        $row = array();
	        foreach($item->fields() as $field) {
	            $row[] = self::escape($field->rvalue());
	        }
	        $row = implode(";", $row) . "\n";
		    $row = mb_convert_encoding($row, "cp-1251", "utf-8");
		    fwrite($f, $row);
		    $n ++;
	    }
	    app()->msg("Экспортировано {$n} записей");
        return $path;
	}

	public static function escape($str) {

		// Заменяем точку на запятую в числах
		if(is_float($str)) {
		    $str = strtr($str, array("." => ","));
        }

		if(preg_match("/[\;\n\"]/",$str)) {
			$str = strtr($str,array('"' => '""'));
			$str = '"' . $str . '"';
		}
	    return $str;
	}

}
