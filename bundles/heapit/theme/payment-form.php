<? 

<div class='payment-vlj855earc' >
    <table>
        <tr>
            <td><label>Дата</label></td>
            <td>
                $w = new \Infuso\Cms\UI\Widgets\Datepicker();
                $w->fieldName("date");
                $w->value($payment->data("date"));
                $w->exec();
            </td>
        </tr> 
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
            <td style='padding-bottom: 30px;'>Назначение платежа</td>
            <td style='padding-bottom: 30px;' >
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
                <span style='margin-left:20px;'>
                $statuses = \Infuso\Heapit\Model\Payment::enumStatuses();
                foreach($statuses as $val => $label){
                    $inject = $payment->data("status") == $val ? "checked" : "";
                    $id = \util::id();
                    <input name='status' value='{$val}' id='{$id}' type='radio' $inject >
                    <label for='{$id}' style='margin-right:10px;' >$label</label>        
                }
                </span>
            </td>
        </tr> 
        
        // Направление платежа ( 1 - приход,  -1 - расход)
        $direction = $payment->data("income") - $payment->data("expenditure") >= 0 ? 1 : -1;
        
        <tr>
            <td></td>
            <td>
            
                $id = \util::id();
                $inject = $direction > 0 ? "checked" : "";
                <input name='direction' value='income' id='{$id}' type='radio' $inject >
                <label for='{$id}' style='margin-right:10px;' >Приход</label>
                
                $inject = $direction < 0 ? "checked" : "";
                $id = \util::id();
                <input name='direction' value='expenditure' id='{$id}' type='radio' $inject >
                <label for='{$id}' >Расход</label>
                
            </td>
        </tr>    
        
        <tr>
            <td>Статья расходов / доходов</td>
            <td>
            
                // Статьи додохдов
                
                $w = new \Infuso\Cms\UI\Widgets\Select();
                $w->fieldName("group");  
                $w->addClass("group-income");    
                if($direction < 0) {
                    $w->attr("disabled" ,true);
                }
                $values = array();
                foreach(\Infuso\Heapit\Model\PaymentGroup::all()->eq("type",0)->limit(0) as $group) {
                    $values[$group->id()] = $group->title();
                }
                $w->values($values);
                $w->value($payment->data("group"));
                $w->exec();
                
                // Статьи расходов
                
                $w = new \Infuso\Cms\UI\Widgets\Select();
                $w->fieldName("group");                    
                $w->addClass("group-expenditure");
                if($direction > 0) {
                    $w->attr("disabled" ,true);
                }
                $values = array();
                foreach(\Infuso\Heapit\Model\PaymentGroup::all()->eq("type",1)->limit(0) as $group) {
                    $values[$group->id()] = $group->title();
                }
                $w->values($values);
                $w->value($payment->data("group"));
                $w->exec();
                
            </td>
        </tr> 
        <tr>
            <td></td>
            <td>
                <br/>

                $w = new \Infuso\Cms\UI\Widgets\Button();
                $w->text($payment->exists() ? "Сохранить" : "Создать");
                $w->attr("type", "submit");
                $w->exec();
                
                $action = action("infuso\\heapit\\controller\\payment","add", array("copy" => $payment->id()));
                <a href='{$action}' >Скопировать</a>
               
            </td>
        </tr>
    </table>
</div>