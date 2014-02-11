<?

class seo_query extends reflex implements mod_handler {

    

public static function reflex_table() {return array (
  'name' => 'seo_query',
  'fields' => 
  array (
    0 => 
    array (
      'id' => 'igr7sox8hio1z65tvs47lz3883gs0g',
      'name' => 'id',
      'type' => 'jft7-kef8-ccd6-kg85-iueh',
      'editable' => '0',
      'label' => '',
      'default' => '',
      'help' => '',
    ),
    1 => 
    array (
      'id' => '98e2rra81hgphb50k1wwd456jk8xzv',
      'name' => 'domain',
      'type' => 'pg03-cv07-y16t-kli7-fe6x',
      'editable' => '2',
      'label' => 'Домен',
      'default' => '',
      'help' => '',
      'class' => 'seo_domain',
      'collection' => '',
      'titleMethod' => '',
      'group' => '',
      'indexEnabled' => 0,
      'foreignKey' => '',
    ),
    2 => 
    array (
      'id' => 'o24qoug3fg9kfrhk4u9t8xbemgpdoe',
      'name' => 'query',
      'type' => 'v324-89xr-24nk-0z30-r243',
      'editable' => '1',
      'label' => 'Запрос',
      'default' => '',
      'help' => '',
    ),
    3 => 
    array (
      'id' => '4v2owg6jyv2j4ehjp5rqfl2xc9h3cu',
      'name' => 'update',
      'type' => 'ler9-032r-c4t8-9739-e203',
      'editable' => '2',
      'label' => 'Обновлено',
      'default' => '',
      'help' => '',
    ),
    4 => 
    array (
      'id' => 'vzxp5bxp5hx4uh3m1sxplhdwghof1r',
      'name' => 'priority',
      'type' => 'gklv-0ijh-uh7g-7fhu-4jtg',
      'editable' => '0',
      'label' => 'Приоритет',
      'default' => '',
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
        return reflex::get(get_class())->joinByField("domain")->neq("seo_domain.id",0)->asc("priority");
    }

    public static function get($id) {
        return reflex::get(get_class(),$id);
    }

    public function reflex_title() {
        return $this->data("query");
    }

    public function _domain() {
        return seo_domain::get($this->data("domain"));
    }

    public function reflex_parent() { return $this->_domain(); }

    public function reflex_cleanup() {
        if(!$this->_domain()->exists()) return true;
    }

    public function positions() {
        return seo_query_position::all()->eq("queryID",$this->id());
    }

    public function reflex_children() {
        return array(
            $this->positions()->title("Позиции"),
        );
    }

    public function reflex_repair() {
        $this->setUpdateTime();
    }

    public function setUpdateTime() {
        $d = 0;
        foreach($this->_domain()->engines() as $engine) {
            $date = $this->positions()->eq("engineID",$engine->id())->max("date");
            $date = util::date($date)->stamp();
            if($d==0) {
                $d = $date;
            } else {
                if($date<$d) $d = $date;
            }
        }
        $this->data("update",util::date($date));
    }

    public static function refreshLast() {

        $now = util::now()->notime()."";
        $queries = self::all()
            ->joinByField("domain")
            ->where("date(`update`)<>'$now' or `update` is null ");

        $query = $queries->one();

        if($query->exists()) {
            $query->refresh();
        }
    }

    public function on_mod_init() {
        reflex_task::add(array(
            "class" => get_class(),
            "method" => "refreshLast"
        ));
    }

    public function refresh() {

        foreach($this->_domain()->engines() as $engine) {
            $position = seo_query_position::all()->eq("date",util::now()->notime())->eq("engineID",$engine->id())->eq("queryID",$this->id())->one();
            if(!$position->exists()) {
                $position = reflex::create("seo_query_position",array(
                    "engineID" => $engine->id(),
                    "queryID" => $this->id(),
                ));
                $callback = $engine->data("callback");
                $callback = explode("::",$callback);
                $result = call_user_func($callback,$this,$engine->data("callbackParam"));
                $position->data("position",$result["position"]);
                $position->data("url",$result["url"]);
                return;
            }
        }
        $this->setUpdateTime();
    }

}
