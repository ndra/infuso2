<?

<form class='J9ow0NXLJH' >

    <h1>Восстановление пароля</h1>

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
    
    $form = new \Infuso\Useractions\Form\Recovery();
    $builder = $form->builder();
    $builder->bind(".J9ow0NXLJH");

</form>