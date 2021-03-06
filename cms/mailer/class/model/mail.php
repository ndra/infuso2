<?

namespace Infuso\Cms\Mailer\Model;
use Infuso\Core;
use Infuso\ActiveRecord;
use Infuso\Core\File as File;

/**
 * Модель письма
 **/ 
class Mail extends ActiveRecord\Record {

	public static function model() {
		return array (
			'name' => get_class(),
			'fields' =>	array (
				array (
					'name' => 'id',
					'type' => 'jft7-kef8-ccd6-kg85-iueh',
					"editable" => 2,
				), array (
					'name' => 'datetime',
					'type' => 'x8g2-xkgh-jc52-tpe2-jcgb',
					'label' => 'Дата',
					"editable" => 2,
					"default" => "now()",
		    	), array (                                                      
					'name' => 'user',
					'type' => 'pg03-cv07-y16t-kli7-fe6x',
					'label' => 'Пользователь',
					'class' => 'infuso\\user\\model\\user',
					"editable" => 2,
		    	), array (
					'name' => 'code',
					'type' => 'string',
                    'length' => 50,
					'label' => 'Код шаблона',
					"editable" => 2,
		    	), array (
					'name' => 'type',
					'type' => 'string',
                    'length' => 50,
					'label' => 'Тип',
					"default" => "text",
					"editable" => 2,
		    	), array (
					'name' => 'message',
					'type' => 'textarea',
					'label' => 'Сообщение',
					"editable" => 2,
		    	), array (
					'name' => 'subject',
					'type' => 'string',
					'label' => 'Тема',
					"editable" => 2,
		    	), array (
					'name' => 'from',
					'type' => 'string',
					'label' => 'От',
					"editable" => 2,
		    	), array (
					'name' => 'to',
					'type' => 'string',
					'label' => 'Кому',
					"editable" => 2,
		    	),  array (
					'name' => 'sentDatetime',
					'type' => 'datetime',
					'label' => 'Дата и время отправки',
					"editable" => 2,
		    	), array (
					'name' => 'sent',
					'type' => 'checkbox',
					'label' => 'Сообщение отправлено',
					"editable" => 2,
		    	), array (
					'name' => 'params',
					'type' => 'array',
					'label' => 'Параметры',
					"editable" => 2,
		    	),
			),
		);
	}

    /**
     * Возвращает письмо по id
     **/
    public static function get($id) {
        return service("ar")->get(get_class(),$id);
    }

    /**
     * Возвращает коллекцию всех писем
     **/
    public static function all() {
        return service("ar")
            ->collection(get_class())
            ->desc("datetime");
    }
	
	 /**
     * Задает тип письма как html
     *
     */
    public function html() {
        $this->type("text/html");
        return $this;
    }

    /**
     * Возвращает / изменяет пользователя, которому адресовано сообщение
     **/
    public function user($user = null) {
        if(func_num_args() == 0) {
            return $this->pdata("user");
        } elseif(func_num_args() == 1) {
            if(is_object($user)) {
                $this->data("user", $user->id());                
            } else {
                $this->data("user", $user);
            }
            $this->to($this->user()->email());
            return $this;
        }
    }
    
    /**
     * Отправляет письмо
     **/         
    public function send() {
    
        // Перво-наперво применим к письму шаблон
        $this->applyTemplate();        

        $message = $this->message();

        // Генерируем уникальный разделитель
        $boundary  = md5(uniqid(time()));

        // Заголовки
        $headers = $this->headers();
        $headers[] = "MIME-Version: 1.0;";
        $headers[] = "Content-Type: multipart/mixed; boundary=\"$boundary\"";
        if ($this->from()) {
            $headers[] = "From:" . self::utf8email($this->from());
        }

        // Тело письма
        $multipart = array();

        // Кодируем текст письма в base64
        // Разрезаем его на кусочки методом chunk_split чтобы не было длинных строк (RFC 2882)
        $multipart[] = "--" . $boundary;
        $multipart[] = "Content-Type: " . $this->type() . "; charset=utf-8";
        $multipart[] = "Content-Transfer-Encoding: base64";
        $multipart[] = "";
        $multipart[] = chunk_split(base64_encode($message));
        $multipart[] = "";

        // Прикрепляем к письму файлы вложений
        foreach($this->attachments() as $attach) {

            $filename = $attach["name"];
            $filecontent = $attach["file"];
            $cid = $attach["cid"];

            $multipart[] ="--".$boundary;

            $multipart[] = "Content-Type: application/octet-stream; name=\"" . $filename . "\""; //image/jpeg
            $multipart[] = "Content-Transfer-Encoding: base64";

            if ($cid != null && $cid != "") {
                $multipart[] = "Content-ID: <" . $cid . ">";
            }

            $multipart[] = "Content-Disposition: attachment; filename=\"" . $filename . "\"";
            $multipart[] = "";
            $multipart[] = "";
            $multipart[] = chunk_split(base64_encode(file_get_contents($filecontent)), 76, "\n");
        }

        $multipart[] = "--$boundary--";
        $multipart[] = "";

        $subject = '=?UTF-8?B?' . base64_encode($this->subject()) . '?=';

        $ret = mail (
            $this->to(),
            $subject,
            implode("\n", $multipart),
            implode("\n", $headers)
        );
        
        if($ret) {
            $this->data("sent", true);
            $this->data("sentDatetime", \Util::now());
        }
        
        return $ret;
        
    }
    
    /**
     * Применяет к письму шаблон
     **/         
    public function applyTemplate() {
    
        // Если не указан код - выходим
        $code = $this->code();
        if(!$code) {
			return;
        }

		// Создаем шаблон с этим кодом, если его еще нет
        $template = $this->template();
        if(!$template->exists()) {
            $template = service("ar")->create(Template::inspector()->className(), array(
                "code" => $code,
			));
        }
        
        $this->template()->applyTo($this);
    }
    
    /**
     * Возвращает шаблон (на основании $this->data("code"))
     **/
	public function template() {
    	return Template::all()->eq("code", $this->data("code"))->one();
	}
	
	/**
	 * Возвращает массив вложений
	 **/
	public function attachments() {
        $attachments = $this->param("attachments");
        if(!is_array($attachments)){
            $attachments = array();
        }
	    return  $attachments;
	}

	public function dataWrappers() {
	    return array(
	        "message" => "mixed/data",
	        "headers" => "mixed/data",
	        "from" => "mixed/data",
	        "type" => "mixed/data",
	        "subject" => "mixed/data",
	        "to" => "mixed/data",
	        "code" => "mixed/data",
		);
	}

    /**
     * Правильное форматирование utf-8 email адресов
     *
     * @param string $email Строка c эмейлом для форматирования в вид <имя> е-майл
     * @return string
     * @author Petr.Grishin
     */
    private static function utf8email($email) {
        if (preg_match("/.*? <.*?".">/ui", $email)) {
            $name = preg_replace("/(.*?) (<.*?".">)/ui", "\$1", $email);
            $name = '"=?UTF-8?B?' . base64_encode($name) . '?=" ';
            $email = preg_replace("/(.*?) (<.*?".">)/ui", "\$2", $email);
            return $name . $email;
        } else {
            return $email;
        }
    }        

    /**
     * Прикрепляет файл к письму
     * @var $file string Файл для прикрепления от корня веб проекта
     * @author Petr.Grishin
     **/
    public function attach($file = null, $name = null, $cid = null) {

        if ($file === null || $file == "") {
            return $this;
        }

        return $this->attachNative(File::get($file)->native(), $name, $cid);
    }


    /**
     * Прикрепляет файл к письму
     * @var $file string Файл для прикрепления Нативный
     * @author Petr.Grishin
     **/
    public function attachNative($file = null, $name = null, $cid = null) {

        if ($file === null || $file == "") {
            return $this;
        }

        if ($name === null || $name == "") {
            $name = mod_file::get($file)->name();
        }

        $attachments = $this->param("attachments");
        $attachments[] = array(
            "name" => $name,
            "file" => $file,
            "cid" => $cid,
        );
        $this->param("attachments",$attachments);

        return $this;
    }
    
    public function beforeStore() {
        $this->data("params", $this->params());
    }
}
