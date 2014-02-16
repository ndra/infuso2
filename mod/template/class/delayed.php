<?

namespace Infuso\Template;
use Infuso\Core;

/**
 * Отложенная функция php
 **/
class Delayed implements Core\Handler {

	//public static $size = 0;

	public function add($params) {
	    return tmp::conveyor()->addDelayedFunction($params);
	}
	
	/**
	 * При завершении экшна обрабатываем отложенные функции
	 * @handler = infusoAfterActionSys
	 **/
	public function onAfterActionSYS($event) {
	
	    $content = $event->param("content");
	    
	    if(sizeof(Core\Log::messages(false))) {
	    	$content = self::insertMessages($content);
	    }
	    
	    $content = tmp::conveyor()->processDelayed($content);
  		
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
        	$tmp = tmp::get("/mod/messages");
        	return $str[0].$tmp->rexec();
        } catch (\Exception $ex) {
			echo $ex->getMessage();
        }
    }

}
