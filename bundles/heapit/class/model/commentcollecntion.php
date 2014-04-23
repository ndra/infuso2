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
        $this->orr()->like("Infuso\\User\\Model\\User.nickName", $q);
        $this->orr()->like("Infuso\\User\\Model\\User.nickName", \util::str($q)->switchLayout());

        
        return $this;

    }

}
