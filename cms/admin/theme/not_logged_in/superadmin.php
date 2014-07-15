<?

<form method='post' >

    <input type='hidden' name='cmd' value='infuso/user/controller/login' />

    widget("Infuso\\CMS\\UI\\Widgets\\textfield")
        ->placeholder("Технический пароль")
        ->fieldName("superadmin")
        ->value($_REQUEST["superadmin"])
        ->exec();
        
    widget("Infuso\\CMS\\UI\\Widgets\\Button")
        ->text("Войти")
        ->attr("type", "submit")
        ->exec();
            
</form>