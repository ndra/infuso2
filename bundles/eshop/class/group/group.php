<?

/**
 * Модель группы для интернет-магазина
 **/
class eshop_group extends reflex {

	

public static function recordTable() {return array (
  'name' => 'eshop_group',
  'parent' => '',
  'fields' => 
  array (
    0 => 
    array (
      'id' => 'b7fabqfvb7yuiqk50nmvzt4usj8a6d',
      'name' => 'id',
      'type' => 'jft7-kef8-ccd6-kg85-iueh',
      'editable' => '0',
      'label' => 'Первичный ключ',
      'group' => '',
      'default' => '',
      'indexEnabled' => '0',
      'help' => '',
    ),
    1 => 
    array (
      'id' => 'd2qhdv2nduxijgjlg7b1imjciiugby',
      'name' => 'depth',
      'type' => 'gklv-0ijh-uh7g-7fhu-4jtg',
      'editable' => '0',
      'label' => 'Глубина',
      'group' => '',
      'default' => '',
      'indexEnabled' => '1',
      'help' => '',
    ),
    2 => 
    array (
      'id' => 'y9r7m5iok5ixpe0oyebnc16qwebjyl',
      'name' => 'priority',
      'type' => 'gklv-0ijh-uh7g-7fhu-4jtg',
      'editable' => '0',
      'label' => 'Приоритет',
      'group' => '',
      'default' => '',
      'indexEnabled' => '1',
      'help' => '',
    ),
    3 => 
    array (
      'id' => '8ahqc50tcgb3mg6dweijw5z3f1iowv',
      'name' => 'parent',
      'type' => 'pg03-cv07-y16t-kli7-fe6x',
      'editable' => '0',
      'label' => 'Родительская группа',
      'group' => '',
      'default' => '',
      'indexEnabled' => '1',
      'help' => '',
      'class' => 'eshop_group',
      'collection' => '',
      'titleMethod' => '',
    ),
    4 => 
    array (
      'id' => 'bdwg2jp1snye0d4vs7p50n41znp9bo',
      'name' => 'title',
      'type' => 'v324-89xr-24nk-0z30-r243',
      'editable' => '1',
      'label' => 'Название группы товаров',
      'group' => 'Основные',
      'default' => '',
      'indexEnabled' => '1',
      'help' => 'Название товарной группы',
      'length' => '',
    ),
    5 => 
    array (
      'id' => 'w56npv6dflzo8a03kvstcl67wvso89',
      'name' => 'icon',
      'type' => 'knh9-0kgy-csg9-1nv8-7go9',
      'editable' => '1',
      'label' => 'Изображение группы',
      'group' => 'Основные',
      'default' => '',
      'indexEnabled' => '1',
      'help' => '',
    ),
    6 => 
    array (
      'id' => '0xpuz3yez3c1bn8lij8lr7mlbqkgzd',
      'name' => 'active',
      'type' => 'fsxp-lhdw-ghof-1rnk-5bqp',
      'editable' => '1',
      'label' => 'Активна',
      'group' => 'Основные',
      'default' => '',
      'indexEnabled' => '1',
      'help' => '',
    ),
    7 => 
    array (
      'id' => 'rxfe2jk5st4ghdk9btpuhqp5zqm5hn',
      'name' => 'starred',
      'type' => 'fsxp-lhdw-ghof-1rnk-5bqp',
      'editable' => '1',
      'label' => 'Избранная группа',
      'group' => 'Основные',
      'default' => '',
      'indexEnabled' => '1',
      'help' => '',
    ),
    8 => 
    array (
      'id' => 'kezdpvbdy167puijfvrdc5rqy1bx8a',
      'name' => 'description',
      'type' => 'kbd4-xo34-tnb3-4nxl-cmhu',
      'editable' => '1',
      'label' => 'Описание',
      'group' => 'Основные',
      'default' => '',
      'indexEnabled' => '0',
      'help' => '',
    ),
    9 => 
    array (
      'id' => '0dw90of56d4a0j492dw52q8v6qfehd',
      'name' => 'createRight',
      'type' => 'fsxp-lhdw-ghof-1rnk-5bqp',
      'editable' => '1',
      'label' => 'Создать право для редактирования товаров в этой группе',
      'group' => 'Дополнительно',
      'default' => '',
      'indexEnabled' => '1',
      'help' => '',
    ),
    10 => 
    array (
      'id' => '3k90jfgsx490x4lb3p5bjfv6tw5b3m',
      'name' => 'extra',
      'type' => 'puhj-w9sn-c10t-85bt-8e67',
      'editable' => '1',
      'label' => 'Дополнительно',
      'group' => 'Дополнительно',
      'default' => '',
      'indexEnabled' => '0',
      'help' => '',
    ),
    11 => 
    array (
      'id' => 'farnm50d8g2o8ubqmvhqf1soyuzo89',
      'name' => 'numberOfSubgroups',
      'type' => 'gklv-0ijh-uh7g-7fhu-4jtg',
      'editable' => '2',
      'label' => 'Количество подгрупп',
      'group' => 'Дополнительно',
      'default' => '',
      'indexEnabled' => '1',
      'help' => '',
    ),
    12 => 
    array (
      'id' => '3y5bok52jfvr7cgr7wvz7yl6q4abnp',
      'name' => 'numberOfItems',
      'type' => 'gklv-0ijh-uh7g-7fhu-4jtg',
      'editable' => '2',
      'label' => 'Количество товаров',
      'group' => 'Дополнительно',
      'default' => '',
      'indexEnabled' => '1',
      'help' => '',
    ),
  ),
  'indexes' => 
  array (
  ),
);}

public function defaultBehaviours() {
	    $ret = parent::defaultBehaviours();
	    $ret[] = "eshop_group_behaviour";
		$ret[] = "Infuso\\Cms\\Reflex\\recordBehaviour";
	    return $ret;
	}

	public static function indexTest() {
	    return true;
	}

	public static function index_item($p) {
	    $item  = self::get($p["id"]);
	    tmp::param("activeGroupID",$item->id());
	    tmp::exec("eshop:group",$item,$p);
	}

	public function reflexMeta() {
	    return true;
	}

	public function reflexTitle() {
	    $title = trim($this->data("title"));
	    if(!$title)
			$title = "Группа товаров {$this->id()}";
	    return $title;
	}

	/**
	 * @return Возвращает коллекцию подгрупп, включая неактивные
	 **/
	public function subgroupsEvenHidden() {
	    return self::allEvenHidden()->eq("parent",$this->id());
	}

	/**
	 * @return Возвращает коллекцию активных подгрупп
	 **/
	public function subgroups() {
	    return self::all()->eq("parent",$this->id());
	}

	/**
	 * @return Возвращает коллекцию активных подгрупп всех уровней
	 **/
	public function subgroupsRecursive() {

	    $buf = array();
	    $groups = $this->subgroups()->limit(0);
	    while($groups->count()) {
	        $buf = array_merge($buf,$groups->idList());
	        $groups = eshop_group::all()->eq("parent",$groups->idList());
	    }
	    return eshop_group::all()->eq("id",$buf);
	}

	/**
	 * @return Возвращает коллекцию товаров в группе
	 **/
	public function items() {
	    return self::itemsEvenHidden()->eq("activeSys",1);
	}

	/**
	 * @return Возвращает коллекцию товаров в группе, включая скрытые товары
	 **/
	public function itemsEvenHidden() {
	    $key = "group-".($this->data("depth")+1);
	    return reflex::get("eshop_item")->eq($key,$this->id());
	}

	public function reflex_children() {
	    $ret = array (
	        $this->subgroupsEvenHidden()
				->title("Подразделы"),
	        $this->itemsEvenHidden()
				->title("Товары")
				->def("parent",$this->id())
				->param("sort",!$this->subgroups()->count()), // Сортируем товары только если в группе нет подгрупп
	    );
	    return $ret;
	}

	public function reflexParent() {
	    return self::get($this->data("parent"));
	}

	/**
	 * Возвращает группу первого уровня
	 **/
	public function level0() {
	    foreach($this->parents() as $parent)
	        if(!$parent->parent()->exists())
	            return $parent;
	    return $this;
	}

	/**
	 * Возвращает группу заданного уровня
	 **/
	public function level($level=0) {
	    foreach($this->parents() as $parent)
	        if($parent->depth()==$level)
	            return $parent;
	    return $this;
	}

	/**
	 * Возвращает глубину группы
	 * Группы верхнего уровня имеют глубину 0
	 **/
	public function depth() {
		return $this->data("depth");
	}

	/**
	 * Возвращает количество товаров в группе, используя сохраненное в таблице число
	 **/
	public function numberOfItems() {
	    return $this->data("numberOfItems");
	}

	/**
	 * Возвращает количество товаров в группе, используя сохраненное в таблице число
	 **/
	public function countItems() {
	    return $this->numberOfItems();
	}

	/**
	 * Возвращает количество подгрупп, используя сохраненное в таблице число
	 **/
	public function numberOfSubgroups() {
	    return $this->data("numberOfSubgroups");
	}

	public function reflex_beforeStore() {
	    $this->data("depth",sizeof($this->parents()));
	}

	public function handleStructureChanged() {
	
	    // Обновляем количество информации о товарах и подгруппах
		$this->updateSubgroupsNumber();
	    $this->updateItemsNumber();
	
		// Обновляем количество информации о товарах и подгруппах в подразделах
	    foreach($this->parents() as $group) {
	        $group->updateSubgroupsNumber();
	        $group->updateItemsNumber();
	    }

	    reflex_task::add("eshop_item","`parent`='{$this->id()}'","updateParentsChain","",100);
	    foreach($this->subgroupsRecursive() as $group) {
	        reflex_task::add("eshop_item","`parent`='{$group->id()}'","updateParentsChain","",100);
	    }
	}
	
	public function taskUpdateItems() {
	    return $this->handleStructureChanged();
	}

	public function afterStore() {
	    if($this->field("active")->changed() || $this->field("parent")->changed()) {
	        $this->taskUpdateItems();
	    }
	}

	public function afterDelete() {
	    foreach($this->parents() as $group) {
	        $group->updateSubgroupsNumber();
	        $group->updateItemsNumber();
	    }
	}

	/**
	 * Пересчитывает количество товаров в группе
	 **/
	public function updateItemsNumber() {
	    $this->data("numberOfItems",$this->items()->count());
	}

	/**
	 * Пересчитывает количество подгрупп
	 **/
	public function updateSubgroupsNumber() {
	    $this->data("numberOfSubgroups",$this->subgroups()->count());
	}

	/**
	 * Коллекция произвождителей в данной группе
	 **/
	public function vendors() {
	    $ids = $this->items()->distinct("vendor");
	    return eshop::vendors()->eq("id",$ids)->limit(0);
	}

	public function active() {
	    return $this->data("active");
	}

	public static function allEvenHidden() {
	    return reflex::get(get_class())->asc("priority")->param("sort",true);
	}

	public static function all() {
	    return self::allEvenHidden()->eq("active",1);
	}

	public static function get($id) {
	    return reflex::get(get_class(),$id);
	}

	public function reflexPublished() {
	    if(!$this->data("active")) {
	        return false;
	    }
	    return true;
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

}
