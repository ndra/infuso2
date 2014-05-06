<?

/**
 * Поведение к классу util_str, реализующее специфические для русского языка методы
 **/

class util_str_ru extends mod_behaviour {

    public function addToClass() {
        return "util_str";
    }

    /**
    * Функция возвращает окончание для множественного числа слова на основании числа и массива окончаний
    * @param  $number Integer Число на основе которого нужно сформировать окончание
    * @param  $endingsArray  Array Массив слов или окончаний для чисел (1, 4, 5),
    *         например array('яблоко', 'яблока', 'яблок')
    * @return String
    */
    function numEnding($number, $endingArray) {
    
        array_unshift($endingArray,$this."");
    
        $number = $number % 100;
        if ($number>=11 && $number<=19) {
            $ending=$endingArray[2];
        }
        else {
            $i = $number % 10;
            switch ($i)
            {
                case (1): $ending = $endingArray[0]; break;
                case (2):
                case (3):
                case (4): $ending = $endingArray[1]; break;
                default: $ending=$endingArray[2];
            }
        }
        return new util_str($ending);
    }
    
    /**
     * Возвращает склонение (падеж) слова
     * ИСпользует яндекс.сколнятор
     **/
    public function inflect($inflection) {
    
        $word = $this."";
        $xml = simplexml_load_file("http://export.yandex.ru/inflect.xml?name=$word");
        
        foreach($xml->inflection as $inf) {
            $ret[$inf["case"]*1] = $inf."";
        }
            
        $ret = $ret[$inflection];
        
        if(!$ret) {
            $ret = $word;
        }
        
        return $ret;
    }
    
	/**
	 * Обрезает окончание слова
	 **/
    public function stem() {
        $s = new util_str_stemer();
        $s = $s->stemString($this);
        return new self($s);
    }

    public function switchLayout() {

        $en = array(
            "й","ц","у","к","е","н","г","ш","щ","з","х","ъ",
            "ф","ы","в","а","п","р","о","л","д","ж","э",
            "я","ч","с","м","и","т","ь","б","ю"
        );
        
        $ru = array(
            "q","w","e","r","t","y","u","i","o","p","[","]",
            "a","s","d","f","g","h","j","k","l",";","'",
            "z","x","c","v","b","n","m",",","."
        );

        $ret = strtr((string)$this,array_combine($en,$ru) + array_combine($ru,$en));
        return $ret;

    }
    
    public function hyphenize() {
        $str = hyphen_words((string)$this);
        return new \util_str($str);
	}

}

function hyphen_words($s)
{
    #регулярное выражение для атрибутов тагов
    #корректно обрабатывает грязный и битый HTML в однобайтовой или UTF-8 кодировке!
    $re_attrs_fast_safe =  '(?> (?>[\x20\r\n\t]+|\xc2\xa0)+  #пробельные символы (д.б. обязательно)
                                (?>
                                  #правильные атрибуты
                                                                 [^>"\']+
                                  | (?<=[\=\x20\r\n\t]|\xc2\xa0) "[^"]*"
                                  | (?<=[\=\x20\r\n\t]|\xc2\xa0) \'[^\']*\'
                                  #разбитые атрибуты
                                  |                              [^>]+
                                )*
                            )?';
    $regexp = '/(?: #встроенный PHP, Perl, ASP код
                    <([\?\%]) .*? \\1>  #1

                    #блоки CDATA
                  | <\!\[CDATA\[ .*? \]\]>

                    #MS Word таги типа "<![if! vml]>...<![endif]>",
                    #условное выполнение кода для IE типа "<!--[if lt IE 7]>...<![endif]-->"
                  | <\! (?>--)?
                        \[
                        (?> [^\]"\']+ | "[^"]*" | \'[^\']*\' )*
                        \]
                        (?>--)?
                    >

                    #комментарии
                  | <\!-- .*? -->
                  | {.*?}
                    #парные таги вместе с содержимым
                  | <((?i:noindex|script|style|comment|button|map|iframe|frameset|object|applet))' . $re_attrs_fast_safe . '> .*? <\/(?i:\\2)>  #2

                    #парные и непарные таги
                  | <[\/\!]?[a-zA-Z][a-zA-Z\d]*' . $re_attrs_fast_safe . '\/?>

                    #html сущности (&lt; &gt; &amp;) (+ корректно обрабатываем код типа &amp;amp;nbsp;)
                  | &(?>
                        (?> [a-zA-Z][a-zA-Z\d]+
                          | \#(?> \d{1,4}
                                | x[\da-fA-F]{2,4}
                              )
                        );
                     )+

                    #не html таги и не сущности
                  | ([^<&]{2,})  #3
                )
               /sx';
    return preg_replace_callback($regexp, '_hyphen_words', $s);
}
function _hyphen_words(array &$m)
{
    if (! array_key_exists(3, $m)) return $m[0];
    $s =& $m[0];

    #буква (letter)
    $l = '(?: \xd0[\x90-\xbf\x81]|\xd1[\x80-\x8f\x91]  #А-я (все)
            | [a-zA-Z]
          )';

    #буква (letter)
    $l_en = '[a-zA-Z]';
    #буква (letter)
    $l_ru = '(?: \xd0[\x90-\xbf\x81]|\xd1[\x80-\x8f\x91]  #А-я (все)
             )';

    #гласная (vowel)
    $v = '(?: \xd0[\xb0\xb5\xb8\xbe]|\xd1[\x83\x8b\x8d\x8e\x8f\x91]  #аеиоуыэюяё (гласные)
            | \xd0[\x90\x95\x98\x9e\xa3\xab\xad\xae\xaf\x81]         #АЕИОУЫЭЮЯЁ (гласные)
            | (?i:[aeiouy])
          )';

    #согласная (consonant)
    $c = '(?: \xd0[\xb1-\xb4\xb6\xb7\xba-\xbd\xbf]|\xd1[\x80\x81\x82\x84-\x89]  #бвгджзклмнпрстфхцчшщ (согласные)
            | \xd0[\x91-\x94\x96\x97\x9a-\x9d\x9f-\xa2\xa4-\xa9]                #БВГДЖЗКЛМНПРСТФХЦЧШЩ (согласные)
            | (?i:sh|ch|qu|[bcdfghjklmnpqrstvwxz])
          )';

    #специальные
    $x = '(?:\xd0[\x99\xaa\xac\xb9]|\xd1[\x8a\x8c])';   #ЙЪЬйъь (специальные)

    /*
    #алгоритм П.Христова в модификации Дымченко и Варсанофьева
    $rules = array(
        # $1       $2
        "/($x)     ($l$l)/sx",
        "/($v)     ($v$l)/sx",
        "/($v$c)   ($c$v)/sx",
        "/($c$v)   ($c$v)/sx",
        "/($v$c)   ($c$c$v)/sx",
        "/($v$c$c) ($c$c$v)/sx"
    );

    #improved rules by Dmitry Koteroff
    $rules = array(
        # $1                      $2
        "/($x)                    ($l (?:\xcc\x81)? $l)/sx",
        "/($v (?:\xcc\x81)? $c$c) ($c$c$v)/sx",
        "/($v (?:\xcc\x81)? $c$c) ($c$v)/sx",
        "/($v (?:\xcc\x81)? $c)   ($c$c$v)/sx",
        "/($c$v (?:\xcc\x81)? )   ($c$v)/sx",
        "/($v (?:\xcc\x81)? $c)   ($c$v)/sx",
        "/($c$v (?:\xcc\x81)? )   ($v (?:\xcc\x81)? $l)/sx",
    );
    */

    #improved rules by Dmitry Koteroff and Rinat Nasibullin
    $rules = array(
        # $1                      $2
        "/($x)                    ($c (?:\xcc\x81)? $l)/sx",
        "/($v (?:\xcc\x81)? $c$c) ($c$c$v)/sx",
        "/($v (?:\xcc\x81)? $c$c) ($c$v)/sx",
        "/($v (?:\xcc\x81)? $c)   ($c$c$v)/sx",
        "/($c$v (?:\xcc\x81)? )   ($c$v)/sx",
        "/($v (?:\xcc\x81)? $c)   ($c$v)/sx",
        "/($c$v (?:\xcc\x81)? )   ($v (?:\xcc\x81)? $l)/sx",
    );
    #\xc2\xad = &shy;  U+00AD SOFT HYPHEN
    $s = preg_replace($rules, "$1\xc2\xad$2", $s);

    return $s;
}
