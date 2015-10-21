<?

if($poll->exists()) {    

    echo "<form>";
    echo "<h2>{$poll->data('title')}</h2>";
    
    switch($poll->data("mode")) {
        case 1:
            foreach($poll->options() as $option) {
                echo "<div class='oih93un-optionContainer'>";
                $id = util::id();
                echo "<input type='radio' id='$id' name='option' value='{$option->id()}' >";
                echo "<label for='$id' >";
                echo $option->title();
                echo "</label>";
                echo "</div>";
            }
            break;
        case 2:
            foreach($poll->options() as $option) {
                echo "<div class='oih93un-optionContainer'>";
                $id = util::id();
                echo "<input type='checkbox' id='$id' name='{$option->id()}' value='1' >";
                echo "<label for='$id' >";
                echo $option->title();
                echo "</label>";
                echo "</div>";
            }
            break;
    }
    
    // Скрытое поле с id голосования
    echo "<input type='hidden' name='pollId' value='{$poll->id()}' />";    
        
    // Обязательно оставьте класс urxp1-submit, иначе скрипт отправки не сработает
    echo "<input class='urxp1-submit' type='button' value='Ответить' >";
    echo "</form>";
    
} else {
    echo "Нет активных голосований";
}