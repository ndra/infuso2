<? 

<div class='hk5yt7oqut' data:userid='{$user->id()}' >

    <h2>Изменение пароля</h2>
    
    <form class='change-form' >
        <div style='margin-bottom:20px;' >
            widget("\\infuso\\cms\\ui\\widgets\\textfield")
                ->placeholder("Пароль")
                ->fieldName("password")
                ->attr("type", "password")
                ->exec();            
            widget("\\infuso\\cms\\ui\\widgets\\textfield")                
                ->placeholder("Повтор пароля")
                ->fieldName("passwordConfirmation")
                ->attr("type", "password")
                ->exec();
        </div>
        <input type='button' class='g-button save' value='Сохранить' />
        <input type='button' class='g-button cancel' value='Отмена' />
    </form>
        
    <input type='button' class='g-button change' value='Изменить' />
    
</div>