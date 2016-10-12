<?

namespace Infuso\Missioncontrol\Model;
use Infuso\Core;

class ServerStatusLogEditor extends \Infuso\CMS\Reflex\Editor {

    public function itemClass() {
        return ServerStatusLog::inspector()->className();
    }

    /**
     * @reflex-root = on
     **/
    public function all() {
        return ServerStatusLog::all()->title("Лог server-status");
    }
} 