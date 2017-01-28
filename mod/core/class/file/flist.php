<?

namespace infuso\core;

class FList implements \Iterator{

    // Итераторская шняга
    private $items = array();
    public function rewind() { reset($this->items); }
    public function current() { return current($this->items); }
    public function key() { return key($this->items); }
    public function next() { return next($this->items); }
    public function valid() { return $this->current() !== false; }
    public function asArray() { return $this->items; }

    public function __construct($items) {
        $this->items = $items;
    }
    
    public function length() {
        return sizeof($this->items);
    }
    
    public function count() {
        return $this->length();
    }

    public static function void() {
        return new self(array());
    }

    public function first() {
        $ret = $this->items[0];
        if(!$ret) {
			$ret = file::get("/");
		}
        return $ret;
    }
    
    /**
     * Фильтрует список, оставляя только папки
     **/
    public function folders() {
        $ret = array();
        foreach($this as $item) {
            if($item->folder()) {
                $ret[] = $item;
            }
        }
        return new self($ret);
    }

    /**
     * Фильтрует список, оставляя только файлы (не папки)
     **/
    public function files() {
        $ret = array();
        foreach($this as $item) {
            if(!$item->folder()) {
                $ret[] = $item;   
            }
        } 
        return new self($ret);
    }

    /**
     * Фильтрует список, оставляя только файлы заданного разширения
     **/
    public function ext($ext) {
        $ret = array();
        foreach($this as $item) {
            if($item->ext() == $ext) {
                $ret[] = $item;
            }
        }
        return new self($ret);
    }

    public function exclude($name) {
        $ret = array();
        foreach($this as $item) {
            if($item->name() != $name) {
                $ret[] = $item;
            }
        }
        return new self($ret);
    }

    /**
     * Возвращает сумму места, занимаемого файлами списка
     **/
    public function size() {
        $ret = 0;
        foreach($this as $file) {
            $ret += $file->size();
        }
        return $ret;
    }

    public static function sortFiles($a,$b) {
        $ret = $b->folder() - $a->folder();
        if($ret != 0) {
            return $ret;
        }
        return strcmp($a,$b);
    }

    public static function sortFilesByDate($a, $b) {
        $ret = $b->folder() - $a->folder();
        if($ret != 0) {
            return $ret;
        }
        $aStamp = $a->time()->stamp();
        $bStamp = $b->time()->stamp(); 
        return $bStamp - $aStamp;   
    }

    public function sort() {
        usort($this->items, array("self", "sortFiles"));
        return $this;
    }
    
    public function tsort() {
        usort($this->items, array("self", "sortFilesByDate"));
        return $this;
    }

}
