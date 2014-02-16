<?

class seotools_slowLoad extends reflex implements mod_handler {

    

public static function recordTable() {return array (
  'name' => 'seotools_slowLoad',
  'fields' => 
  array (
    0 => 
    array (
      'name' => 'id',
      'type' => 'jft7-kef8-ccd6-kg85-iueh',
      'editable' => '1',
      'id' => 'lk6g27i3zry7o6ij409urtgn3biwm5',
    ),
    1 => 
    array (
      'name' => 'loaded',
      'type' => 'x8g2-xkgh-jc52-tpe2-jcgb',
      'editable' => '1',
      'id' => 'wfujvc3qgkyyae28hy3xa95rqdc1fa',
      'indexEnabled' => 1,
    ),
    2 => 
    array (
      'name' => 'url',
      'type' => 'v324-89xr-24nk-0z30-r243',
      'editable' => '1',
      'id' => 'clcuvv3zyv7qo6cycygpcibacybe8e',
      'indexEnabled' => 1,
    ),
    3 => 
    array (
      'name' => 'content',
      'type' => 'kbd4-xo34-tnb3-4nxl-cmhu',
      'editable' => '1',
      'id' => 'wqgfsda61cyum0fw6k2m64ym6kqltw',
      'indexEnabled' => 1,
    ),
    4 => 
    array (
      'name' => 'headers',
      'type' => 'v324-89xr-24nk-0z30-r243',
      'editable' => '1',
      'id' => 'pr4yzi6op4i385ij65u70xwwhso85j',
      'label' => 'Заголовки',
      'indexEnabled' => 1,
    ),
  ),
  'indexes' => 
  array (
  ),
);}

public static function get($url,$headers="") {
        return self::all()->eq("url",$url)->eq("headers",$headers)->one();
    }
    
    public static function all() {
        return reflex::get(get_class());
    }
    
    public static function load($url,$headers="") {
        $page = self::get($url,$headers);
        if(!$page->exists()) {
            $page = reflex::create(get_class(),array(
                "url" => $url,
                "headers" => $headers,
            ));
        }
        return $page;
    }
    
    public static function loadOne() {
        $page = self::all()->asc("loaded")->lt("loaded",util::now()->shift(-3600*24))->one();
        $page->doLoad();
    }
    
    public function reflex_beforeCreate() {
        // Указываем что страница загружена 10 лет назад
        $this->data("loaded",util::now()->shift(-3600*24*365*10));
    }
    
    /**
     * Загружает содержимое
     **/
    private function doLoad() {
    
        if(!$this->exists())
            return;
            
        $opts = array(
            "http"=>array(
                "method" =>"GET",
                "header" => $this->data("headers"),
            ),
        );    
                
        $context = stream_context_create($opts);  
            
        $contents = file_get_contents($this->data("url"),false,$context);
        
        $this->data("content",$contents);
        $this->data("loaded",util::now());
    }
    
    public function on_mod_cron() {
        self::loadOne();
    }

}
