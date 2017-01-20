<?

<form class='dAjO02CzQJ' >

    <h1>Регистрация</h1>

    <table>
        <tr>
            <td>Электронная почта</td>
            <td>
                widget("infuso\\cms\\ui\\widgets\\textfield")
                    ->fieldName("email")
                    ->exec();
                <div class='error-email error' ></div>
            </td>
        </tr>
        <tr>
            <td>Пароль</td>
            <td>
                widget("infuso\\cms\\ui\\widgets\\textfield")
                    ->fieldName("password")
                    ->exec();
                <div class='error-password error' ></div>
            </td>
        </tr>
        <tr>
            <td>Повтор пароля</td>
            <td>
                widget("infuso\\cms\\ui\\widgets\\textfield")
                    ->fieldName("password2")
                    ->exec();
                <div class='error-password2 error' ></div>
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
    
    $form = new \Infuso\Useractions\Form\Register();
    $builder = $form->builder();
    $builder->bind(".dAjO02CzQJ");

</form>