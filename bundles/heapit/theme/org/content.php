<? 

<form class='o64rds6rlp' style='padding:30px;' data:orgid='{$org->id()}' >

    <div class='parents' >
        foreach($org->orgs() as $org2) {
            <a href='{$org2->url()}' >{$org2->title()}</a>
        }
    </div>

    <h1 class='g-header' >Контрагент «{e($org->data("title"))}»</h1>
    exec("/heapit/org-form");
    exec("staff");
</form>