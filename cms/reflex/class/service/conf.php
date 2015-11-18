<?

namespace Infuso\Cms\Reflex\Service;
use Infuso\Core;

/**
 * Служба доступа к настройкам reflex
 **/
class Conf extends Core\Service {

    public function defaultService() {
        return "reflexconf";
    }

	/**
	 * Возвращает значение строки конфигурации
	 **/
	public function get($name) {
	    return \Infuso\Cms\Reflex\Model\Conf::all()
            ->eq("name", $name)
            ->one()
            ->data("value");
	}
    
	/**
	 * Возвращает p-значение строки конфигурации
	 **/
	public function pget($name) {
	    return \Infuso\Cms\Reflex\Model\Conf::all()
            ->eq("name", $name)
            ->one()
            ->pdata("value");
	}

}
