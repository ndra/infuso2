<?

namespace Infuso\User\Model;
use \Infuso\Core;

/**
 * Модель пользователя
 **/
class UserCollection extends Core\Behaviour {

    public function withRole($role) {
        $this->join("Infuso\\User\\Model\\RoleAttached", "`Infuso\\User\\Model\\RoleAttached`.`userId` = `Infuso\\User\\Model\\User`.`id`")
            ->groupBy("id")
            ->eq("Infuso\\User\\Model\\RoleAttached.role", $role);
        return $this;    
    }
    
    public function active() {
        $this->eq("verified", 1);
    }

}
