<?

$groups = \Infuso\Eshop\Model\Group::all()->eq("parent", 0);

<div class='mTDIBqStxW' >
    foreach($groups as $group) {
        <div style='margin-bottom: 20px;' >
            <div class='group'>
                <a href='{$group->url()}' >{$group->title()}</a>
            </div>
            <div class='subgroups' >
                foreach($group->subgroups() as $subgroup) {
                    <a href='{$subgroup->url()}' >{$subgroup->title()}</a> 
                    <span class='n' >{$subgroup->numberOfItems()}<span>
                }
            </div>
        </div>
    }
</div>