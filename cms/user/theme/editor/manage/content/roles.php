<? 

<div class='d4itmgyx0b' data:userid='{$user->id()}' >
    <h2>Роли</h2>
    <select class='g-input' >
        $roles = \Infuso\User\Model\Role::all();
        foreach($roles as $role) {
            <option>{$role->title()}</option>
        }
    </select>
    
    exec("ajax");
    
</div>