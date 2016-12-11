<?

namespace Infuso\Cms\Search;
use \infuso\Core;

/**
 * Служба поиска
 **/
class Service extends Core\Service {

    public function defaultService() {
        return "search";
    }
    
    public function indexRecord($record, $cycle) {
    
        $params = $record->searchContent();
        if(!is_array($params)) {
            $params = array(
                "content" => $params,
            );
        }
        
        // Если отсутствует контент для поиска - выходим
        if(!$params["content"]) {
            return;
        }
        
        $key = get_class($record).":".$record->id();
        $index = Model\Index::all()->eq("key", $key)->one();
        
        $data = array(
            "content" => $params["content"],
            "priority" => $params["priority"],
            "datetime" => \util::now(),
            "cycle" => $cycle,
            "key" => $key,
        ); 
        
        if(!$index->exists()) {
            service("ar")->create(Model\Index::inspector()->className(), $data);
        } else {
            foreach($data as $key => $val) {
                $index->data($key, $val);
            }
        }
        
    }
    
    public function cleanup($cycle) {
        Model\Index::all()->neq("cycle", $cycle)->delete();
    }
    
    public function query($query) {
        return Model\Index::all()->match("content", '"'.$query.'"');
    }

}
