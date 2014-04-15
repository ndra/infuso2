<? 
    // Пиздец
    //Согласен ;)
    
    // upd: Вот теперь это реальный пиздец!
    
    // Ну работает же ^-^
    
    // Рефакторил
    
    
$tag = $submit ? "button" : "a";

$type= $submit ? "type='submit'" : ""; 

$button = new tmp_helper_html();
$button->params($this->params());

$button->begin();

    if($upload) {
        $upload = new tmp_helper_html();
        $upload->tag("input");
        $upload->attr("type","file");
        $upload->addClass("file");
        $upload->attr("name", $name);
        $upload->attr("onchange", $onchange);
        $upload->attr("value", $value);
        $upload->exec();
    }

    // Если ва    
    // :-D
    if($icon) {        
        <i class="icon" style="background-image:url({$icon});" ></i>&nbsp;
    }
    
    echo $title;

$button->end();
