<?

namespace Infuso\Cms\Preview;

class Handler implements \Infuso\Core\Handler {

    /**
     * @handler = infuso/deploy
     **/         
    public function onInit() {
        service("task")->add(array(
            "class" => get_class(),
            "method" => "cleanupStep",
            "crontab" => "* * * * *",
            "randomize" => 60,
        ));
    }
    
    /**
     * Очишает одну папку с превьюшками
     **/
    public static function cleanupStep($params, $task) {
    
        $iterator = $task->data("iterator");
        $group = str_pad(dechex($iterator % 256), 2, 0, STR_PAD_LEFT);
        $path = \Infuso\Core\File::get(app()->publicPath()."/preview/$group/");
        
        // Удаляем в папке все файлы старше 60 дней
        $now = \Infuso\Util\Util::now()->stamp();
        $left = false;
        foreach($path->dir() as $file) {
            $age = ($now - $file->time()->stamp()) / 24 / 3600;
            if($age > 60) {
                $file->delete();
            } else {
                $left = true;
            }
        }
        
        // Если все файлы удалены, удаляем папку
        if(!$left) {
            $path->delete();
        }
        
        // Обновляем задачу   
        $task->data("iterator", $task->data("iterator") + 1);
        $task->data("title", "Очистка превьюшек (".$path.")");
    }

}
