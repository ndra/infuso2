<? 

<div class='payment-vlj855earc' >
    <form class='payment-form-rxuwp132pd'>
        <table>

            <tr>
                <td><label>Организация</label></td>
                <td>
                    $w = new \Infuso\Heapit\Widget\Autocomplete;
                    $w->fieldName("orgID");
                    $w->value($payment->data("orgID"));
                    $w->title($payment->pdata("orgID")->title());
                    $w->serviceUrl("/infuso/heapit/controller/widget/orgList");
                    $w->exec();
                </td>
            </tr>
            <tr>
                <td><label>Описание сделки</label></td>
                <td>
                    <textarea name='description'>
                        echo e($payment->data("description"));
                    </textarea>
                </td>
            </tr>
            <tr>
                <td><label>Сумма</label></td>
                <td><input name='amount' value='{e($payment->data("amount"))}'></td>
            </tr>          
            <tr>
                <td></td>
                <td><input type='submit' value='Создать' /></td>
            </tr>
        </table>
    </form>
</div>