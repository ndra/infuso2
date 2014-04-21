<?

namespace Infuso\Heapit\Model;
use \Infuso\Core;

class OrgCollection extends Core\Behaviour {

    public function search($q) {

        $q = trim($q);


        $this->like("title", $q);
        $this->orr()->like("title", \util::str($q)->switchLayout());

        return $this;

    }

}
