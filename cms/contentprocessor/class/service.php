<?

namespace Infuso\CMS\ContentProcessor;
use \Infuso\Core;

/**
 * Сервирс для преобразования текста
 **/
class Service extends Core\Service {

	public function initialParams() {
		return array(
   			"newlineToParagraph" => true,
		);
	}

	/**
	 * @return Приоритет темы =-1
	 **/
	public function defaultService() {
		return "content-processor";
	}

    /**
     * Стандартный процессор контента
     * Вставляет виджеты в переданный html
     **/
    public function process($html) {

        // Выполняем виджеты
        $html = self::processorWidget($html);
        
        // Переводим \n в параграфы, если включена настройка
        if($this->param("newlineToParagraph")) {
            $paragraph = new Paragraph();
            $html = $paragraph->process($html);
        }

        return $html;
    }

    /**
     * Метод заменяет виджет на отложеную функцию
     * UPD: метод не рефакторился
     * UPD - вроде все ок, можно доработать реджексы выдирания контента
     * чтобы <widget> искало только в начале и конце строки
     **/
    public function replaceWidget($matches) {

        // Находим параметры виджета
        $widget = \util::str($matches)->html()->body->widget;

        $params = array();
        foreach($widget->attributes() as $a) {
            $params[$a->getName()] = $a."";
        }

        // Находим контент виджета
        $params["content"] = preg_replace(array(
            "/^\<widget[^>]*?\>/s",
            "/\<\/widget\>$/s",
        ), "", $matches);
        
        $w = \Infuso\Template\Widget::get($params["name"]);

        foreach($params as $key => $val) {
            $w->param($key, $val);
        }

        return $w->rexec();
    }
    
    /**
     * Процессор виджетов
     **/
     public static function processorWidget($html) {

         //Уровень вложенности
         $level = 0;

         //Буфер
         $content = array();          

         //Разбиваем строку на куски
         $train = preg_split("/(<widget\s*[^>]*?[^>]*\/>|<widget\s*[^>]*?[^>]*>|<\/widget>)/", $html, -1, PREG_SPLIT_DELIM_CAPTURE);

         foreach ($train as $item) {

             if (preg_match("/<widget\s*[^>]*?[^>]*\/>/", $item)) {       
                 //Виджет без контента
                 $content[$level] .= self::replaceWidget($item);

             } elseif (preg_match("/<widget\s*[^>]*?[^>]*>/", $item)) {
                 //Поднимаем уровень вложености и заполняем его данными
                 $level++;
                 $content[$level] .= $item;

             } elseif (preg_match("/<\/widget>/", $item)) {
                 //Заканчиваем данный уровень, пропускаем его через процессор и добавляем его на уровень ниже

                 $content[$level] .= $item;

                 $innerContent = $content[$level];

                 //Удаляем текущий уровень из буфера
                 unset($content[$level]);

                 //Пропускаем текущий уровень через Процессор и добавляем его на уровень ниже
                 $level--;
                 $content[$level] .= self::replaceWidget($innerContent);

             } else {
                 //Добавляем на текущий уровень
                 $content[$level] .= $item;
             }

         } //end foreach

         //Если $level не равен 0, значит в коде ошибка, например не закрыли тег <widget>
         //Пишем в лог об ошибке
         //И добавляем все уровни >0 в вывод
         if ($level > 0) {
             \mod::trace("Ошибка в разборе Виджетов, в данном коде: \n"
                 . $html
                 . "\n\n"
             );

             while ($level > 0) {
                 $content[0] .= $content[$level];
                 unset($content[$level]);
                 $level--;
             }
         }

         //Таким образом весь результат находиться на 0 уровне
         return $content[0];
    }

}
