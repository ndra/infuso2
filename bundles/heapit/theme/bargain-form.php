<? 

<div class='qs1t5z7t8d' >
    <table>
        <tr>
            <td><label>Организация</label></td>
            <td>
                $w = new \Infuso\Cms\UI\Widgets\Autocomplete();
                $w->fieldName("orgId");
                $w->value($bargain->data("orgId"));
                $w->title($bargain->pdata("orgId")->title());
                $w->cmd("/infuso/heapit/controller/widget/orgList");
                $w->exec();
                
            </td>
        </tr>
        <tr>
            <td><label>Описание сделки</label></td>
            <td>
                <textarea name='description'>
                    echo e($bargain->data("description"));
                </textarea>
            </td>
        </tr>
        <tr>
            <td>Сумма</td>
            <td>
                $w = new \Infuso\Cms\UI\Widgets\Textfield();
                $w->fieldName("amount");
                $w->value($bargain->data("amount"));
                $w->exec();
                //<input  type='text' name='amount' value='{e($bargain->data("amount"))}'>
            </td>
        </tr>
        <tr>
            <td><label>Статус</label></td>
            <td>
                <select name='status'>
                    
                    foreach(\Infuso\Heapit\Model\Bargain::enumStatuses() as $status=>$title){
                        $selected = "";
                        if($bargain->data("status") == $status){
                            $selected = "selected";    
                        }
                        <option $selected value='$status'>$title</option>        
                    }
                </select>
            </td>
        </tr>
        <tr class="refusalDescription">
            <td>Причина отказа</td>
            <td>
                <select name='refusalDescription'>
                    foreach(\Infuso\Heapit\Model\Bargain::enumRefusalDescription() as $status=>$title){
                        $selected = "";
                        if($bargain->data("refusalDescription") == $status){
                            $selected = "selected";    
                        }
                        <option value='$status' $selected>$title</option>        
                    }
                </select>
            </td>
        </tr>
        <tr>
            <td><label>Когда связаться</label></td>
            <td>
                $w = new \Infuso\Cms\UI\Widgets\Datepicker;
                $w->fieldName("callTime");
                $w->value($bargain->data("callTime"));
                $w->exec();
            </td>
        </tr>
        <tr >
            <td><label>Ответственный</label></td>
            <td>
                $w = new \Infuso\Heapit\Widget\UserChooser;
                $w->fieldName("userId");
                $w->value($bargain->data("userId"));
                $w->exec();
            </td>
        </tr>
        <tr>
            <td></td>
            <td>
                <input type='submit' value='{$bargain->exists() ? "Сохранить" : "Создать"}' />
            </td>
        </tr>
    </table>  
</div>