<? 

<form class='o64rds6rlp' style='padding:30px;' data:orgid='{$org->id()}' >

    foreach($org->orgs() as $org) {
        <a href='{$org->url()}' >{$org->title()}</a>
    }

    <h1 class='g-header' >Контрагент «{e($org->data("title"))}»</h1>
    exec("/heapit/org-form");
    exec("staff");
</form>