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
            <td><label>Как узнал о нас</label></td>
            <td>
                $w = new \Infuso\Cms\UI\Widgets\Select();
                $w->fieldName("source");
                $w->value($bargain->data("source"));
                $w->values(\Infuso\Heapit\Model\Bargain::enumSources());
                $w->exec();        
            </td>
        </tr>
        
        <tr>
            <td><label>Описание сделки</label></td>
            <td>
                $w = new \Infuso\Cms\UI\Widgets\Textarea();
                $w->fieldName("description");
                $w->value($bargain->data("description"));
                $w->exec();
            </td>
        </tr>
        <tr>
            <td>Сумма</td>
            <td>
                $w = new \Infuso\Cms\UI\Widgets\Textfield();
                $w->fieldName("amount");
                $w->value($bargain->data("amount"));
                $w->exec();
                
                $w = new \Infuso\Cms\UI\Widgets\Datepicker;
                $w->fieldName("paymentDate");
                $w->clearButton();
                $w->placeholder("Дата оплаты");
                $w->value($bargain->data("paymentDate"));
                $w->exec();
                
                $checkboxId = \util::id();
                $checkbox = helper("<input id='{$checkboxId}' type='checkbox' name='invoiced'  >");                    
                if($bargain->data("invoiced")) {
                    $checkbox->attr("checked",true);
                }
                $checkbox->exec();
                <label for='{$checkboxId}' >Выставлен счет <sup title='Если одновременно существует сделка и выставлен счет (или есть счет в статусе «Планируется»), то сумма в отчете удвоится и отчет станет неправильным. Поэтому можно исключить сделку из отчетов, выставив этот чекбокс.' >?</sup></label>    
                
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
        
        if(!$bargain->exists()) {
            <tr>
                <td><label>Когда связаться</label></td>
                <td>
                
                    $w = new \Infuso\Cms\UI\Widgets\Datepicker;
                    $w->fieldName("callTime");
                    
                    $w->fastDayShifts(array(
                        \util::now()->stamp() => "Сегодня",
                        \util::now()->shiftDay(1)->stamp() => "Завтра",
                        \util::date(strtotime("monday"))->stamp() => "В понедельник",
                        \util::now()->shiftDay(14)->stamp() => "Через две недели",
                    ));
                    
                    $w->clearButton();
                    $w->value($bargain->data("callTime"));
                    $w->exec();
                </td>
            </tr>
        }
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