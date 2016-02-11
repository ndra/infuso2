<?

namespace Infuso\Template;
use Infuso\Core;

/**
 * Отложенная функция php
 **/
class Delayed implements Core\Handler {

	//public static $size = 0;

	public function add($params) {
	    return app()->tm()->conveyor()->addDelayedFunction($params);
	}
	
	/**
	 * При завершении экшна обрабатываем отложенные функции
	 * @handler = infuso/afterActionSys
	 **/
	public function onAfterActionSYS($event) {
	
	    $content = $event->param("content");
	    
        $messages = service("msg")->messages(false);       
	    if($messages) {
	    	$content = self::insertMessages($content);
	    }
	    
	    $content = app()->tm()->conveyor()->processDelayed($content);
  		
  		$event->param("content",$content);
  		
	}
	
	/**
	 * Добавляет вывод сообщений в контент
	 * Находит тэг <body> и добавляет сообщения в его начало
	 **/
    public function insertMessages($str) {
        return preg_replace_callback("/\<body[^>]*>/",array("self","insertMessagesCallback"),$str);
    }

	/**
	 * Кэллбэк для tmp_delayed::insertMessages()
	 **/
    public function insertMessagesCallback($str) {
    
        try {
        	$tmp = app()->tm("/mod/messages");
        	return $str[0].$tmp->rexec();
        } catch (\Exception $ex) {
			echo $ex->getMessage();
        }
    }

}
