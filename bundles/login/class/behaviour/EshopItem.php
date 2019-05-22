<?

namespace Infuso\Site\Behaviour;
use \Infuso\Core;

class EshopItem extends Core\Behaviour {

	public static function addToClass() {
		return "Infuso\\Eshop\\Model\\Item";
	}
    
    public function priceObject() {
        return new \Infuso\Site\Price($this->data("price"));
    }
    
    public function price() {
        return $this->priceObject()->rur();
    }

}
