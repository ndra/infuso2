<?

<form class='J9ow0NXLJH' >

    <h1>Восстановление пароля</h1>

    <table>
        <tr>
            <td>Электронная почта</td>
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
                    ->text("Восстановить")
                    ->exec();
            </td>
        </tr>        
    </table>
    
    <a href='{action("infuso\\useractions\\controller\\register")->url()}' >Регистрация</a>

</form>