<? 

<div class='bzcw5kluwu' >
    foreach($orgs as $org) {
        $icon = "factory";
        if($org->data("person")){
            $icon = "user";
        }
        <div class='item $icon' >
            <a href='{$org->url()}' >{$org->title()}</a>
        </div>
    }
</div>