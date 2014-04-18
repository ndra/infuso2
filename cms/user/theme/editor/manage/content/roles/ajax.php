<? 

<div class='zrtlp4pj2i' data:userid='{$user->id()}'  >

    <div class='roles' >
        foreach($user->roles() as $role) {
            <div class='role' >
                echo $role->title();
            </div>
        }
    </div>
    
    <input type='button' class='g-button add' value='Добавить роль' />   
    
    <div class='add-role-container' >
    
        <select class='g-input role-select' style='margin-right:10px;' >
            $roles = \Infuso\User\Model\Role::all();
            foreach($roles as $role) {
                <option value='{$role->code()}' >{$role->title()}</option>
            }
        </select>
        
        <input type='button' class='g-button ok' value='Добавить' />
        <input type='button' class='g-button cancel' value='Отмена' />
    
    </div>    
    
</div>