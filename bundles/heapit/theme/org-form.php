<? 

<div class='m69716bx32' >

    <table>
        <tr>
            <td>ФИО / Название</td>
            <td><input type='text' name='title' value='{e($org->data("title"))}' ></td>
        </tr>
        <tr>
            <td></td>
            <td>
                helper("<input type='checkbox' name='org'  >")
                    ->attr("checked",true)
                    ->exec();
                <label>Организация</label>                
            </td>
        </tr>
        <tr>
            <td>Телефон</td>
            <td><input type='text' name='phone' ></td>
        </tr>
        <tr>
            <td>Сайт</td>
            <td><input type='text' name='url' ></td>
        </tr>
        <tr>
            <td>Электропочта</td>
            <td><input type='text' name='email' ></td>
        </tr>
        <tr>
            <td>ICQ</td>
            <td><input type='text' name='icq' ></td>
        </tr>
        <tr>
            <td>Скайп</td>
            <td><input type='text' name='skype' ></td>
        </tr>        
        <tr>
            <td>Кто привел</td>
            <td>
                $w = new \Infuso\Heapit\Widget\Autocomplete;
                $w->fieldName("referral");
                $w->serviceUrl("/infuso/heapit/controller/widget/orgList");
                $w->exec();
            </td>
        </tr> 
        <tr>
            <td></td>
            <td><input type='submit' value='Создать' /></td>
        </tr>
        
    </table>

</div>