<?

namespace Infuso\Core;

/**
 * Класс для загрузки конфигурации
 **/
class Conf extends Component {

	private static $generalConf = null;

	/**
	 * Возвращает параметр из общей конфигурации components.yml
	 **/
	public function general() {
	
        // Если в буфере нет конфигурации - загружаем ее
        if(self::$generalConf===null) {

            $reader = new Yaml();
            $yml = file::get(mod::app()->confPath()."/components.yml")->data();
            self::$generalConf = $reader->read($yml);

            if(!self::$generalConf) {
                self::$generalConf = array();
			}
        }

        // Если переданы параметры - извлекаем значения по ключам
        $ret = self::$generalConf;
        foreach(func_get_args() as $key) {
            $ret = $ret[$key];
        }

		return $ret;
	
	}

}
