<? 

<div class='qs1t5z7t8d' >
    <form class='bargian-form-bsszqf8kse'>
        <table>
            <tr>
                <td><label>Название сделки</label></td>
                <td><input name='title' ></td>
            </tr>
            <tr>
                <td><label>Организация</label></td>
                <td>
                    $w = new \Infuso\Heapit\Widget\Autocomplete;
                    $w->fieldName("orgID");
                    $w>
                    $w->serviceUrl("/infuso/heapit/controller/widget/orgList");
                    $w->exec();
                </td>
            </tr>
            <tr>
                <td><label>Описание сделки</label></td>
                <td>
                    <textarea name='description'>
                    </textarea>
                </td>
            </tr>
            <tr>
                <td><label>Сумма</label></td>
                <td><input name='amount' ></td>
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
                <td><textarea name='refusalDescription'/></textarea></td>
            </tr>
            <tr>
                <td><label>Когда связаться</label></td>
                <td>
                    $w = new \Infuso\Heapit\Widget\Datepicker;
                    $w->param("callTime");
                    $w->exec();
                </td>
            </tr>
            <tr >
                <td><label>Ответственный</label></td>
                <td><input name='userID' ></td>
            </tr>
            <tr>
                <td></td>
                <td><input type='submit' value='Создать' /></td>
            </tr>
        </table>
    </form>
</div>