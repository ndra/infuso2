<?

namespace Infuso\Site\Model\BatteryCalculator;
use Infuso\Core;

/**
 * Дефолтный контроллер Сайта
 **/
class Cell extends \Infuso\ActiveRecord\Record implements Core\Handler {

    private $voltageInterpolator;
    private $capacityAHInterpolator;
    private $cyclesInterpolator;

    public static function model() {
        return array(
            'name' => get_class(),
            'fields' => array (
                array (
                    'name' => 'id',
                    'type' => 'jft7-kef8-ccd6-kg85-iueh',
                ), array (
                    'name' => 'title',
                    'type' => 'textfield',
                    'editable' => '1',
                    'label' => 'Название',
                ), array (
                    'name' => 'img',
                    'type' => 'file',
                    'editable' => 1,
                    'label' => 'Фотография',
                ), array (
                    'name' => 'spec',
                    'type' => 'file',
                    'editable' => 1,
                    'label' => 'Спецификация',
                ), array (
                    'name' => 'descr',
                    'type' => 'textarea',
                    'editable' => '1',
                    'label' => 'Описание',
                ), array (
                    'name' => 'nominalCapacity',
                    'type' => 'decimal',
                    'editable' => 1,
                    'label' => 'Номинальная емкость, Ач',
                ), array (
                    'name' => 'nominalVoltage',
                    'type' => 'decimal',
                    'editable' => 1,
                    'label' => 'Номинальное напряжение, В',
                ), array (
                    'name' => 'maxVoltage',
                    'type' => 'decimal',
                    'editable' => 1,
                    'label' => 'Макс. напряжение, В',
                ), array (
                    'name' => 'minVoltage',
                    'type' => 'decimal',
                    'editable' => 1,
                    'label' => 'Мин. напряжение, В',
                ), array (
                    'name' => 'continuousCurrentDischarge',
                    'type' => 'decimal',
                    'editable' => 1,
                    'label' => 'Продолжительный ток разряда, А',
                ),  array (
                    'name' => 'weight',
                    'type' => 'decimal',
                    'editable' => 1,
                    'label' => 'Вес, г.',
                ), array (
                    'name' => 'internalResistance',
                    'type' => 'decimal',
                    'editable' => 1,
                    'label' => 'Внутреннее сопротивление, мОм',
                ), array (
                    'name' => 'chemistry',
                    'type' => 'link',
                    'class' => Chemistry::inspector()->className(),
                    'editable' => 1,
                    'label' => 'Тип химии',
                ), array (
                    'name' => 'size',
                    'type' => 'link',
                    'class' => Size::inspector()->className(),
                    'editable' => 1,
                    'label' => 'Типоразмер',
                ), array (
                    'name' => 'vendor',
                    'type' => 'link',
                    'class' => Vendor::inspector()->className(),
                    'editable' => 1,
                    'label' => 'Производитель',
                ), array (
                    'name' => 'pricePurchase',
                    'type' => 'cost',
                    'editable' => 1,
                    'label' => 'Стоимость закупки (с доставкой), USD',
                ), array (
                    'name' => 'retailMarkup',
                    'type' => 'decimal',
                    'editable' => 1,
                    'label' => 'Розничная наценка, %',
                ), array (
                    'name' => 'wholesaleMarkup',
                    'type' => 'decimal',
                    'editable' => 1,
                    'label' => 'Оптовая наценка, %',
                ), array (
                    'name' => 'publish',
                    'type' => 'checkbox',
                    'editable' => 1,
                    'label' => 'Опубликовать',
                ), array (
                    'name' => 'eshopItem',
                    'type' => 'link',
                    'editable' => 1,
                    'class' => \Infuso\Eshop\Model\Item::inspector()->className(),
                    'label' => 'Товар',
                ), array (
                    'name' => 'niceId',
                    'type' => 'string',
                    'editable' => 2,
                    'length' => 40,
                    'label' => 'Красивый Id',
                ),
            ),
        );
    } 
    
    /**
     * @handler = reflex/sitemap
     **/
    public static function handleSitemap($event) {      
        $event->addCollection(self::all()->eq("publish", 1));
    }
    
    public function recordTitle() {
        return $this->data("title");
    }
    
    public function updateMeta() {
    
        // URL 
        $url = "cell/".$this->vendor()->title()."/".$this->title();
        $this->plugin("route")->setURL($url);
        
        // Тайтл
        $title = "Купить ячейку {$this->vendor()->title()} {$this->size()->title()} {$this->title()} ".($this->nominalCapacity() * 1000)."mAh {$this->maxContinuousCurrentDischarge()}A";
        $this->plugin("meta")->title($title);
        
        // Красивый Id
        $id = \Infuso\Util\Util::str($this->vendor()->title()."-".$this->title())->translit()->lower();
        $this->data("niceId", $id);
    }
    
    public function beforeStore() {
        $this->updateMeta();
    }
    
    public function indexTest() {
        return true;
    }
    
    public function postTest() {
        return app()->user()->checkAccess("admin:showInterface");
    }
    
    public function post_savePrice($p) {   
        $cell = self::get($p["id"]);
        $cell->fill($p["data"]);
    }

    public function post_updatePrice($p) {
        $cell = self::get($p["id"]);
        return app()->tm("/site/admin/cell-prices/content/ajax")
            ->param("cell", $cell)
            ->getContentForAjax();
    }
    
    public function index_item($p) {
        $cell = self::get($p["id"]);
        app()->tm("/site/cell")
            ->param("cell", $cell)
            ->exec();
    }
    
    public function recordParent() {
        return $this->pdata("parent");
    }

    /**
     * Возвращает все страницы из портфолио
     **/         
	public function all() {
        return service("ar")
            ->collection(get_class());
    }
    
    /**
     * Возвращает элемент портфолио по id
     **/
    public static function get($id) {
        return service("ar")
            ->get(get_class(), $id);
    }
    
    public function discharge() {
        return Discharge::all()->eq("cellId", $this->id());
    }
    
    /**
     * Возвращает плотность энергии (Вт*ч/кг)
     **/
    public function energyDensity() {
        return $this->nominalCapacity() * $this->nominalVoltage() / $this->weight() * 1000;
    }
    
    /**
     * Возвращает плотность мощности (вт/кг)
     **/
    public function powerDensity() {
        return $this->data("continuousCurrentDischarge") * $this->nominalVoltage() / $this->data("weight") * 1000;
    }
    
    /**
     * Возвращает стоимость киловат-часа в USD
     * Для расчета берем цену за 1000 элементов
     **/
    public function pricePerKWh() { 
        return  new \Infuso\Site\Price(1000 / $this->nominalCapacity() / $this->nominalVoltage() * $this->priceFinal(1000)->usd()); 
    }
    
    public function chemistry() {
        return $this->pdata("chemistry");
    }
    
    public function size() {
        return $this->pdata("size");
    }    
    
    public function vendor() {
        return $this->pdata("vendor");
    }    

    /**
     * Возвращает номинальную емкость ячейки, А*ч
     **/
    public function nominalCapacity() {
        return $this->data("nominalCapacity");
    }

    /**
     * Возвращает номинальное напряжение
     **/    
    public function nominalVoltage() {
        return $this->data("nominalVoltage");
    }
    
    public function maxVoltage() {
        return $this->data("maxVoltage");
    }
    
    public function minVoltage() {
        return $this->data("minVoltage");
    }
    
    /**
     * Возвращает максимальный продолжительный ток разряда
     **/
    public function maxContinuousCurrentDischarge() {
        return $this->data("continuousCurrentDischarge");
    }

    /**
     * Возвращает цену с работой, доставкой, наценкой и т.п.
     **/
    public function priceFinal($quantity = 1) {
        return new \Infuso\Site\Price($this->priceSelling($quantity)->usd() + $this->priceAssembly()->usd());
    }
    
    public function priceAssembly() {
        return new \Infuso\Site\Price($this->size()->data("priceForAssembly"));
    }
    
    public function pricePurchase() {
        return new \Infuso\Site\Price($this->data("pricePurchase"));
    } 
    
    /**
     * Возвращает цену продажи
     * Зависит от количества
     **/
    public function priceSelling($quantity = 0) {
        $k = $this->size()->wholesaleRate($quantity);
        $rate = 1 + ($this->data("retailMarkup") * (1 - $k) + $this->data("wholesaleMarkup") * $k) / 100;
        $usd = $this->pricePurchase()->usd() * $rate;
        return new \Infuso\Site\Price($usd); 
    }    
 
    /**
     * Возвращает количество циклов до снижения емкости 70%
     **/
    public function cycles($current = null) {
    
        if(func_num_args() == 0) {
            $current = $this->nominalCapacity() * .2;
        }
        
        if(!$this->cyclesInterpolator) {    
            $this->cyclesInterpolator = new \Infuso\Site\Interpolator();
            foreach($this->discharge() as $discharge) {
                if($cycles = $discharge->data("cycles-70")) {
                    $xcurrent = $discharge->data("rate") * $this->nominalCapacity();
                    $this->cyclesInterpolator->keypoint($xcurrent, $cycles);
                }
            }
        }
        
        if(sizeof($this->cyclesInterpolator->keypoints()) == 0) {
            return null;
        }
        
        if($current < 0) {
            $current = 0;
        }
        
        $ret = round($this->cyclesInterpolator->interpolate($current));
        if($ret < 0) {
            $ret = 0;
        }
                
        return $ret;         
    }
    
    /**
     * Возвращает емкость (Ампер*час) для тока разряда $current (А)
     **/
    public function capacityAh($current) {
        
        if($this->capacityAHInterpolator == null)  {  
            $this->capacityAHInterpolator = new \Infuso\Site\Interpolator();
            foreach($this->discharge() as $discharge) {
                if($capacity = $discharge->data("capacity")) {
                    $xcurrent = $discharge->data("rate") * $this->nominalCapacity();
                    $this->capacityAHInterpolator->keypoint($xcurrent, $capacity);
                }
            }
        }
        
        if($current < 0) {
            $current = 0;
        }
        
        $ret = $this->capacityAHInterpolator->interpolate($current);
        if($ret < 0) {
            $ret = 0;
        }
        
        return $ret;         
    }
    
    /**
     * Возвращает напряжение на ячейке в зависимости от текущего тока
     **/
    public function voltage($current) {
    
        // Создаем интерполятор, если его еще нет
        if($this->voltageInterpolator == null)  {        
            $this->voltageInterpolator = new \Infuso\Site\Interpolator();
            foreach($this->discharge() as $discharge) {
                if($voltage = $discharge->data("voltage")) {
                    $xcurrent = $discharge->data("rate") * $this->nominalCapacity();
                    $this->voltageInterpolator->keypoint($xcurrent, $voltage);
                }
            }                  
        }
        
        if($current < 0) {
            $current = 0;
        }
        
        $ret = $this->voltageInterpolator->interpolate($current);
        if($ret < 0) {
            $ret = 0;
        }
        
        return $ret;         
    }
    
    /**
     * Возвращает вес элемента в сборке
     **/
    public function assemblyWeight() {
        return $this->weight() + $this->size()->data("additionalAssemblyWeight");
    }
    
    public function weight() {
        return $this->data("weight");
    }

}
