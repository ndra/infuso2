<? 

<div class='qs1t5z7t8d' >
    <form class='bargian-form-bsszqf8kse'>
        <table>
            <tr>
                <td><label>Название сделки</label></td>
                <td><input name='title' value='{e($bargain->data("title"))}'></td>
            </tr>
            <tr>
                <td><label>Организация</label></td>
                <td>
                    $w = new \Infuso\Heapit\Widget\Autocomplete;
                    $w->fieldName("orgID");
                    $w->value($bargain->data("orgID"));
                    $w->title($bargain->pdata("orgID")->title());
                    $w->serviceUrl("/infuso/heapit/controller/widget/orgList");
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
                <td><label>Сумма</label></td>
                <td><input name='amount' value='{e($bargain->data("amount"))}'></td>
            </tr>
            <tr>
                <td><label>Статус</label></td>
                <td>
                    <select name='status'>
                        foreach(\Infuso\Heapit\Model\Bargain::enumStatuses() as $status=>$title){
                            <option value='$status'>$title</option>        
                        }
                    </select>
                </td>
            </tr>
            <tr class="refusalDescription">
                <td><label>Причина отказа</label></td>
                <td>
                    <textarea name='refusalDescription'/>
                        echo e($bargain->data("refusalDescription"));
                    </textarea>
                </td>
            </tr>
            <tr>
                <td><label>Когда связаться</label></td>
                <td>
                    $w = new \Infuso\Heapit\Widget\Datepicker;
                    $w->fieldName("callTime");
                    $w->value($bargain->pdata("callTime")->num());
                    $w->exec();
                </td>
            </tr>
            <tr >
                <td><label>Ответственный</label></td>
                <td>
                    $w = new \Infuso\Heapit\Widget\UserChooser;
                    $w->fieldName("userID");
                    $w->value($bargain->data("userID"));
                    $w->exec();
                </td>
            </tr>
            <tr>
                <td></td>
                <td><input type='submit' value='Создать' /></td>
            </tr>
        </table>
    </form>
</div>