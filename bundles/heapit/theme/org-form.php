<? 

<div class='m69716bx32' >

    <table>
        <tr>
            <td>ФИО / Название</td>
            <td><input type='text' name='title' value='{e($org->data("title"))}' class='g-input-long' ></td>
        </tr>
        <tr>
            <td></td>
            <td>
                $checkboxId = \util::id();
                $checkbox = helper("<input id='{$checkboxId}' type='checkbox' name='person'  >");                    
                if($org->data("person")) {
                    $checkbox->attr("checked",true);
                }
                $checkbox->exec();
                <label for='{$checkboxId}' >Частное лицо</label>                
            </td>
        </tr>
        <tr>
            <td>Телефон</td>
            <td><input type='text' name='phone' value='{e($org->data("phone"))}' ></td>
        </tr>
        <tr>
            <td>Сайт</td>
            <td><input type='text' name='url' value='{e($org->data("url"))}' ></td>
        </tr>
        <tr>
            <td>Электропочта</td>
            <td><input type='text' name='email' value='{e($org->data("email"))}' ></td>
        </tr>
        <tr>
            <td>ICQ</td>
            <td><input type='text' name='icq' value='{e($org->data("icq"))}' ></td>
        </tr>
        <tr>
            <td>Скайп</td>
            <td><input type='text' name='skype' value='{e($org->data("skype"))}' ></td>
        </tr>        
        <tr>
            <td>Кто привел</td>
            <td>
                $w = new \Infuso\Heapit\Widget\Autocomplete;
                $w->fieldName("referral");
                $w->value($org->data("referral"));
                $w->title($org->pdata("referral")->title());
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