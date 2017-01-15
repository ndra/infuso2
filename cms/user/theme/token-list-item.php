<? 

$token = $editor->item();


<div class='RDqZHFl7c0 list-item' data:id='{$editor->id()}'  >
    <div class='token' >{$token->data("token")}</div>
    <div class='expires' >{$token->pdata("expires")->num()}</div>
    <div class='type' >{$token->data("type")}</div>
</div>