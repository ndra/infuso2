<?

namespace Infuso\Cms\Reflex\Model;
use Infuso\Cms\Reflex;
use Infuso\Core;
use Infuso\ActiveRecord;

class MetaEditor extends Reflex\Editor {

	public function itemClass() {
		return Meta::inspector()->className();
	}

}
