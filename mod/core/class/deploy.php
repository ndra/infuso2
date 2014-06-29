<?

namespace Infuso\Core;

class Deploy implements Handler {

	/**
	 * @handler = infusoDeploy
	 * @handlerPriority = -9999999;
	 **/
	public function onDeploy() {

		app()->msg("Clearing system cache");
		service("cache")->clearByPrefix("system/");

	}

}
