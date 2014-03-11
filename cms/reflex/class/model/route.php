<?

namespace Infuso\Cms\Reflex\Model;
use Infuso\Core;
use Infuso\ActiveRecord;

/**
 * Модель роута в каталоге
 **/
class Route extends ActiveRecord\Record {

	public static function recordTable() {
		return array (
		  'name' => 'reflex_route_item',
		  'fields' => 
		  array (
		    array (
		      'name' => 'id',
		      'type' => 'jft7-kef8-ccd6-kg85-iueh',
		      'editable' => '0',
		    ), array (
		      'name' => 'hash',
		      'type' => 'v324-89xr-24nk-0z30-r243',
		      'editable' => '0',
		      'label' => 'Хэш (class:ID)',
		      'length' => '100',
		    ), array (
		      'name' => 'url',
		      'type' => 'v324-89xr-24nk-0z30-r243',
		      'editable' => '1',
		      'label' => 'Адрес url',
		      'length' => '100',
		    ), array (
		      'name' => 'controller',
		      'type' => 'v324-89xr-24nk-0z30-r243',
		      'editable' => '1',
		      'label' => 'Контроллер',
		      'length' => '100',
		    ), array (
		      'name' => 'params',
		      'type' => 'puhj-w9sn-c10t-85bt-8e67',
		      'editable' => '1',
		      'label' => 'Дополнительные параметры контроллера',
		    ), array (
		      'name' => 'priority',
		      'type' => 'gklv-0ijh-uh7g-7fhu-4jtg',
		      'editable' => '0',
		      'label' => 'Приоритет',
		    ), array (
		      'name' => 'seek',
		      'type' => 'v324-89xr-24nk-0z30-r243',
		      'editable' => '0',
		      'label' => 'rapid seek hash',
		    ), array (
		      'name' => 'domain',
		      'type' => 'pg03-cv07-y16t-kli7-fe6x',
		      'editable' => '1',
		      'label' => 'Правило только для домена',
		      'class' => 'reflex_domain',
		    ), array (
		      'editable' => 2,
		      'name' => 'suffix',
		      'type' => 'v324-89xr-24nk-0z30-r243',
		      'label' => 'Суффикс',
		      'length' => '7',
		    ),
		  ),
		);
	}

	public static function reflex_root() {
	    return self::all()->title("Роуты")->param("sort",true)->param("tab","system");
	}

	public function reflex_title() {
		return $this->data("url");
	}

	public function reflex_meta() {
		return true;
	}
	
	public function reflex_route() {
		return false;
	}
	
	public function reflex_url() {
		return $this->data("url");
	}

	public static function all() {
		return \reflex::get(get_class())->asc("priority");
	}
	
	public static function get($hash) {
		return self::all()->eq("hash",$hash)->one();
	}

	// Возвращает объект, к которому прикреплен данный роут
	public function item() {
	    list($class,$id) = explode(":",$this->data("hash"));
	    return reflex::get($class,$id);
	}

	/**
	 * @return Возвоащает true/false в зависимости от  того, содержит ли урл параметры типа <x:123>
	 **/
	public function parametric() {
	    return preg_match("/\<([a-z0-9]+)\:(.*?)\>/s",$this->data("url"));
	}

	/**
	 * Возвращает массив регулярных выражений для каждого из параметров в данном маршруте
	 * К примеру, если url = /site/<x:12>/<y:\d>/
	 * То метод вернет
	 * array(
	 * 	x=>/^12$/,
	 * 	y=>/^\d$/
	 * )
	 **/
	public function regex() {
	
	    preg_match_all("/\<([a-z0-9]+)\:(.*?)\>/s",$this->data("url"),$matches);
	    
	    if(sizeof($matches[1])) {
	        $ret = array_combine($matches[1],$matches[2]);
		} else {
	        $ret = array();
		}
		
	    foreach($ret as $key=>$val) {
	        $ret[$key] = "<^".$val.'$>';
		}

	    foreach($this->pdata("params") as $key=>$val) {
	        $ret[$key] = "<^".preg_quote($val).'$>';
		}

	    return $ret;
	}

	/**
	 * Возвращает экшн (mod_action), связанный с данным роутом
	 **/
	public function action() {
		list($class,$action) = explode("/",$this->data("controller"));
		return mod::action($class,$action,$this->pdata("params"));
	}

	/**
	 * Проверяет, может ли роут построить урл для данного экшна
	 * Для этого нужно:
	 * - Чтобы класс и экшн совпадал
	 * - Чтобы совпадал набор параметров
	 * - Чтобы параметры экшна прошли режекс роута
	 **/
	public function testController($controller) {

	    list($class,$action) = explode("/",$this->data("controller"));

        // Первым делом сравниваем класс и метод

	    if($class!=$controller->className()) {
	        return;
        }

	    if($action != $controller->action()) {
	        return;
        }

        // Проверяем, чтобы были одинаковые наборы параметров

	    $params1 = array_keys($this->regex());
	    $params2 = array_keys($controller->params());
	    sort($params1);
	    sort($params2);
	    
	    if(serialize($params1)!=serialize($params2)) {
	        return false;
		}

	    $regex = $this->regex();
	    foreach($controller->params() as $key=>$val) {
	        if(!preg_match($regex[$key],$val)) {
	            return false;
            }
        }

	    $ret = $this->data("url");
        foreach($controller->params() as $key=>$val) {
            $ret = preg_replace("/\<$key\:.*?\>/s",$val,$ret);
        }

	    return $ret;
	}

	/**
	 * Обновляет индекс для быстрого поиска
	 **/
	public function updateSeekHash() {
	
	    // Если у роута нет параметров, расчитываем индекс для быстрого поиска
	    if(!$this->parametric()) {
	        $seek = $this->action()->hash();
	        $this->data("seek",$seek);
	    } else { // Если у роута есть параметры, очищаем индекс
	        $this->data("seek","");
	    }
	    
	}

	public function reflex_beforeStore() {

		if(!$this->data("hash")) {
			if(!preg_match("/^([a-z0-9\_]+)\/([a-z0-9\_]+)$/i",$this->data("controller"))) {
			    mod::msg("Неверный формат контроллера. Используйте формат class_name/action",1);
			    return false;
			}
		}

	    // Для метаданных обрабатываем урл дополнительно
	    $this->normalizeUrl();

	    if($this->data("hash")) {
	        $this->data("controller",get_class($this->item())."/item");
	        $this->data("params",array("id"=>$this->item()->id()));
	        $this->data("domain",$this->item()->domain()->id());
	        $this->data("hash",get_class($this->item()).":".$this->item()->id());
	        $this->data("priority",-10);
	    }

		$this->updateSeekHash();

	    $this->bastards()->delete();
	    
	    $this->handleDupes();

	}
	
	/**
	 * Нормализует урл
	 **/
	public function normalizeURL() {
	
		$url = $this->data("url");

	    // Нормализуем урл
	    $url = "/".trim($url,"/ ");
	    
	    if($this->data("hash")) {
	
			$url = trim($url);
		    $url = $url ? "/".trim($url,"/") : "/";

	        // Переводим УРЛ в транслит
	        $url = mb_strtolower($url,"utf-8");
	        $url = util::translit($url);

	        // Убираем все лишнее из url
	        $url = preg_replace("/[^1234567890qwertyuiopasdfghjklzxcvbnm\-\_\/\.]+/","-",$url);

	        // Убираем двойные пробелы и двойные дефисы
	        $url = preg_replace("/( )+/","-",$url);
	        $url = preg_replace("/-+/","-",$url);

	        // Убираем двойные слэши
	        $url = preg_replace("/\/+/","/",$url);

	        // Убираем пробелы по краям
	        $url = "/".trim($url," /-._");
	        
		}
		
		$this->data("url",$url);

	}
	
	public function reflex_afterStore() {
	    mod::service("route")->clearCache();
	}

	/**
	 * Если два элемента имеюит один и тот же урл, это плохо.
	 * Эта функция ищет в списке роутов роут с таким же урл, как у этого и, если найдет,
	 * переименовывает текущий.
	 **/
	public function handleDupes() {
	
	    $dupes = $this->itemsWithSameURL();
	    
	    if($dupes->count()) {
	        if(!$this->data("suffix")) {
	            $this->data("suffix",util::id(7));
	        }
			$this->data("url",$this->data("url")."-".$this->data("suffix"));
	    }
	}

	/**
	 * Возвращает список элементов с таким же хэшем
	 **/
	public function bastards() {
	    return self::all()
			->neq("hash","")
			->eq("hash",$this->data("hash"))
			->neq("id",$this->id());
	}
	
	/**
	 * Возвращает список объектов с таким же url
	 **/
	public function itemsWithSameURL() {
	    return self::all()
			->eq("url",$this->data("url"))
			->eq("domain",$this->data("domain"))
			->neq("id",$this->id());
	}

}