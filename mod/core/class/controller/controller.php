<?

namespace Infuso\Core;

class Controller extends Component {

	private $redirectUrl = null;
	
	public function _controller() {
	    return strtr(self::inspector()->className(), array("\\" => "/"));
	}

	public function defaultBehaviours() {
		return array(
		    "mod_controller_behaviour"
		);
	}
	
	public final function redirect($url) {
	    // Выполняем редирект только если есть экшн
		if(action::current()) {
		    $this->redirectUrl = $url;
			$this->defer("processRedirect");
		}
	}
	
	public final function processRedirect() {
	    header("Location:{$this->redirectUrl}");
	    die();
	}
    
}
