<?

class seotools_rewrite extends reflex {

    

public static function reflex_table() {return array (
  'name' => 'seotools_rewrite',
  'fields' => 
  array (
    0 => 
    array (
      'name' => 'id',
      'type' => 'jft7-kef8-ccd6-kg85-iueh',
      'editable' => '1',
      'id' => 'tp1bdf1rxk1rt8lioku6jka638lbqm',
    ),
    1 => 
    array (
      'name' => 'original',
      'type' => 'v324-89xr-24nk-0z30-r243',
      'editable' => '1',
      'id' => 'e27wv6q41sxpa2tkl0nkvi3y5ijm5h',
      'label' => 'Оригинал',
      'indexEnabled' => 0,
    ),
    2 => 
    array (
      'name' => 'replacement',
      'type' => 'v324-89xr-24nk-0z30-r243',
      'editable' => '1',
      'id' => '0jw1zt89hdyvbn41itmu2jy9hjyarn',
      'label' => 'Замена',
      'indexEnabled' => 0,
    ),
  ),
  'indexes' => 
  array (
  ),
);}

public static function get($id) {
        return reflex::get(get_class(),$id);
    }
    
    public static function all() {
        return reflex::get(get_class());
    }
    
    public static function normalizeText($text) {
        $text = util::str($text);
        $text = $text->text();
        $text = $text->removeDuplicateSpaces();
        $text = trim($text);
        return $text;
    }
    
    /**
     * Включае управление реврайтом (при нажатии ctrl+r появится окно)
     **/
    public function inc() {
    
        if(mod_superadmin::check()) {
            tmp::jq();
            mod::coreJS();
            tmp::js("/seotools/res/rewrite.js");
        }
        
    }
    
    public static function replace($text,$debug=false) {
    
        if(!mod_superadmin::check()) {
            $debug = false;
        }
    
        foreach(self::all()->limit(0) as $replace) {
        
            $original = $replace->data("original");
            $replacement = $replace->data("replacement");
            
            if($debug)
                $replacement = "<span style='background:yellow;' title='{$original}' >".$replacement."</span>";
        
            $text = strtr( $text,
                array (
                    $original => $replacement,
                ));
        }
        
        return $text;
    
    }

}
