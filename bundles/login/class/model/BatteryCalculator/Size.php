<?

namespace Infuso\Site\Model\BatteryCalculator;
use Infuso\Core;

/**
 * Модель типоразмера батареи
 **/
class Size extends \Infuso\ActiveRecord\Record {

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
                    'name' => 'descr',
                    'type' => 'textarea',
                    'editable' => '1',
                    'label' => 'Описание',
                ), array (
                    'name' => 'priceForAssembly',
                    'type' => 'cost',
                    'editable' => 1,
                    'label' => 'Стоимость работы, $',
                ), array (
                    'name' => 'additionalAssemblyWeight',
                    'type' => 'decimal',
                    'editable' => 1,
                    'label' => 'Дополнительный вес в сборке, г.',
                ),
            ),
        );
    } 

    /**
     * Возвращает все типоразмеры
     **/         
	public function all() {
        return service("ar")
            ->collection(get_class());
    }
    
    /**
     * Возвращает элемент по id
     **/
    public static function get($id) {
        return service("ar")
            ->get(get_class(), $id);
    }    
    
    public function prices() {
        return CellPrice::all()
            ->eq("sizeId", $this->id());
    }
    
    private $priceInterpolator;
    
    /**
     * Возвращает процент оптовости
     **/
    public function wholesaleRate($quantity) {
        if(!$this->priceInterpolator) {
            $this->priceInterpolator = new \Infuso\Site\Interpolator();
            foreach($this->prices()->limit(0) as $price) {
                $this->priceInterpolator->keypoint($price->data("quantity"), $price->data("rate"));
            }
        }
        
        if($quantity > $this->priceInterpolator->maxX()) {
            $quantity = $this->priceInterpolator->maxX();
        }
        
        return $this->priceInterpolator->interpolate($quantity);

    }

}
