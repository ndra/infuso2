<?

namespace Infuso\Template;
use Infuso\Core;

class Handler implements Core\Handler {

	/**
	 * @handler = infusoInit
	 **/
	public function onInit() {
	    \mod::msg("clear css and js render");
		Render::clearRender();
	}

}
