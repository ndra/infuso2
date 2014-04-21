<? 

<div class='payment-vlj855earc' >
    <form class='payment-form-rxuwp132pd'>
        <table>

            <tr>
                <td><label>Организация</label></td>
                <td>
                    $w = new \Infuso\Cms\UI\Widgets\Autocomplete;
                    $w->fieldName("orgId");
                    $w->value($payment->data("orgId"));
                    $w->title($payment->pdata("orgId")->title());
                    $w->cmd("/infuso/heapit/controller/widget/orgList");
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
                <td>
                    $w = new \Infuso\Cms\UI\Widgets\Textfield();
                    $w->fieldName("amount");
                    $w->value($payment->data("income") + $payment->data("expenditure"));
                    $w->exec();
                </td>
            </tr> 
            <tr>
                <td></td>
                <td>
                
                    $id = \util::id();
                    $inject = $payment->data("income") > 0 ? "checked" : "";
                    <input name='direction' value='income' id='{$id}' type='radio' $inject >
                    <label for='{$id}' style='margin-right:10px;' >Приход</label>
                    
                    $inject = $payment->data("expenditure") > 0 ? "checked" : "";
                    $id = \util::id();
                    <input name='direction' value='expenditure' id='{$id}' type='radio' $inject >
                    <label for='{$id}' >Расход</label>
                    
                </td>
            </tr>          
            <tr>
                <td></td>
                <td>
                    <br/>
                    <input type='submit' value='Создать' />
                </td>
            </tr>
        </table>
    </form>
</div>