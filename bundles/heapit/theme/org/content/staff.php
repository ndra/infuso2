<? 

<div class='staff-x1lsfa0a64l' >
    <div class="controls">
        //<div class="" ='{}'></div>
        $w = new \Infuso\Heapit\Widget\Button();
        $w->tag("button");
        $w->addClass("add");
        $w->attr("data:orgid", $org->id());
        $w->attr("title", "Добавить нового сотрудника");
        $w->param("icon", $this->bundle()->path()."/res/img/staff/plus.png");
        $w->exec();
        exec("addExisted");
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
                <td>
                    <div class='delete'>Удалить</div>    
                </td>
            </tr>
        </thead>
        foreach($org->occupations() as $occ){
            exec("item", array("occ"=>$occ));
        }
    </table>
</div>