<?

namespace Infuso\Cms\Reflex\Model;
use Infuso\Core;
use Infuso\ActiveRecord;

/**
 * Модель метаданных
 **/
class Meta extends ActiveRecord\Record {

	public static function model() {
		return array (
		  'name' => get_class(),
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
		    ),  array (
				'name' => 'title',
				'type' => 'kbd4-xo34-tnb3-4nxl-cmhu',
				'editable' => '1',
				'label' => 'Заголовок браузера &lt;title&gt;',
		    ), array (
				'name' => 'head',
				'type' => 'textarea',
				'editable' => true,
				'label' => '&lt;HEAD&gt;',
		    ),array (
				'name' => 'keywords',
				'type' => 'kbd4-xo34-tnb3-4nxl-cmhu',
				'editable' => '1',
				'label' => 'Keywords',
		    ), array (
				'name' => 'description',
				'type' => 'kbd4-xo34-tnb3-4nxl-cmhu',
				'editable' => '1',
				'label' => 'Description',
		    ), array (
				'name' => 'noindex',
				'type' => 'fsxp-lhdw-ghof-1rnk-5bqp',
				'editable' => '1',
				'label' => 'Не индексировать',
				'help' => 'Добавляет мета-тэг NOINDEX в шапку страницы и запрещает ее к индексации в поисковых системах.',
		    ),
		  ),
		);
	}

	/**
	 * Возвращает коллекцию всех объектов метаданных
	 **/
	public static function all() {
		return service("ar")->collection(get_class());
	}

	/**
	 * Возвращает объект метаданных по хэшу 
	 **/
	public static function get($hash) {
		return self::all()->eq("hash",$hash)->one();
	}

	/**
	 * Возвращает элемент reflex, связанный с этим объектом метаданных
	 **/
	public function item() {
	    list($class,$id) = explode(":", $this->data("hash"));
	    return service("ar")->get($class,$id);
	}

	/**
	 * Подготовка объекта метаданных к сохранению
	 **/
	public function beforeStore() {

	    // Ссылки
	    $links = preg_replace("/\s*\,\s*/", ",", $this->data("links"));
	    $links = preg_replace("/\s+/", " ", $links);
	    $links = mb_strtolower($links,"utf-8");
	    $links = \Infuso\Util\Util::splitAndTrim($links, ",");
	    $this->data("links", ",".implode(",",$links).",");

		// Удаляем избыточные меты
	    $this->unnecessary()->delete();

	    // На всякий случай, восстанавливаем хэш
		$this->data("hash", get_class($this->item()).":".$this->item()->id());
        
	}
    
    public function afterStore() {
        app()->fire("reflex/meta-changed", array(
            "item" => $this->item(),
            "meta" => $this->data(),
            "metaObject" => $this,
        ));
    }

	/**
	 * Возвращает список "лишних" метаданных.
	 * Лишние метаданные - те для которых хэш и язык совпадают
	 * Этот список используется для удаления лишних метаданных
	 **/
	public function unnecessary() {
	    return self::all()
			->eq("hash",$this->data("hash"))
			->neq("id",$this->id());
	}

}
