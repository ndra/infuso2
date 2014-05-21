<?

namespace Infuso\Template;
use Infuso\Core;

class Handler implements Core\Handler {

	/**
	 * @handler = infusoDeploy
	 **/
	public function onDeploy() {
	    app()->msg("clear css and js render");
        Render::clearRender();
	}

}
