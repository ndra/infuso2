<?

namespace Infuso\Template;
use Infuso\Core;

class Handler implements Core\Handler {

	public function on_mod_init() {
	    \mod::msg("clear css and js render");
		Render::clearRender();
	}

}
