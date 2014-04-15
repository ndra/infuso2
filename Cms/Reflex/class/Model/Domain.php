<?

namespace Infuso\Cms\Reflex\Model;
use Infuso\Core;
use Infuso\ActiveRecord;

/**
 * Модель домена модуля reflex
 **/
 
class Domain extends ActiveRecord\Record {	

	private static $active = null;

	public static function recordTable() {
		return array (
			'name' => 'reflex_domain',
			'fields' => array (
			  array (
			    'name' => 'id',
			    'type' => 'jft7-kef8-ccd6-kg85-iueh',
			  ), array (
			    'name' => 'domains',
			    'type' => 'kbd4-xo34-tnb3-4nxl-cmhu',
			    'editable' => '1',
			    'label' => 'Домены (каждый с новой строки)',
			  ), array (
			    'name' => 'title',
			    'type' => 'v324-89xr-24nk-0z30-r243',
			    'editable' => '1',
			    'label' => 'Название (рус.)',
			  ), array (
			    'id' => '9btfebxmv6qm50xp92jfvhjfv2xw5i',
			    'name' => 'priority',
			    'type' => 'gklv-0ijh-uh7g-7fhu-4jtg',
			    'editable' => '0',
			  ),
			),
		);
	}

	public static function all() {
		return \reflex::get(get_class())->asc("priority")->param("sort",true);
	}
	
	public static function get($id) {
		return Core\Mod::service("ar")->get(get_class(),$id);
	}

	public function reflex_title() {
	
	    if(!$this->exists()) {
	        return "";
	    }
	
		$ret = trim($this->data("title"));
		if(!$ret) {
		    $ret = $this->firstDomain();
		}
		if(!$ret) {
		    $ret = "Домен:".$this->id();
		}
		return $ret;
	}

	public function active() {
		if(!self::$active) {
		    self::$active = self::get(0);
			$url = \mod_url::current()->domain();
			foreach(self::all() as $domain) {
			    foreach($domain->domainList() as $d) {
			    	if(trim($d)==$url) {
						self::$active = $domain;
						break;
					}
				}
			}
		}
		return self::$active;
	}

	public static function reflex_root() {
		return array(
		    self::all()->title("Домены")->param("tab","system"),
		);
	}

	public function domainList() {
		return util::splitAndTrim($this->data("domains"),"\n");
	}

	public function firstDomain() {
		$ret = $this->domainList();
		return $ret[0];
	}

	public function reflex_url() {
		$domains = $this->domainList();
		return "http://".$domains[0];
	}
	
}
