<?

namespace Infuso\Core;
abstract class Route {

	public function priority() {
		return 0;
	}

	abstract public function urlToAction($url);

	abstract public function actionToUrl($action);

}
