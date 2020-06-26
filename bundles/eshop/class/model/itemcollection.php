<?

namespace Infuso\Eshop\Model;
use Infuso\Core;

/**
 * Модель товара
 **/
class ItemCollection extends Core\Behaviour {

    public function active() {
        $this->eq("status", Item::STATUS_ACTIVE);
        return $this;
    }

}
