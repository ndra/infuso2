<?

<div class='w8ZGLEnALE' >

    <div class='title' >
        <a href='{$cart->plugin("editor")->url()}' >Заказ №{$cart->id()} от {$cart->pdata('submitDatetime')->num()}</a>
    </div>
    
    foreach($cart->scenario("submit")->fields()->editable() as $field) {
        <div><span class='label' >{$field->label()}:</span> {e($field->value())}</div>
    }

</div>
