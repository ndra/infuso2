<?

namespace Infuso\Site\Controller;
use Infuso\Core;

/**
 * Дефолтный контроллер Сайта
 **/
class TimepadAPI extends Core\Controller {

	public function indexTest() {
	    return true;
	}
    
    private static $defaultCategory = 223;
    private static $catMap = array(
        1   => 217,     // Мани-мани -> Бизнес
        2   => 399,     // Здорово живешь -> Красота и здоровье
        3   => 399,     // Красивая жизнь -> Красота и здоровье
        4   => 462,     // Звёзды ситикласс -> Другие события
        7   => 452,     // С комьютером на ты -> ИТ и Интернет
        8   => 453,     // Про любовь -> Психология и самопознание
        9   => 462,     // Нельзя пропустить -> Другие события
        10  => 456,     // Гастрономические страсти -> Еда
        12  => 453,     // Перейдем на личность -> Психология и самопознание
        13  => 217,     // Бизнес и карьера -> Бизнес
        14  => 379      // Дети -> Для детей
    );
    
    /**
     * Веб-хук, уведомляющий о регистрации на событие
     **/
    public function index_ticket() {
        
        // Читаем содержимое POST-запроса
        $body = @file_get_contents("php://input");
        // Генерируем код, которым должен быть подписан webhook
        $sha1 = hash_hmac('sha1', $body, '78huPVizCInd');
        
        // Сравниваем полученый код подписи, с тем что пришёл с хуком
        if ("sha1={$sha1}" == $_SERVER['HTTP_X_HUB_SIGNATURE']) {
            // webhook пришёл от сервиса Timepad
            $data = json_decode($body, true);
            app()->trace(array(
                "type" => "timepad-reg",
                "message" => var_export($data, 1),
            ));
            
            if(in_array($data["status_raw"], array("paid", "paid_offline"))) {
                app()->fire("timepad/paid", $data);
            }
            
        } else {
            app()->trace(array(
                "text" => "Ошибка веб-хука таймпэд. Подпись не верна.",
                "type" => "error",
            ));
        }

    }
    
    /**
     * Контроллер, возвращающий промокоды
     *используется таймпэдом
     **/
    public function index_promocodes($p) {
    
        $limit = $p["limit"] ? : 20;
        $page = $p["page"] ? : 1;
        
        $promocodes = \Infuso\Site\Model\Promocode::all()->asc("id");
        $promocodes->limit($limit);
        $promocodes->page($page);
        
        $data = array();
        $data["total"] = $promocodes->count();
        $data["page"] = $promocodes->page();
        $data["pages"] = $promocodes->pages();
        $data["limit"] = $limit;
        $n = 0;
        $items = array();
        foreach($promocodes as $promocode) {
            $item = array();
            $item["id"] = $promocode->id();
            $item["code"] = $promocode->data("code");
            $item["valid"] = $promocode->pdata("valid")->format("Y-m-d H:i:s");
            if (strpos($promocode->data("discount"), "%") === false) { 
                $item["discount_type"] = "руб";
                $item["discount_value"] = $promocode->data("discount");  
                
            } else {
                $item["discount_type"] = "%";
                $item["discount_value"] = substr($promocode->data("discount"), 0, strpos($promocode->data("discount"), "%")); 
            }
            $item["reusable"] = $promocode->data("reusable");
            $item["used"] = $promocode->data("used");
            $item["created"] = $promocode->pdata("created")->format("Y-m-d H:i:s");
            $item["updated"] = $promocode->pdata("updated")->format("Y-m-d H:i:s");
            $items[] = $item;
            $n++;    
        }
        $data["on_page"] = $n;
        $data["promocodes"] = $items;        
        
        header('content-type: application/json; charset=utf-8');
        echo json_encode($data);         

    }
    
}
