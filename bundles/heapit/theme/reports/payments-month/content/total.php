<? 

<table class='k0633ep90u' >
    <tr>
        <td>
            <div class='group' >
                <table>
                    <tr>
                        <td style='font-size:24px;' >Доход {$income}&nbsp;р.</td>
                        <td><span class='title' >+&nbsp;План</span>{$incomePlan}&nbsp;р.</td>
                        <td><span class='title' >+&nbsp;Сделки</span>{$bargains}&nbsp;р.</td>
                    </tr>
                    <tr>
                        <td colspan='2' class='plan' >{$income + $incomePlan}&nbsp;р.</td>
                    </tr>
                    <tr>
                        <td colspan='3' class='plan' >{$income + $incomePlan + $bargains}&nbsp;р.</td>
                    </tr>
                </table>
                
            </div>        
        </td>
        
        <td style='text-align: center;' >
            <div class='group' >
                <div style='font-size:24px;margin-bottom: 10px;' >Баланс {$income - $expenditure} р.</div>
                <div><span class='title' >Планируется</span>{$income + $incomePlan - $expenditure - $expenditurePlan} р.</div>
                <div><span class='title' >С учетом сделок</span>{$income + $incomePlan + $bargains - $expenditure - $expenditurePlan} р.</div>
            </div>
        </td>
        
        <td style='text-align: right;' >        
            <div class='group' >
                <table>
                    <tr>
                        <td style='font-size:24px;' >Расход {$expenditure}&nbsp;р.</td>
                        <td><span class='title' >+&nbsp;План</span>{$expenditurePlan}&nbsp;р.</td>
                    </tr>
                    <tr>
                        <td colspan='2' class='plan' >{$expenditure + $expenditurePlan}&nbsp;р.</td>
                    </tr>
                </table>
            </div>        
        </td>
    </tr>
</table>