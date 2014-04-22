<?

namespace Infuso\Heapit\Model;
use \Infuso\Core;

class BargainCollection extends Core\Behaviour {

    public function search($q) {

        if(!$q = trim($q)) {
            return $this;
        }

        $this->like("description", $q);
        $this->orr()->like("description", \util::str($q)->switchLayout());
        $this->joinByField("orgId");
        $this->orr()->like("Infuso\\Heapit\\Model\\Org.title", $q);
        $this->orr()->like("Infuso\\Heapit\\Model\\Org.title", \util::str($q)->switchLayout());

        return $this;

    }

}
