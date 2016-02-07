<?

namespace NDRA\Plugins;
use \Infuso\Core;

class Video {

    private $src;

    public function __construct($src) {
        $this->src = $src;
    } 
    
    public function player($width = 560, $height = 315) {         
        if(preg_match("/http(s)?\:\/\/www\.youtube\.com/", $this->src)){
            $url = \Infuso\Core\Url::get($this->src);
            $id = $url->query("v");
            return "<iframe width='{$width}' height='{$height}' src='http://www.youtube.com/embed/{$id}' frameborder='0' allowfullscreen ></iframe>";
        }         
    }
    
    public function iframeSrc() {         
        if(preg_match("/http(s)?\:\/\/www\.youtube\.com/", $this->src)) {
            $url = \Infuso\Core\Url::get($this->src);
            $id = $url->query("v");
            return "http://www.youtube.com/embed/{$id}";
        }         
    }
    
    /**
     * Возвращает превью видео
     **/         
    public function thumbnail() {
        if(preg_match("/http(s)?\:\/\/www\.youtube\.com/", $this->src)){
            $url = \Infuso\Core\Url::get($this->src);
            $id = $url->query("v");
            return "http://img.youtube.com/vi/{$id}/hqdefault.jpg";
        } 
    }

}
