<?

namespace Infuso\Cms\Reflex\Model;
use Infuso\Core;
use Infuso\ActiveRecord;

/**
 * Модель домена
 **/
class Domain extends ActiveRecord\Record {	

	/**
	 * Здесь будет лежать объект активного домена
	 **/
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
			  ),
			),
		);
	}

	/**
	 * Возвращает список доманов
	 **/
	public static function all() {
		return \reflex::get(get_class())
			->asc("priority")
			->param("sort",true);
	}
	
	/**
	 * Возвращает домен по id
	 **/
	public static function get($id) {
		return Core\Mod::service("ar")
			->get(get_class(),$id);
	}

	/**
	 * Возвращает имя записи
	 **/
	public function recordTitle() {
	
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
		
		if($this->isActive()) {
		    $ret.= " (текущий)";
		}
		
		return $ret;
	}

	/**
	 * Возвращает массив алиасов для данного домена
	 **/
	public function domainList() {
		return \util::splitAndTrim($this->data("domains"),"\n");
	}

	/**
	 * Возвращает активный домен
	 **/
	public function active() {
		if(!self::$active) {
		    self::$active = self::get(0);
			foreach(self::all() as $domain) {
			    if($domain->isActive()) {
					self::$active = $domain;
					break;
				}
			}
		}
		return self::$active;
	}
	
	/**
	 * Возвращает признак активности этого домена
	 **/
	public function isActive() {
		$currentDomain = \mod_url::current()->domain();
	    foreach($this->domainList() as $domain) {
	    	if(trim($domain) == $currentDomain) {
				return true;
			}
		}
		return false;
	}

	public function firstDomain() {
		$ret = $this->domainList();
		return $ret[0];
	}

	public function recordUrl() {
		$domains = $this->domainList();
		return "http://".$domains[0];
	}
	
}
