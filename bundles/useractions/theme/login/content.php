<?

<form class='Y8y9HPBfXA' >

    <h1>Вход</h1>

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
            <td></td>
            <td>
                widget("infuso\\cms\\ui\\widgets\\button")
                    ->submit()
                    ->text("Войти")
                    ->exec();
            </td>
        </tr>        
    </table>
    
    <div class='actions' >
        <a href='{action("infuso\\useractions\\controller\\register")->url()}' >Регистрация</a>
        <a href='{action("infuso\\useractions\\controller\\recovery")->url()}' >Я забыл пароль</a>
    </div>

</form>