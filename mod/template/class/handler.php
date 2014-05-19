<?

namespace Infuso\Template;
use Infuso\Core;

class Handler implements Core\Handler {

	/**
	 * @handler = infusoDeploy
	 **/
	public function onDeploy() {
	    \mod::msg("clear css and js render");
        Render::clearRender();
	}

}
