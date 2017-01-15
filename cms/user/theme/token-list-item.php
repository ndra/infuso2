<? 

$token = $editor->item();


<div class='RDqZHFl7c0 list-item' data:id='{$editor->id()}'  >
    <div class='token' >{$token->data("token")}</div>
    <div class='date' >{$token->pdata("start")->num()}</div>
    <div class='date' >{$token->data("lifetime")}</div>
    <div class='date' >{$token->pdata("expires")->num()}</div>
    <div class='type' >{$token->data("type")}</div>
</div>