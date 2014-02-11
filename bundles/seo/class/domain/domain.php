<?

class seo_domain extends reflex {

    

public static function reflex_table() {return array (
  'name' => 'seo_domain',
  'fields' => 
  array (
    0 => 
    array (
      'id' => 'h3yo5hxv5yf44cbxpaebuza1rj7znd',
      'name' => 'id',
      'type' => 'jft7-kef8-ccd6-kg85-iueh',
      'editable' => '0',
      'label' => '',
      'param' => '',
      'help' => '',
    ),
    1 => 
    array (
      'id' => 'ifgesz2c6sk95x43hddimokmnaharf',
      'name' => 'domain',
      'type' => 'v324-89xr-24nk-0z30-r243',
      'editable' => '1',
      'label' => 'Домен',
      'param' => '',
      'help' => '',
    ),
    2 => 
    array (
      'id' => '8n44zxxu8u67odnnsowfxvdt1lgvey',
      'name' => 'engines',
      'type' => 'car3-mlid-mabj-mgi3-8aro',
      'editable' => '1',
      'label' => 'Поисковые системы',
      'param' => 'seo_query_engine',
      'help' => '',
      'group' => '',
      'default' => '',
      'indexEnabled' => 0,
      'class' => 'seo_query_engine',
      'foreignKey' => '',
      'collection' => '',
      'titleMethod' => '',
    ),
    3 => 
    array (
      'id' => 'ds8nrul4ah2h5y9nh0c11qjw2715xn',
      'name' => 'public',
      'type' => 'fsxp-lhdw-ghof-1rnk-5bqp',
      'editable' => '1',
      'label' => 'Показывать на сайте',
      'param' => '',
      'help' => '',
    ),
    4 => 
    array (
      'id' => '4lbnyvrqcartwe2omeink5znfab3mu',
      'name' => 'updated',
      'type' => 'x8g2-xkgh-jc52-tpe2-jcgb',
      'editable' => '2',
      'label' => 'Обновлено',
      'param' => '',
      'help' => '',
    ),
    5 => 
    array (
      'id' => '2ow9rxy9rxpvixp9iqfv2opvijcviq',
      'name' => 'extra',
      'type' => 'puhj-w9sn-c10t-85bt-8e67',
      'editable' => '2',
      'label' => 'Дополнительно',
      'param' => '',
      'help' => '',
    ),
    6 => 
    array (
      'id' => 'nfusqp9bqcebtwu2nwlztw1bxmghjm',
      'name' => 'backlinks',
      'type' => 'fsxp-lhdw-ghof-1rnk-5bqp',
      'editable' => '1',
      'label' => 'Искать бэклинки',
      'param' => '',
      'help' => '',
    ),
  ),
  'indexes' => 
  array (
  ),
  'fieldGroups' => 
  array (
    0 => 
    array (
      'name' => NULL,
      'title' => NULL,
    ),
  ),
);}

public static function all() {
        return reflex::get(get_class());
    }
    
    public static function get($id) {
        return reflex::get(get_class(),$id);
    }
    

    public static function reflex_root() {
        return array(
            self::all()->title("Домены")->param("tab","system")
        );
    }
    
    public function reflex_children() {
        return array(
            $this->queries()->title("Запросы")->param("sort",true)
        );
    }

    public function reflex_title() {
        return $this->data("domain");
    }

    public function queries() {
        return seo_query::all()->eq("domain",$this->id());
    }
    
    public function engines() {
        return $this->pdata("engines");
    }

    public function primaryEngine() {
        foreach($this->engines() as $engine) {
            return $engine;
        }
    }

    public function queriesInTop() {
        $engine = $this->primaryEngine();
        foreach($this->queries()->limit(0) as $query) {
            $position = $query->positions()->eq("date",util::now()->notime())->eq("engineID",$engine->id())->one()->data("position");
            if($position>=1 && $position<=10)
                $ids[] = $query->id();
        }
        return $this->queries()->eq("id",$ids);
    }

    public function extra($key,$val=null) {
        $extra = $this->pdata("extra");
        if(func_num_args()==1) {
            return $extra[$key];
        }
        if(func_num_args()==2) {
            $extra[$key] = $val;
            $this->data("extra",json_encode($extra));
        }
    }

    public static function scanOne() {
        self::all()->eq("backlinks",1)->asc("updated")->one()->scan();
    }

    public function scan() {
        if(!$this->exists()) return;
        $p = intval($this->extra("solomono"));
        if(!$p) $p = 1;
        $p = self::solomono($this->data("domain"),$p);
        $this->extra("solomono",$p);
        $this->data("updated",util::now());
    }

    public function solomono($requestDomain,$page=1) {
        $url = "http://solomono.ru/?search=$requestDomain&p=$page";
        $opts = array(
            'http' => array(
                'method'=> "GET",
                'header'=> "User-Agent:Mozilla/5.0 (Windows NT 5.1) AppleWebKit/534.30 (KHTML, like Gecko) Chrome/12.0.742.122 Safari/534.30",
            )
        );
        $context = stream_context_create($opts);
        $str = file_get_contents($url,false,$context);
        $doc = new domDocument();
        @$doc->loadHTML($str);
        $xml = simplexml_import_dom($doc);
        $n = 0;
        foreach($xml->xpath("//a") as $a) {
            $href = $a->attributes()->href."";
            if(!preg_match("/^http/",$href)) continue;
            $domain = mod_url::get($href)->_domain();
            if(in_array($domain,array($requestDomain,"solomono.ru"))) continue;
            $n++;
            seo_page::add($href);
        }
        if($n<20) return "done";
        return $page+1;
    }
    
}
