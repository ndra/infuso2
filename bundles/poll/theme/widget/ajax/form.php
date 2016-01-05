<?

if($poll->exists()) {    

    <form class='GCADRNLmXZ' data:id='{$poll->id()}' >
        <h2>{$poll->data('title')}</h2>
        
        switch($poll->data("mode")) {
            case \Infuso\Poll\Model\Poll::MODE_SINGLE:
                foreach($poll->options() as $option) {
                    <div class='oih93un-optionContainer'>
                        $id = \Infuso\Util\Util::id();
                        <input type='radio' id='{$id}' name='option' value='{$option->id()}' />
                        <label for='{$id}' >{$option->title()}</label>
                    </div>
                }
                break;
            case 2:
                foreach($poll->options() as $option) {
                    <div class='oih93un-optionContainer'>
                        $id = \Infuso\Util\Util::id();
                        <input type='checkbox' id='$id' name='{$option->id()}' value='1' >
                        <label for='$id' >{$option->title()}</label>
                    </div>
                }
                break;
        }

        // Обязательно оставьте класс urxp1-submit, иначе скрипт отправки не сработает
        <input class='submit' type='button' value='Ответить' >
        
    </form>
    
} else {
    echo "Нет активных голосований";
}