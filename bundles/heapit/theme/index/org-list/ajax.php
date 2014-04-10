<? 

<div class='bzcw5kluwu' >
    foreach($orgs as $org) {
        <div class='item' >
            <a href='{$org->url()}' >{$org->title()}</a>
        </div>
    }
</div>