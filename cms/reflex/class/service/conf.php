<?

namespace Infuso\Cms\Reflex\Service;
use Infuso\Core;

/**
 * ������ ������� � ���������� reflex
 **/
class Conf extends Core\Service {

    public function defaultService() {
        return "reflexconf";
    }

	/**
	 * ���������� �������� ������ ������������
	 **/
	public function get($name) {
	    return \Infuso\Cms\Reflex\Model\Conf::all()
            ->eq("name", $name)
            ->one()
            ->data("value");
	}

}
