<?

<form class='Uu8qdmPUCT' data:token='{$token}' >

    <h1>Восстановление пароля</h1>
    
    <div class='ajax-container' >

        <table>
            <tr>
                <td>Новый пароль</td>
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
                        ->text("Восстановить")
                        ->exec();
                </td>
            </tr>        
        </table>
    
    </div>
    
    $form = new \Infuso\Useractions\Form\NewPassword();
    $builder = $form->builder();
    $builder->bind(".Uu8qdmPUCT");

</form>