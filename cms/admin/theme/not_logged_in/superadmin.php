<?

<form method='post' >

    <input type='hidden' name='cmd' value='infuso/core/superadmin/login' />

    widget("Infuso\\CMS\\UI\\Widgets\\textfield")
        ->placeholder("Технический пароль")
        ->fieldName("password")
        ->value($_REQUEST["password"])
        ->exec();
        
    widget("Infuso\\CMS\\UI\\Widgets\\Button")
        ->text("Войти")
        ->attr("type", "submit")
        ->exec();
            
</form>