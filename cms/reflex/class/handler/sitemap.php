<?

namespace Infuso\Cms\Reflex\Handler;
use Infuso\Cms\Reflex\Model;

use Infuso\Core;

class Sitemap extends Core\Component implements Core\Handler {
	
	
	/**
	 * @handler = infuso/deploy
	 **/
	public function onDeploy() {        
        service("task")->add(array(
            "class" => get_class(),
            "method" => "createSitemap",
            "crontab" => "0 0 * * *",
            "randomize" => 120,
            "title" => "Ставит задачу на создание карты сайта карты сайта",
        ));

	}
    
    /**
     * Ставит задачу создания карты классов
     **/
    public static function createSitemap() {      
        service("task")->add(array(
            "class" => get_class(),
            "method" => "sitemapIterator",
            "title" => "Итератор карты сайта",
            "crontab" => "* * * * *",     
        ));    
    }
    
    public static function tmpPath() {
        return Core\File::get(app()->varPath()."/sitemap.xml");
    }
    
    public static function destPath() {
        return Core\File::get(app()->publicPath()."/sitemap.xml");
    }
    
    public static function begin() {     
        $xml = "";
        $xml .= '<'.'?xml version="1.0" encoding="UTF-8" ?'.'>'."\n";
        $xml .= '<urlset xmlns="http://www.sitemaps.org/schemas/sitemap/0.9">'."\n";     
        $path = self::tmpPath();
        Core\File::get($path)->put($xml);
    }
    
    public static function item($item) {
        $url = app()->url()->scheme()."://".app()->url()->domain().$item->url();             
        $xml = '<url><loc>'.$url.'</loc></url>'."\n";        
        $fp = fopen(self::tmpPath()->native(), 'a');
        fwrite($fp, $xml);
    }
    
    public static function end() {   
        $xml = '</urlset>';
        $path = self::tmpPath();
        $fp = fopen(self::tmpPath()->native(), 'a');
        fwrite($fp, $xml);
        Core\File::get($path)->rename(self::destPath());
    }
    
    
    /**
     * Итерация создания карты сайта
     **/
    public static function sitemapIterator($params, $task) {
    
        $iterator = $task->data("iterator");
        $collectionId = $task->extra("collection") ?: 0;
        $fromId = $task->extra("id") ?: 0;
        
        if($iterator == 0 && $collectionId == 0 && $fromId == 0) {
            self::begin();
        }
        
        $event = new \Infuso\CMS\Reflex\Event\Sitemap();
        if(!$event->firepartial($iterator)) {
            $task->data("completed", true);
            self::end();
            return;
        }

        if($collectionId > sizeof($event->collections()) - 1) {        
            $task->data("iterator", $iterator + 1);
            $task->extra("collection", 0);
            $task->extra("id", 0);  
            return;       
        }                                          
        
        $collection = $event->collections()[$collectionId];
        $collection->asc("id");
        $collection->gt("id", $fromId);
        $collection->limit(10);
        
        $id = null;
        foreach($collection as $item) {
            $id = $item->id();
            self::item($item);
        }
        
        if($id === null) {
            $task->extra("collection", $collectionId + 1);
            $task->extra("id", 0);  
            return;
        }
        
        $task->extra("id", $id);
        
    }
	
}
