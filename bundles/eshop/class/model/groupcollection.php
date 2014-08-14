<?

namespace Infuso\Eshop\Model;
use Infuso\Core;

/**
 * Модель товара
 **/
class GroupCollection extends Core\Behaviour {

    public function active() {
        $this->eq("status", Group::STATUS_ACTIVE);
        return $this;
    }

}
