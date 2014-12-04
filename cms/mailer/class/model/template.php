<?

namespace Infuso\Cms\Mailer\Model;
use Infuso\Core;
use Infuso\ActiveRecord;

/**
 * Модель записи в журнале
 **/ 
class Template extends ActiveRecord\Record {

	public static function model() {
		return array (
			'name' => get_class(),
			'fields' =>	array (
				array (
					'name' => 'id',
					'type' => 'jft7-kef8-ccd6-kg85-iueh',
					"editable" => 2,
				), array (
					'name' => 'code',
					'type' => 'string',
                    'label' => 'Код',
					"editable" => 1,
				), array (
					'name' => 'from',
					'type' => 'string',
                    'label' => 'От кого',
					"editable" => 1,
				), array (
					'name' => 'subject',
					'type' => 'string',
                    'label' => 'Тема',
					"editable" => 1,
				), array (
					'name' => 'message',
					'type' => 'textarea',
                    'label' => 'Сообщение',
					"editable" => 1,
				), array (
					'name' => 'params',
					'type' => 'textarea',
                    'label' => 'Параметры',
					"editable" => 2,
				),
			),
		);
	}

    public static function get($id) {
        return service("ar")->get(get_class(),$id);
    }

    public static function all() {
        return service("ar")
            ->collection(get_class())
            ->asc("code");
    }

    /**
     * Возвращает коллекцию писем с этим шаблоном
     **/         
    public function emails() {
        return Mail::all()->eq("code", $this->data("code"));
    }
    
    /**
     * Примеряет шаблон к письму
     **/
    public function applyTo($mail) {
    
        // Параметры, которые доступны в шаблонах
		$params = array(
			"from" => $mail->from(),
			"to" => $mail->to(),
			"subject" => $mail->subject(),
		);
		foreach($mail->params() as $key => $val) {
		    $params[$key] = $val;
		}
		
		// Сохраняем в шаблоне список параметров
		$paramsText = array();
		foreach($params as $key => $none) {
		    $paramsText[] = $key;
		}
		$paramsText = implode(",", $paramsText);
		$this->data("params", $paramsText);
		
		$fieldsToProcess = array(
		    "message",
		    "subject",
		    "from"
		);
		
		// Пропускаем поля через процессор
		foreach($fieldsToProcess as $field) {
		    // Обрабатываем только поля, данные в которых заполнены
		    if($this->data($field)) {
		    	$mail->data($field, self::processText($this->data($field), $params));
		    }
		}
		
    }
    
    public static function processText($text, $params) {
        foreach($params as $key => $val) {
            $text = strtr($text, array(
				'{$'.$key.'}' => $val,
			));
        }
        return $text;
    }

}
