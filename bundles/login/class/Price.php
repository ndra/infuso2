<?

namespace Infuso\Site;
use Infuso\Core;

/**
 * Курсы валют
 **/
class Price extends \Infuso\Core\Component {

    private $usg;
    
    public function __construct($usd) {
        $this->usd = $usd;
    }

    public static function USDtoRUR() {
    
        $rates = array();
        foreach(Model\CurrencyRate::all()->limit(3) as $rate) {
            $rates[] = $rate->data("rate");
        }
        $rate =  array_sum($rates) / count($rates);
        return $rate;
    }
    
    public function usd() {
        return $this->usd;
    }
    
    public function rur() {
        return $this->usd * self::USDtoRUR();
    }
    
    public function rurTxt() {
        $d = round($this->rur());
        return number_format($d, 0, ".", "&thinsp;")."&nbsp;&#8381;";
    }

}
