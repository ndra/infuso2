<?

namespace Infuso\Core;

class Deploy implements Handler {

	/**
	 * @handler = infuso/deploy
	 * @handlerPriority = -9999999;
	 **/
	public function onDeploy() {

		app()->msg("Clearing system cache");
		service("cache")->clearByPrefix("system/");

	}

}
