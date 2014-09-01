<? 

$user = $editor->item();

<div class='x2b84c6nxat list-item' data:id='{$editor->id()}'  >
    <table>
        <tr>
            <td>
                $preview = $user->userpic()->preview(32,32);
                <div class='userpic' style='background:url($preview)' ></div>
            </td>
            <td>
                <div class='title' ><a href='{$editor->url()}' >{$user->title()}</a></div>
                <div class='roles' >
                    $roles = array();
                    foreach($user->roles() as $role) {
                        $roles[] = "<span class='role' >{$role->title()}</span>";
                    }
                    echo implode(", ", $roles);
                </div>
            </td>
            <td class='sort-handle' >
                echo 1111;
            </td>
        </tr>
    </table>
</div>