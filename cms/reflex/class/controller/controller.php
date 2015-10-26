<?

namespace Infuso\Cms\Reflex;
use \user, \admin, \mod, \inx;

/**
 * Основной контроллер каталога
 **/
class Controller extends \Infuso\Core\Controller {

	public function controller() {
	    return "admin";
	}
	
    /**
     * Видимость для браузера
     **/
    public static function indexTest() {
        return user::active()->checkAccess("admin:showInterface");
    }

    /**
     * Разрешение для POST-команд
     **/
    public static function postTest() {
        return user::active()->checkAccess("admin:showInterface");
    }

    /**
     * Основной контроллер каталога
     **/
    public static function index($p) {
    	app()->tm("/reflex/main")->exec();
    }
    
    /**
     * Если не получилось войти - показываем страницу авторизации
     **/
    public static function indexFailed() {
        admin::fuckoff();
    }

    /**
     * Контроллер, возвращающий список элементов для ajax-запроса
     * @todo проверка безопасности   
     **/
    public function post_getItems($p) {
        
        $collection = Collection::unserialize($p["collection"]);
        $collection->applyParams($p);
        
        $tmp = app()->tm("/reflex/shared/collection/items/ajax")
            ->param("collection", $collection);
        
        $html.= $tmp->getContentForAjax();

        return array(
            "html" => $html,
		);
    
    }

    /**
     * Сохраняет объект
     **/
    public static function post_save($p) {
        $editor = Editor::get($p["index"]);
        if(!$editor->beforeEdit()) {
            app()->msg("Вы не можете редактировать этот объект", 1);
            return;
        }
        $editor->setData($p["data"]);
    }

    /**
     * Контроллер создания конструктора
     * @todo проверка безопасности     
     **/
    public static function post_create($p) {
    
        $collection = Collection::unserialize($p["collection"]);

        // Создаем конструктор элемента
        $item = mod::service("ar")->create(Model\Constructor::inspector()->className(),array(
            "collection" => $collection->serialize(),
            "redirect" => $p["redirect"],
        ));

		$editor = new Model\ConstructorEditor($item->id());
		$url = $editor->url();

        return $url;
    }

    /**
     * Контроллер создания элемента из конструктора
     * @todo проверка безопасности     
     **/
    public static function post_createItem($p) {

		$constructor = new Model\ConstructorEditor($p["constructorId"]);
		$editor = $constructor->item()->createItem($p["data"]);
		
		if($editor->item()->exists()) {
        	return $constructor->item()->data("redirect");
		}

    }

    /**
     * Контроллер закачивания файла
     * @todo какой-то из контроллеров лишний
     **/
    public function post_uploadCreate($p) {
        $collection = Collection::unserialize($p["collection"]);
        $item = $collection->collection()->create();
        $editor = $item->plugin("editor");
        $field = $editor->fileField();
        $file = $item->storage()->addUploaded($_FILES["file"]["tmp_name"], $_FILES["file"]["name"]);
        $item->data($field, $file);
    }

    /**
     * Контроллер закачивания файла
     * @todo какой-то из контроллеров лишний
     **/
    public static function post_upload($p,$files) {
        $list = self::getListByP($p);

        if(!$list->editor()->beforeCreate(array())) {
            app()->msg("У вас нет прав для создания объекта",1);
            return;
        }

        $item = $list->create();
        $editor = $item->editor();
        $file = $_FILES["file"];

        $ret = $editor->uploadFileIntoItem( array (
            "tmpName" => $file["tmp_name"],
            "name" => $file["name"]
        ));

        if(!$ret) {
            app()->msg("Создание объекта из файла недоступно. Попробуйте добавить объект.",1);
            $item->delete();
        }

    }

    /**
     * Контроллер удаления объекта
     **/
    public static function post_delete($p) {
        foreach($p["items"] as $id) {
            $editor = Editor::get($id);
            $editor->delete();
        }
    }

    /**
     * Контроллер перемещения на одну позицию вверх
     **/
    public static function post_moveUp($p) {
        $list = self::getListByP($p)->limit(0);
        $name = $list->param("*priority");

        if(!$list->param("sort") || !$name) {
            app()->msg("Сортировка этого списка не включена",1);
            return;
        }

        foreach($list as $item) {
            if(!$item->editor()->beforeEdit()) {
                app()->msg("У вас нет прав для изменения объекта",1);
                return;
            }
        }

        $itemID = self::get($p["itemID"])->item()->id();
        foreach($list->copy() as $key=>$item) {
            $key*=2;
            if($item->id()==$itemID) {
                $key-=$p["side"]==1 ? -3 : 3;
            }
            $item->data($name,$key);
        }
    }

    /**
     * Контроллер сохранения сортировки элементов
     * Вызывается после перетаскивания объектов в каталоге
     **/
    public static function post_savePriority($p) {
    
        $collection = Collection::unserialize($p["collection"])->collection();
        $pages = $collection->pages();

        // Поле, по которому будет производиться сортировка
        $name = $collection->param("*priority");
        if(!$collection->param("sort") || !$name) {
            app()->msg("Сортировка этого списка не включена",1);
            return;
        }

        $n = 0;

        $idList = array();
        foreach($p["priority"] as $editorParam) {
            $editor = Editor::get($editorParam);
            $idList[] = $editor->itemID();
        }
        
        // Проходим по всем страницам коллекции
        // и назначаем элементам приоритет в том порядке в котором они встретились нам
        // Если мы на странице, которую отсортировал пользователь,
        // Назначаем коллекции приоритет элементам методом setPrioritySequence
        for($i = 1; $i <= $pages; $i++) {

            $collectionPage = $collection->copy()->page($i);

            if($i == $p["page"]) {
                $collectionPage->setPrioritySequence($idList);
            }

            foreach($collectionPage as $item) {
                $item->data($name,$n);
                $n++;
            }
        }
        
        app()->msg("Сортировка изменена");

    }

    /**
     * Контроллер команды "Вставить"
     **/
    public static function post_paste($p) {

        $list = self::getListByP($p);
        $eqs = $list->eqs();

        foreach($p["items"] as $itemHash) {

            $editor = self::get($itemHash);
            $item = $editor->item();

            if($editor->beforeEdit()) {

                if(get_class($item)!=$list->itemClass()) {
                    app()->msg("Выбранный объект нельзя вставить в этот список.",1);
                    return;
                }

                foreach($eqs as $key=>$val)
                    $item->data($key,$val);

                if($item->testForParentsRecursion()) {
                    app()->msg("Рекурсия",1);
                    $item->revert();
                }

            } else {

                app()->msg("У вас нет прав для изменения объекта",1);

            }
        }
    }

	/**
	 * Возвращает массив url для редактирования переданного массива элементов
	 **/
	public function post_getEditUrls($p) {
	    $ret = array();
	    foreach($p["items"] as $editor) {
	        $editor = Editor::get($editor);
	        $ret[] = $editor->url();
	    }
	    return $ret;
	}
	
	/**
	 * Возвращает массив url для просмотра переданного массива элементов
	 **/
	public function post_getViewUrls($p) {
	    $ret = array();
	    foreach($p["items"] as $editor) {
	        $editor = Editor::get($editor);
	        $ret[] = $editor->item()->url();
	    }
	    return $ret;
	}

}
