<? 

<div class='staff-x1lsfa0a64l' >
    echo "Сотрудники";
    <div class="controls">
        <div class="add" data:orgid='{$org->id()}'></div>
        $w = new \Infuso\Heapit\Widget\Button();
        $w->param("icon", "/heapit/res/img/staff/plus.png");
        $w->exec();
    </div>
    <table class="list">
        <thead>
            <tr>
                <td>
                    <div class='fio'>ФИО</div>
                </td>
                <td>
                    <div class='email'>E-mail</div>
                </td>
                <td>
                    <div class='phone'>Телефон</div>    
                </td>
            </tr>
        </thead>
        foreach($org->occupations() as $occ){
            exec("item", array("occ"=>$occ));
        }
    </table>
</div>