<?

namespace Infuso\CMS;
use Infuso\Core;

/**
 * Стандартная тема модуля filter
 **/
class Filter extends Core\Behaviour {

    /**
     * Применяет к фильтру массив $_GET
     **/
    public function applyQuery($q) {

        if(!is_array($q)) {
            throw new \Exception("Query must be array");
        }

        $this->queryParams = $q;

        // Устанавливаем текущую страницу
        $page = $this->queryParams["page"];
        $this->page($page);

        $queryParams = $this->queryParams;
        if(!$queryParams) {
            $queryParams = array();
		}

        foreach($queryParams as $key=>$val) {
            if(in_array($key,$this->filterKeys())) {
                if($val) {
                    $this->applySingleFilter($key,$val);
                }
            }
        }

        return $this;

    }
    
    /**
     * Возвращает список разрешенных ключей для отбора
     **/
    public function filterKeys() {
        return array(
            "page",
        );
    }
    
    /**
     * Применяет к коллекции один элемент фильтра
     * Переопределите эту функцию, если вы хотите использовать нестандартные фильтры
     **/
    public function applySingleFilter($key,$val) {

        list($type,$name) = explode("_",$key);

        switch($type) {
            case "eq":
                $val = explode(",",$val);
                $this->eq($name,$val);
                break;
            case "to":
                $this->leq($name,$val);
                break;
            case "from":
                $this->geq($name,$val);
                break;
            case "like":
                $this->like($name,$val);
                break;
            case "match":
                $this->match($name,$val);
                break;

            // Специальная опция для поиска по полю типа "список ссылок"
            // Дополняет $value до пяти символов нулями слева и делает match against
            case "nmatch":
                $val = str_pad($val,5,"0",STR_PAD_LEFT);
                $this->match($name,$val);
                break;

            case "matchStrict":
                $this->match($name,'"'.$val.'"');
                break;
        }
    }
    
    /**
     * Возвращает массив параметров запроса, записанных в методе applyQuery
     **/
    public function queryParams() {
        return $this->queryParams;
    }

    /**
     * @return Возвращает адрес страницы с отбором
     **/
    public function url($params=null) {

        $query = $this->queryParams();

        $q = array();
        foreach($this->filterKeys() as $key) {

            $val = $query[$key];

            if(trim($val)) {
                $q[$key] = $val;
            }
        }

        // Если аргумент - число, используем его как страницу при построении url
        if(is_numeric($params)) {
            $q["page"] = $params;
        }

        // Если аргумент - массив, добавляем его ключи в url
        if(is_array($params)) {
            foreach($params as $key=>$val) {
                if($key!==null && $key!=="") {
                    $q[$key] = $val;
                }
            }
        }

        // Писать что страница первая не имеест смысла
        if($q["page"]==1) {
            unset($q["page"]);
        }

        return "?".http_build_query($q);
    }

}
