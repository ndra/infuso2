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
                    $w->serviceUrl("/infuso/heapit/controller/widget/orgList");
                    $w->exec();
                </td>
            </tr>
            <tr>
                <td><label>Описание сделки</label></td>
                <td>
                    <textarea>
                    </textarea>
                </td>
            </tr>
            <tr>
                <td><label>Сумма</label></td>
                <td><input name='description' ></td>
            </tr>
            <tr>
                <td><label>Статус</label></td>
                <td>
                    <select>
                        <option>Новая</option>
                        <option>Переговоры</option>
                        <option>Заключен договор</option>
                        <option>Отказ</option>
                    </select>
                </td>
            </tr>
            <tr>
                <td><label>Причина отказа</label></td>
                <td><input name='description' ></td>
            </tr>
            <tr>
                <td><label>Когда связаться</label></td>
                <td><input name='description' ></td>
            </tr>
            <tr>
                <td><label>Ответственный</label></td>
                <td><input name='description' ></td>
            </tr>
            <tr>
                <td></td>
                <td><input type='submit' value='Создать' /></td>
            </tr>
        </table>
    </form>
</div>