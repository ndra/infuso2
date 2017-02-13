<? 

<div class='m69716bx32' >

    <table>
        <tr>
            <td>ФИО / Название</td>
            <td>
                $w = new \Infuso\Cms\UI\Widgets\Textfield();
                $w->value($org->data("title"))
                    ->fieldName("title")
                    ->style("width", 400)
                    ->exec();
            </td>
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
            <td>
                //<input type='text' name='phone' value='{e($org->data("phone"))}' class='g-input-long'>
                $w = new \Infuso\Cms\UI\Widgets\Textfield();
                $w->value($org->data("phone"))
                    ->fieldName("phone")
                    ->style("width", 400)
                    ->exec();
            </td>
        </tr>
        <tr>
            <td>Сайт</td>
            <td>
                //<input type='text' name='url' value='{e($org->data("url"))}' class='g-input-long'>
                $w = new \Infuso\Cms\UI\Widgets\Textfield();
                $w->value($org->data("url"))
                    ->fieldName("url")
                    ->style("width", 400)
                    ->exec();
            </td>
        </tr>
        <tr>
            <td>Электропочта</td>
            <td>
                //<input type='text' name='email' value='{e($org->data("email"))}' class='g-input-long'>
                $w->value($org->data("email"))
                    ->fieldName("email")
                    ->style("width", 400)
                    ->exec();
                
                <span class='mailto' >Написать</span>
            </td>
        </tr>
        <tr>
            <td>ICQ</td>
            <td>
                //<input type='text' name='icq' value='{e($org->data("icq"))}' class='g-input-long'>
                $w->value($org->data("icq"))
                    ->fieldName("icq")
                    ->style("width", 400)
                    ->exec();
            </td>
        </tr>
        <tr>
            <td>Скайп</td>
            <td>
                //<input type='text' name='skype' value='{e($org->data("skype"))}' class='g-input-long'>
                $w->value($org->data("skype"))
                    ->fieldName("skype")
                    ->style("width", 400)
                    ->exec();
            </td>
        </tr>        
        <tr>
            <td>Кто привел</td>
            <td>
                $w = new \Infuso\Cms\UI\Widgets\Combo;
                $w->fieldName("referral");
                $w->value($org->data("referral"));
                $w->title($org->pdata("referral")->title());
                $w->callParams(array("cmd"=>"/infuso/heapit/controller/widget/orgList"));
                $w->exec();
            </td>
        </tr> 
        <tr>
            <td></td>
            <td>
                //<input type='submit' value='{$org->exists() ? "Сохранить" : "Создать"}' />
                widget("infuso\\cms\\ui\\widgets\\button")
                    ->text($org->exists() ? "Сохранить" : "Создать")
                    ->submit()
                    ->exec();
            </td>
        </tr>
        
    </table>

</div>