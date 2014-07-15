<?

<div class='PyMdicupCF' >

    $user = app()->user();
    if($user->exists()) {
        
        <div class='item' >
            echo "Вы залогинены как ".app()->user()->email();
        </div>
        
        <div class='item' >
            widget("Infuso\\CMS\\UI\\Widgets\\Button")
                ->addClass("logout")
                ->text("Выйти")
                ->exec();
        </div>
        
    } else {
    
        <form method='post' >
    
            <input type='hidden' name='cmd' value='infuso/user/controller/login' />
        
            <div class='item' >
                widget("Infuso\\CMS\\UI\\Widgets\\textfield")
                    ->placeholder("Электронная почта")
                    ->fieldName("email")
                    ->value($_REQUEST["email"])
                    ->exec();
            </div>
            
            <div class='item'>    
                widget("Infuso\\CMS\\UI\\Widgets\\textfield")
                    ->placeholder("Пароль")
                    ->fieldName("password")
                    ->value($_REQUEST["password"])
                    ->exec();
            </div>
        
            <div class='item'>
                widget("Infuso\\CMS\\UI\\Widgets\\Button")
                    ->text("Войти")
                    ->attr("type", "submit")
                    ->exec();
            </div>
            
        </form>
    }

</div>
