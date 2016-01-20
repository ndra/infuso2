<? 

//exec("/reflex/shared/editor-head");

$user = $editor->item();

<table class='eacthazen4' >

    <tr>
    
        <td>

            exec("change-email", array(
                "user" => $user,
            ));
        
        </td>
    
        <td>
            exec("change-password", array(
                "user" => $user,
            ));
        </td>
    </tr>
    <tr>
        
        <td>

            exec("roles", array(
                "user" => $user,
            ));
        
        </td>
    
        <td>
            exec("login-as", array(
                "user" => $user,
            )); 
        </td>
    
    </tr>
</table>