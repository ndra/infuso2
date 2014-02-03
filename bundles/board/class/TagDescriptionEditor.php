<?

namespace Infuso\Board;

class TagDescriptionEditor extends \reflex_editor {

	public function root() {
	    return array (
			TaskTagDescription::all()->title("Тэги"),
		);
	}

}
