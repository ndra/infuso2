<?

namespace Infuso\Cms\Reflex\Model;
use Infuso\Core;
use Infuso\ActiveRecord;
use Infuso\Cms\Reflex;

/**
 * Модель роута в каталоге
 **/
class Route extends ActiveRecord\Record {

	public static function model() {
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
		      'name' => 'className',
		      'type' => 'v324-89xr-24nk-0z30-r243',
		      'editable' => '1',
		      'label' => 'className',
		      'length' => '100',
		    ), array (
		      'name' => 'action',
		      'type' => 'v324-89xr-24nk-0z30-r243',
		      'editable' => '1',
		      'label' => 'action',
		      'length' => '100',
		    ), array (
		      'name' => 'params',
		      'type' => 'puhj-w9sn-c10t-85bt-8e67',
		      'editable' => '1',
		      'label' => 'Параметры контроллера',
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

	public function recordTitle() {
		return $this->data("url");
	}

	public static function all() {
		return \reflex::get(get_class())->asc("priority");
	}
	
	/**
	 * Возвращает запись роута
	 * Можно передавать как строку class:id так и объект ActiveRecord
	 **/
	public static function get($param) {
	
	    if(is_object($param) && is_subclass_of($param,"Infuso\\ActiveRecord\\Record")) {
			$class = get_class($param);
			$id = $param->id();
			return self::get($class.":".$id);
	    } elseif(is_string($param)) {
        	return self::all()->eq("hash",$param)->one();
		}
		
		Throw new \Exception();
		
	}

	/**
	 * Возвращает объект, к которому прикреплен данный роут
	 **/
	public function item() {
	    list($class,$id) = explode(":",$this->data("hash"));
	    return Core\Mod::service("ar")->get($class,$id);
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
	 * Возвращает экшн (\Infuso\Core\Action), связанный с данным роутом
	 **/
	public function actionObject() {
		return Core\Action::get($this->className(),$this->action(),$this->pdata("params"));
	}

    public function className() {
        return $this->data("className");
    }

    public function action() {
        return $this->data("action");
    }

	/**
	 * Проверяет, может ли роут построить урл для данного экшна
	 * Для этого нужно:
	 * - Чтобы класс и экшн совпадал
	 * - Чтобы совпадал набор параметров
	 * - Чтобы параметры экшна прошли режекс роута
	 * В случае успеха возвращает строку с url
	 * В противном случае возвращает false
	 **/
	public function actionToUrl($action) {

        // Первым делом сравниваем класс и метод

	    if($this->className() != $action->className()) {
	        return;
        }

	    if($this->action() != $action->action()) {
	        return;
        }

        // Проверяем, чтобы были одинаковые наборы параметров
	    $params1 = array_keys($this->regex());
	    $params2 = array_keys($action->params());
	    sort($params1);
	    sort($params2);
	    if(serialize($params1) != serialize($params2)) {
	        return false;
		}

        // Проверяем, проходят ли параметры экшна реджексы url
	    $regex = $this->regex();
	    foreach($action->params() as $key => $val) {
	        if(!preg_match($regex[$key],$val)) {
	            return false;
            }
        }

        // Заменяем реджексы в url на значения параметров
	    $ret = $this->data("url");
        foreach($action->params() as $key => $val) {
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
	        $seek = $this->actionObject()->hash();
	        $this->data("seek",$seek);
	    } else { // Если у роута есть параметры, очищаем индекс
	        $this->data("seek","");
	    }
	    
	}

	public function beforeStore() {

	    // Для метаданных обрабатываем урл дополнительно
	    $this->normalizeUrl();

	    if($this->data("hash")) {
	        $this->data("className", strtolower(get_class($this->item())));
            $this->data("action", "item"); 
	        $this->data("params",array(
                "id" => $this->item()->id()
            ));
	       // $this->data("domain",$this->item()->domain()->id());
	        $this->data("hash",get_class($this->item()).":".$this->item()->id());
	        $this->data("priority",-10);
	    }

        $className = $this->data("className");
        $className = strtr($className, array('/' => '\\'));
        $className = trim($className,'\\ ');
        $this->data("className", $className);

		if(!preg_match("/^[a-z0-9\_\\\\]+$/",$this->data("className"))) {
		    app()->msg("Недопустимое имя класса. Можно использовать маленькие будкы, цифры, подчеркивание и слэши неймспейсов",1);
		    return false;
		}

        $action = trim($this->data("action"));
        $this->data("action", $action);

        if(!preg_match("/^[a-z0-9\_]+$/",$this->data("action"))) {
		    app()->msg("Недопустимое имя экшна. Можно использовать маленькие будкы, цифры и подчеркивание",1);
		    return false;
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
	        $url = \util::translit($url);

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
	            $this->data("suffix",\util::id(7));
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
