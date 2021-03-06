<?

namespace Infuso\Board\Widget;
use \Infuso\Core;

/**
 * Виджет списка задач
 **/
class ProjectSelector extends \Infuso\CMS\UI\Widgets\Combo {

    public function __construct() {
        $this->callParams(array(
            "cmd" => "infuso/board/controller/project/listProjects"
        ));
        parent::__construct();
    }

}
