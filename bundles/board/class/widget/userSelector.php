<?

namespace Infuso\Board\Widget;
use \Infuso\Core;

/**
 * Виджет списка задач
 **/
class UserSelector extends \Infuso\CMS\UI\Widgets\Combo {

    public function __construct() {
        $this->callParams(array(
            "cmd" => "infuso/board/controller/user/listUsers"
        ));
        parent::__construct();
    }

}
