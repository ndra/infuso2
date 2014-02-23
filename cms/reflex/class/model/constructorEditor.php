<?

namespace Infuso\Cms\Reflex\Model;
use Infuso\Cms\Reflex;
use Infuso\Core;
use Infuso\ActiveRecord;

class ConstructorEditor extends Reflex\Editor {

    public function inxEditor() {
        return array(
            "type" => "inx.mod.reflex.construct",
            "constructorID" => $this->item()->id(),
            "form" => $this->item()->getList()->editor()->inxConstructorForm(),
        );
	}
	
	public function beforeEdit() {
		return $this->item()->data("userID") == user::active()->id();
	}

}
