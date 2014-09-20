<?

namespace Infuso\Eshop1C;
use \Infuso\Core;

/**
 * Набор утилит для импорта товаров
 **/ 
class Utils extends Core\Component {

    private static $importCycle;

    /**
     * Импортирует товар
     * Создает товар, если товар не существует
     * Если товар существует, обновляет его данные
     **/
    public static function importItem($p) {
    
        if(!isset($p["active"])) {
            $p["active"] = 1;
        }
            
        $p["importCycle"] = self::importCycle();
        $item = \Infuso\Eshop\Model\Item::all()->eq("importKey",$p["importKey"])->one();
        
        if(!$item->exists()) {
            $item = service("ar")->create("infuso\\eshop\\model\\item",$p);
        }
        
        foreach($p as $key => $val) {
            $item->data($key,$val);
        }
            
        return $item;
    }

    /**
     * Импортирует группу товаров
     * Создает группу товаров, если группа не существует
     * Если группа существует, обновляет ее данные
     **/
    public static function importGroup($p) {
    
        if(!isset($p["active"])) {
            $p["active"] = 1;
        }
            
        $p["importCycle"] = self::importCycle();
        $group = \Infuso\Eshop\Model\Group::all()->eq("importKey",$p["importKey"])->one();
        
        if(!$group->exists()) {
            $group = service("ar")->create("infuso\\eshop\\model\\group",$p);
        }
            
        foreach($p as $key=>$val) {
            $group->data($key,$val);
        }
            
        return $group;
    }

    /**
     * Импортирует вендора
     **/
    public static function importVendor($p) {
    
        if(!isset($p["active"])) {
            $p["active"] = 1;
        }
            
        $vendor = eshop_vendor::allEvenHidden()->eq("importKey",$p["importKey"])->one();
        $p["importCycle"] = self::importCycle();
        
        if(!$vendor->exists()) {
            $vendor = reflex::create("eshop_vendor",$p);
        }

        foreach($p as $key=>$val) {
            $vendor->data($key,$val);
        }
            
        return $vendor;
    }

    /**
     * Начинает цикл импорта
     * Используется через роутер
     **/
    private static function newImportCycle() {
        $file = Core\File::get(Controller\Exchange::exchangeDir()."/cycle.txt");
        $file->put(\util::id());
    }

    /**
     * Начинает цикл импорта
     **/
    public static function importBegin() {
        self::newImportCycle();
    }

    /**
     * @return Возвращает идентицикатор цикла импорта - уникальную строку
     **/
    public static function importCycle() {
        if(!self::$importCycle) {
            self::$importCycle = Core\File::get(Controller\Exchange::exchangeDir()."/cycle.txt")->data();
        }
        return self::$importCycle;
    }

    /**
     * Завершает цикл импорта
     * Скрывает все элементы, которые не затронул импорт
     **/
    public static function importComplete() {
    
        service("ar")->storeAll();
        
        // Прячем все товары, которые не были импортированы
        \Infuso\Eshop\Model\Item::all()
            ->neq("importCycle", self::importCycle())
            ->data("active", 0);
        
        // Прячем все группы, которые не были импортированы
        \Infuso\Eshop\Model\Group::all()
            ->neq("importCycle",self::importCycle())
            ->data("active", 0);
        
    }

}
