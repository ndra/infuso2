<? 

header();

<form class='crrmu5wd20' method='post' >    
        
    widget("\\infuso\\cms\\ui\\widgets\\textfield")
        ->placeholder("Логин")
        ->fieldName("email")
        ->exec();
        
    widget("\\infuso\\cms\\ui\\widgets\\textfield")
        ->placeholder("Пароль")
        ->fieldName("password")
        ->attr("type","password")
        ->exec();  
    
    <input type='hidden' name='cmd' value='infuso/user/controller/login' />          
    <input type='submit' class='g-button' value='Войти' />
    
</form>

footer();