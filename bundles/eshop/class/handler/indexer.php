<?

namespace Infuso\Eshop\Handler;
use Infuso\Core;
use Infuso\Eshop\Model;

/**
 * Модель корзины (заказа) в интернет-магазине
 **/
class Indexer implements Core\Handler {

    /**
     * @handler = infusoDeploy    
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
            "method" => "indexStep",
        ));
    }
    
    public static function indexStep($params, $task) {
    
        $iterator = $task->data("iterator");
        $group = Model\Group::all()->gt("id", $iterator)->asc("id")->one();
        
        $userEnabled = $group->data("active");
    
        foreach($group->parents() as $parent) {
            if(!$parent->data("active")) {
                $userEnabled = false;
                break;
            }
        }    
        
        $group->data("user-enabled", $userEnabled);   
        
    }

}
