<?

class seo_query_position extends reflex {

	

public static function reflex_table() {return array (
  'name' => 'seo_query_position',
  'fields' => 
  array (
    0 => 
    array (
      'id' => 'yyv7m6gcxqc9heswg66r4fp4t00hjx',
      'name' => 'id',
      'type' => 'jft7-kef8-ccd6-kg85-iueh',
      'editable' => '0',
      'label' => '',
      'default' => '',
      'help' => '',
    ),
    1 => 
    array (
      'id' => 'tshjkgwvm77wtc4yf8alagyakz0un1',
      'name' => 'engineID',
      'type' => 'pg03-cv07-y16t-kli7-fe6x',
      'editable' => '1',
      'label' => 'Механизм',
      'default' => '',
      'help' => '',
      'class' => 'seo_query_engine',
      'collection' => '',
      'titleMethod' => '',
      'group' => '',
      'indexEnabled' => 0,
      'foreignKey' => '',
    ),
    2 => 
    array (
      'id' => 'iurqs9x6vq0ay4gi3326ew4w2jj0bj',
      'name' => 'queryID',
      'type' => 'pg03-cv07-y16t-kli7-fe6x',
      'editable' => '2',
      'label' => 'Запрос',
      'default' => '',
      'help' => '',
      'class' => 'seo_query',
      'collection' => '',
      'titleMethod' => '',
      'group' => '',
      'indexEnabled' => 0,
      'foreignKey' => '',
    ),
    3 => 
    array (
      'id' => 'jlscozpx6nuw0qflhq10o1rra5dx11',
      'name' => 'position',
      'type' => 'gklv-0ijh-uh7g-7fhu-4jtg',
      'editable' => '2',
      'label' => 'Позиция',
      'default' => '',
      'help' => '',
    ),
    4 => 
    array (
      'id' => 'itkaromvbjf9sdplb7m1zjpgrjm50o',
      'name' => 'url',
      'type' => 'v324-89xr-24nk-0z30-r243',
      'editable' => '2',
      'label' => 'Адрес найденной страницы',
      'default' => '',
      'help' => '',
    ),
    5 => 
    array (
      'id' => 'ry96w3w6ffjnsmf4hy3sfu8877vk21',
      'name' => 'date',
      'type' => 'ler9-032r-c4t8-9739-e203',
      'editable' => '1',
      'label' => 'Дата',
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

public static function all() { return reflex::get(get_class())->desc("date"); }
	
	public static function today() { return self::all()->eq("date",util::now()); }

	public static function get($id) { return reflex::get(get_class(),$id); }
	
	public static function reflex_root() {
		return array(
			self::all()->title("Позиции")->param("tab","system")
		);
	}

	public function reflex_parent() { return $this->query(); }

	public function query() { return seo_query::get($this->data("queryID")); }
	
	public function _domain() { return seo_query::get($this->data("queryID"))->_domain(); }
	
	public function engine() { return seo_engine::get($this->data("engineID")); }

	public function reflex_afterStore() { $this->query()->setUpdateTime(); }
	
	public function reflex_afterDelete() { $this->query()->setUpdateTime(); }

	public function reflex_beforeCreate() {
	    $this->data("date",util::now());
	    $this->data("position",99999);
	}

	public static function best() {
	    $domains = seo_domain::all()->eq("public",1)->distinct("id");
	    $qq = seo_query::all()->eq("domain",$domains)->distinct("id");
	    return self::today()->eq("queryID",$qq)->leq("position",3)->geq("position",1)->asc("position");
	}
	
}
