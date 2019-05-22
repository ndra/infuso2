<?

namespace Infuso\Site\Handler;
use Infuso\Core;

/**
 * Хэндлер для всяких штук
 **/
class Handler implements Core\Handler {

    /**
     * @handler = infuso/deploy
     **/
    public function onDeploy() {
    
        service("task")->add(array(
            "class" => get_class(),
            "method" => "dailyTask",
            "crontab" => "0 0 * * *",
            "randomize" => 60 * 5,
        ));
        
        service("task")->add(array(
            "class" => get_class(),
            "method" => "downloadCurrencyRates",
            "crontab" => "0 13 * * *",
        ));
    
    
    }
    
    public static function dailyTask() {
    
        service("task")->add(array(
            "class" => "\Infuso\Site\Model\BatteryCalculator\Cell",
            "method" => "updateMeta",
        ));

    }
    
    /**
     * Скачивает курс доллара с ЦБРФ и заносит в базу
     **/
    public static function downloadCurrencyRates() {
    
        $xml = simplexml_load_file("http://www.cbr.ru/scripts/XML_daily.asp");
        foreach($xml->xpath("//Valute[CharCode='USD']") as $valute) {
            $date = explode(".", $xml->attributes()["Date"]);
            $date = $date[2]."-".$date[1]."-".$date[0];
            $item = \Infuso\Site\Model\CurrencyRate::all()->eq("date", $date)->one();
            if(!$item->exists()) {
                $item = service("ar")->create("\Infuso\Site\Model\CurrencyRate", array(
                    "date" => $date,
                    "rate" => $valute->Value,
                ));
            }
        }

    }

}
