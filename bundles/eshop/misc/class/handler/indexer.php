<?

namespace Infuso\Eshop\Handler;
use Infuso\Core;
use Infuso\Eshop\Model;

/**
 * Модель корзины (заказа) в интернет-магазине
 **/
class Indexer implements Core\Handler {

    const TYPE_GROUP = 0;
    const TYPE_ITEM = 1;
    
    /**
     * @handler = infuso/deploy    
     **/         
    public static function onDeploy() {
        service("task")->add(array(
            "class" => get_class($this),
            "method" => "createTask",
            "crontab" => "0 * * * *",
        ));
    }
    
    public static function createTask() {
        service("task")->add(array(
            "class" => get_class($this),
            "method" => "iteratorStep",
        ));
    }
    
    
     /**
     * Получаем предельное кол-во итераций за шаг   
	 * если не задано, ставим 10
     **/ 
    public static function iteratorSpeedMode() {
        $speed = service("conf")->get("components", "infuso\\eshop\\handler\\indexer", "speed");
        
        if(!$speed) {
            $speed = 10;    
        }
        
        return $speed;
    }
    
     /**
     * Прогоняем индексатор пока задача не будет выполнена 
     **/ 
    public static function iteratorStep($params, $task) {
        
        for ($step=0; $step<self::iteratorSpeedMode(); $step++){
            
            if($task->data("completed")){
                break;    
            }
            
            self::indexStep($params, $task);          
        }
    }
    
    public static function indexStep($params, $task) {
        $iterator = $task->data("iterator");
        
        switch($task->pdata("internalParams")["phase"]) {
        
            // Отмечаем отключенные пользователем группы
            default:
			
                if($iterator == 0) {
                    service("ar")
                        ->collection(Model\Index::inspector()->className())
                        ->delete();
                }
            
                $group = Model\Group::all()->gt("id", $iterator)->asc("id")->one();
                
                if(!$group->exists()) {
                    $params = $task->pdata("internalParams");
                    $params["phase"] = "activate-items";
                    $task->data("internalParams", $params);
                    $task->data("iterator", 0);
                    return;
                }
                
                $status = $group->data("active") ? Model\Group::STATUS_ACTIVE : Model\Group::STATUS_USER_DISABLED;
            
                foreach($group->parents() as $parent) {
                    if(!$parent->data("active")) {
                        $status = Model\Group::STATUS_USER_DISABLED;
                        break;
                    }
                }   
                
                service("ar")->create(Model\Index::inspector()->className(), array(
                    "itemId" => $group->id(),
                    "type" => self::TYPE_GROUP,
                    "status" => $status
                ));
				
                $iterator = $group->id();
                $task->data("iterator", $iterator); 
                break;

            // Обновляем статус товаров
            case "activate-items":
                $item = Model\Item::all()->gt("id", $iterator)->asc("id")->one();
                
                if(!$item->exists()) {
                    $params = $task->pdata("internalParams");
                    $params["phase"] = "count-items";
                    $task->data("internalParams", $params);
                    $task->data("iterator", 0);
                    return;
                }
                
                $groupIndex = Model\Index::all()
                ->eq("type", self::TYPE_GROUP)
                ->eq("itemId", $item->group()->id())
                ->one();
                    
                $status = $item->data("active") ? Model\Item::STATUS_ACTIVE : Model\Item::STATUS_USER_DISABLED;        
                                   
                if(!$item->group()->exists()) {
                    $status = Model\Item::STATUS_DETACHED;
                } elseif($groupIndex->data("status") != Model\Group::STATUS_ACTIVE) {
                    $status = $groupIndex->data("status");
                }
                
                $item->data("status", $status);
                $iterator = $item->id();
                $task->data("iterator", $iterator); 
                break;
                
            case "count-items":
                $group = Model\Group::all()->gt("id", $iterator)->asc("id")->one();
                
                $groupIndex = Model\Index::all()
                    ->eq("type", self::TYPE_GROUP)
                    ->eq("itemId", $group->id())
                    ->one();
                
                if(!$group->exists()) {
                    $task->data("completed", 1);
                    return;
                }   
                
                $status = $groupIndex->data("status");
                
                $count = $group->itemsRecursive()
                    ->eq("status", Model\Item::STATUS_ACTIVE)
                    ->count();
                    
                $group->data("numberOfItems", $count);
                
                if($count == 0) {
                    $status = Model\Group::STATUS_VOID;
                } 
                
                $group->data("status", $status);
                $iterator = $group->id();
                $task->data("iterator", $iterator);   
                                                 
                break;          
        }
    }

}
