<?

namespace Infuso\Cms\Reflex\Model;

class Redirect extends \Infuso\ActiveRecord\Record {

    public static function model() {
        return array (
            'name' => self::inspector()->className(),
            'fields' => array (
                array (
                  'name' => 'id',
                  'type' => 'jft7-kef8-ccd6-kg85-iueh',
                ), array (
                    'name' => 'source',
                    'type' => 'v324-89xr-24nk-0z30-r243',
                    'editable' => '1',
                    'label' => "Откуда",
                ), array (
                    'name' => 'target',
                    'type' => 'v324-89xr-24nk-0z30-r243',
                    'editable' => '1',
                    'label' => "Куда",
                ),
            ),
        );
    }

    public function indexTest() {
		return true;
	}
    
    public function afterStore() {
        service("route")->clearCache();
    }
    
    public function beforeStore() {
        $url = (new \Infuso\Core\Url($this->data("source")))->relative();
        $url = "/".trim($url, "/");
        $this->data("source", $url);
    }

	public function index_redirect($p) {
		header("Location: $p[target]", true, 301);
	}

	public function recordTitle() {
		return $this->data("source")." &rarr; ".$this->data("target");
	}

	public static function all() {
		return service("ar")->collection(get_called_class());
	}
	
}
