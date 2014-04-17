<? 

$type= $submit ? "type='submit'" : ""; 

$button = new \Infuso\Template\Helper();
$button->params($this->params());

$button->begin();
    // Если ва    
    // :-D
    if($icon) {        
        <img class="icon" src='{$icon}'>
    }
    if($title && $icon){
        $title = "&nbsp;".$title;
    }
    echo $title;

$button->end();
