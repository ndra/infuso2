<?

namespace Infuso\Heapit\Model;
use \Infuso\Core;

class CommentCollection extends Core\Behaviour {

    public function search($q) {

        if(!$q = trim($q)) {
            return $this;
        }

        $this->like("text", $q);
        $this->orr()->like("text", \util::str($q)->switchLayout());
        $this->joinByField("author");
        $this->orr()->like("infuso\\user\\model\\user.firstName", $q);
        $this->orr()->like("infuso\\user\\model\\user.firstName", \util::str($q)->switchLayout());
        $this->orr()->like("infuso\\user\\model\\user.lastName", $q);
        $this->orr()->like("infuso\\user\\model\\user.lastName", \util::str($q)->switchLayout());
        $this->orr()->like("infuso\\user\\model\\user.nickName", $q);
        $this->orr()->like("infuso\\user\\model\\user.nickName", \util::str($q)->switchLayout());
        $this->orr()->like("infuso\\user\\model\\user.email", $q);
        $this->orr()->like("infuso\\user\\model\\user.email", \util::str($q)->switchLayout());
        
        return $this;

    }

}
