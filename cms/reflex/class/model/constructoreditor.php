<?

namespace Infuso\Cms\Reflex\Model;
use Infuso\Cms\Reflex;
use Infuso\Core;
use Infuso\ActiveRecord;

class ConstructorEditor extends Reflex\Editor {

	public function itemClass() {
		return Constructor::inspector()->className();
	}
	
    public function templateMain() {
		return app()->tm("/reflex/constructor")->param("editor",$this);
	}

}
