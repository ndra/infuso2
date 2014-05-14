<?

namespace Infuso\Board\Model;

class TagDescriptionEditor extends \reflex_editor {

	public function root() {
	    return array (
			TagDescription::all()->title("Тэги"),
		);
	}

}
