<? 

$user = app()->user();  
   
<form class='iv09v31m1i' >

    <h1 class='g-header' >Настройки</h1>

    <table>
        <tr>
            <td>Никнейм</td>
            <td>
                widget("infuso\\cms\\ui\\widgets\\textfield")
                    ->value($user->data("nickName"))
                    ->fieldName("nickName")
                    ->exec();
            </td>
        </tr>
        <tr>
            <td></td>
            <td>
                <input type='submit' value='Сохранить' >
            </td>
        </tr>
    </table>  

</form>