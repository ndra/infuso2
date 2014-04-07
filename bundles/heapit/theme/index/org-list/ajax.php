<? 

$orgs = \Infuso\Heapit\Model\Org::all();
foreach($orgs as $org) {
    <div>
        <a href='{$org->url()}' >{$org->title()}</a>
    </div>
}