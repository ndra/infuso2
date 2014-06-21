<?

$groups = \Infuso\Eshop\Model\Group::all();

foreach($groups as $group) {
    <div>
        <a href='{$group->url()}' >{$group->title()}</a>
    </div>
}