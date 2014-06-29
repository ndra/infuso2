<?

namespace infuso\core\cache;

/**
 * Драйвер кэша файловой системы
 **/
class filesystem extends driver {

	public static function cachePath() {
	    return \mod::app()->varPath()."/cache/";
	}

    /**
     * Воозвращает файл переменнгой по ключу
     **/
    private static function filename($key) {
        $hash = md5($key);
        $path = self::cachePath().substr($hash,0,2)."/$hash.txt";
        return $path;
    }

    /**
     * Возвращает значение переменной
     **/
    public function get($key) {
        $ret = \infuso\core\file::get(self::filename($key))->data();
        if($ret !== null) {
        	$ret = json_decode($ret,1);
        }
        return $ret;
    }

    /**
     * Устанавливает значение переменной
     **/
    public function set($key,$val) {
        $val = json_encode($val);
        \infuso\core\file::mkdir(\infuso\core\file::get(self::filename($key))->up());
        \infuso\core\file::get(self::filename($key))->put($val);
    }

    /**
     * Очищает кэш
     * Удаляет папку /mod/cache/
     **/
    public function clear() {
        \infuso\core\file::get(self::cachePath())->delete(true);
    }
    
    /**
     * Очищает кэш
     * Удаляет папку /mod/cache/
     **/
    public function clearByPrefix($prefix) {
        self::clear();
    }

}
