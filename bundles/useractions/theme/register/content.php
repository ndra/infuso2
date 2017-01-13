<?

<form class='dAjO02CzQJ' >

    <h1>Регистрация</h1>

    <table>
        <tr>
            <td>Электронная почта</td>
            <td>
                widget("infuso\\cms\\ui\\widgets\\textfield")
                    ->exec();
            </td>
        </tr>
        <tr>
            <td>Пароль</td>
            <td>
                widget("infuso\\cms\\ui\\widgets\\textfield")
                    ->exec();
            </td>
        </tr>
        <tr>
            <td>Повтор пароля</td>
            <td>
                widget("infuso\\cms\\ui\\widgets\\textfield")
                    ->exec();
            </td>
        </tr>
        <tr>
            <td></td>
            <td>
                widget("infuso\\cms\\ui\\widgets\\button")
                    ->submit()
                    ->text("Зарегистрироваться")
                    ->exec();
            </td>
        </tr>        
    </table>
    
    <a href='{action("infuso\\useractions\\controller\\login")->url()}' >Войти</a>

</form>