<?

/**
 * Класс создает поведение для пользователя, оплачивающего товары/услуги со внутреннего счета.
 **/
class userBehaviour extends \infuso\Core\Behaviour {
    
    /**
     * Добавить всем объектам возвращаемого класса методы текущего и наследуемых классов [шито ???]
     **/
    public function addToClass() {
        return "Infuso\\User\\Model\\User\\User";
    }
    
    /**
     * Добавить поле
     **/
    public function model() {
        return array(
            "fields" => array(
                array (
                    'name' => 'userCash',
                    'type' => 'cost',
                    'label' => 'Сумма на внутреннем счете',
                    "editable" => true,
                )

            ),
        );
    }

    public static function confDescription() {
        return array(
            "components" => array(
                get_class() => array(
                    "params" => array(
                        "accountCurrency" => "Валюта личного кабинета",
                    ),
                ),
            ),
        );
    }

    /**
     * Пополнить внутренний счет пользователя
     **/
    public function addFunds($funds, $comment = "") {
    
        $userCash = $this->data("userCash");
        $newCash = $userCash + abs($funds);
        $this->data("userCash", $newCash);
        $log = $this->payAccountOperationLog()->create(array(
            "amount" => $funds,
            "comment" => $comment,
        ));
        
    }
    
    /**
     * Списать средства с внутреннего счета пользователя
     **/
    public function withdrawFunds($funds, $comment = "") {
    
        $userCash = $this->data("userCash");
        $newCash = $userCash - abs($funds);
        $this->data("userCash", $newCash);
        $this->payAccountOperationLog()->create(array(
            "amount" => - $funds,
            "comment" => $comment,
        ));
        
    }
    
    /**
     * Взять все записи изменения внутреннего счета пользователя
     **/
    public function payAccountOperationLog() {
        return \Infuso\Pay\Model\OperationLog::all()->eq("userId", $this->id());
    }
    
    /**
     * Добавить вкладку в меню пользоваетеля
     **/
    public function reflex_children() {
        return array(
            $this->payAccountOperationLog()->title("Счет")->param("menu", false)
        );
    }
    
    /**
     * Возвращает количество средств на счету пользователя
     **/
    public function valueInAccount() {
    
        // Проверяем валюту счета
        // Если она не указана, метод accountCurrency() выбросит экзэпшн
        $this->accountCurrency();
    
        return $this->data("userCash");
    }
    
    /**
     * Возвращает валюту личного кабинета
     **/
    public function accountCurrency() {
    
        $currency = $this->param("pay:accountCurrency")*1;
        
        if(!$currency) {
            throw new \Exception("Валюта личного кабинета не задана");
        }
    
        return $currency;
    }

}
