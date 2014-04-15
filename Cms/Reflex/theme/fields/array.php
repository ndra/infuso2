<? 

<div class='vehszhivmz' >

    $val = $field->value();
    <input type='hidden' name='{$field->name()}' value='{$val}' />

    <table style='width:100%;' >
        <tr>
            <td class='items' style='width:100%;vertical-align:middle;' >
                echo "Контент";
            </td>
            <td style='white-space:nowrap;' >        
                <div class='toolbar' >
                    <div class='button button-add' >Добавить</div>
                    <div class='button button-delete' >Удалить</div>
                </div>
            </td>
        </tr>
    </table>
</div>
