<? 

<div class='jgaz87ie6e' data:userid='{$user->id()}' >
    <h2>Изменение электронной почты</h2>
    widget("\\infuso\\cms\\ui\\widgets\\textfield")
        ->value($user->data("email"))
        ->fieldName("newEmail")
        ->exec();
    <input type='button' class='g-button change' value='Изменить' />
</div>