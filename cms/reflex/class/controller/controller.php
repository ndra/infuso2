<?

namespace Infuso\Cms\Reflex;
use \user, \admin, \mod, \inx;

/**
 * Основной контроллер каталога
 **/
class Controller extends \Infuso\Core\Controller {

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
    	\Infuso\Template\Tmp::exec("/reflex/main");
    }
    
    /**
     * Если не получилось войти - показываем страницу авторизации
     **/
    public static function indexFailed() {
        admin::fuckoff();
    }
    
    /**
     * Контроллер, возвращающий список элементов для ajax-запроса
     **/
    public function post_getItems($p) {
    
        $collection = Collection::unserialize($p["collection"]);
        $collection->applyParams($p);
        $tmp = $collection->itemsTemplate();
        $html = $tmp->getContentForAjax();
        
        return array(
            "html" => $html,
		);
    
    }

    /**
     * Сохраняет объект
     **/
    public static function post_save($p) {
    
        $editor = Editor::get($p["index"]);
        $item = $editor->item();
        $editor->setData($p["data"]);

    }


    /**
     * Контроллер создания конструктора
     **/
    public static function post_create($p) {
    
        $collection = Collection::unserialize($p["collection"]);

        // Создаем конструктор элемента
        $item = mod::service("ar")->create(Model\Constructor::inspector()->className(),array(
            "collection" => $collection->serialize(),
        ));

		$editor = new Model\ConstructorEditor($item->id());
		$url = $editor->url();

        return $url;
    }

    /**
     * Контроллер создания элемента из конструктора
     **/
    public static function post_createItem($p) {

		$constructor = new Model\ConstructorEditor($p["constructorId"]);
		$editor = $constructor->item()->createItem($p["data"]);
		
		mod::msg($editor->item()->data());
		
        return $editor->url();

    }

    /**
     * Контроллер закачивания файла
     **/
    public static function post_upload($p,$files) {
        $list = self::getListByP($p);

        if(!$list->editor()->beforeCreate(array())) {
            mod::msg("У вас нет прав для создания объекта",1);
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
            mod::msg("Создание объекта из файла недоступно. Попробуйте добавить объект.",1);
            $item->delete();
        }

    }

    /**
     * Контроллер удаления объекта
     **/
    public static function post_delete($p) {

        foreach($p["ids"] as $id) {

            $editor = self::get($id);
            $item = $editor->item();

            if($editor->beforeEdit()) { // Проверяем возможность удаления объекта

                $item->log("Объект {$item->title()} удален");
                if(get_class($item)!="reflex_editor_trash") {
                    $trash = reflex::create("reflex_editor_trash",array(
                        "title" => $item->title(),
                        "data" => json_encode($item->data()),
                        "meta" => json_encode($item->metaObject()->data()),
                        "img" => $item->editor()->img(),
                        "class" => get_class($item),
                    ));
                }
                $item->metaObject()->delete();
                $item->delete();
            } else {
                mod::msg("У вас нет прав для удаления этого объекта",1);
            }
        }
    }

    /**
     * Контроллер перемещения на одну позицию вверх
     **/
    public static function post_moveUp($p) {
        $list = self::getListByP($p)->limit(0);
        $name = $list->param("*priority");

        if(!$list->param("sort") || !$name) {
            mod::msg("Сортировка этого списка не включена",1);
            return;
        }

        foreach($list as $item) {
            if(!$item->editor()->beforeEdit()) {
                mod::msg("У вас нет прав для изменения объекта",1);
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
    public static function post_sortItems($p) {

        $collection = self::getListByP($p);
        $pages = $collection->pages();

        // Поле, по которому будет производиться сортировка
        $name = $collection->param("*priority");
        if(!$collection->param("sort") || !$name) {
            mod::msg("Сортировка этого списка не включена",1);
            return;
        }

        $n = 0;

        $idList = array();
        foreach($p["priority"] as $editorParam) {
            $editor = self::get($editorParam);
            $idList[] = $editor->itemID();
        }

        // Проходим по всем страницам коллекции
        // и назначаем элементам приоритет в том порядке в котором они встретились нам
        // Если мы на странице, которую отсортировал пользователь,
        // Назначаем коллекции приоритет элементам методом setPrioritySequence
        for($i=1;$i<=$pages;$i++) {

            $collectionPage = $collection->copy()->page($i);

            if($i==$p["page"]) {
                $collectionPage->setPrioritySequence($idList);
            }

            foreach($collectionPage->editors() as $editor) {
                $editor->item()->data($name,$n);
                $n++;
            }
        }

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
                    mod::msg("Выбранный объект нельзя вставить в этот список.",1);
                    return;
                }

                foreach($eqs as $key=>$val)
                    $item->data($key,$val);

                if($item->testForParentsRecursion()) {
                    mod::msg("Рекурсия",1);
                    $item->revert();
                }

            } else {

                mod::msg("У вас нет прав для изменения объекта",1);

            }
        }
    }

    /**
     * Контроллер, возвращающий полный список элементов коллекции
     * @todo Надо возвращать сериализованныю колекцию, а не список id (и на клиенте учитывать ее)
     **/
    public static function post_getAll($p) {

        $list = self::getListByP($p);

        $ids = $list->limit(0)->idList();

        return array(
            "ids" => $ids,
            "class" => $list->itemClass(),
        );

    }

    /**
     * Контроллер получения лога для данного объекта
     **/
    public static function post_log($p) {

        $items = self::get($p["index"])->item()->getLog();

        $ret = array();

        foreach($items as $item) {
            $txt = "";
            $txt.= "<div style='font-size:11px;opacity:.5;' >";
            $txt.= $item->pdata("user")->title()." / ".$item->pdata("datetime")->txt();
            $txt.= "</div>";

            $inject = $item->data("comment") ? " style='border-radius:10px;border:1px solid #ccc;padding:5px;' " : "";
            $txt.= "<div $inject>".$item->msg()."</div>";
            $ret[] = array(
                "text" => $txt,
            );
        }

        return $ret;

    }

    /**
     * Контроллер комментирования
     **/
    public static function post_comment($p) {
        $editor = self::get($p["index"]);
        if(!$editor->beforeEdit()) {
            mod::msg("Вы не можете оставлять комментарии для данного объекта",1);
            return;
        }
        $editor->item()->log($p["txt"],array("comment"=>true));
    }

    /**
     * Контроллер выполнения экшна
     **/
    public static function post_doAction($p) {
        $editor = self::get($p["id"]);
        if(!$editor->beforeEdit()) {
            mod::msg("Вы не можете редактировать данный объект",1);
            return;
        }
        call_user_func(array($editor,"action_$p[action]"));
    }

}
