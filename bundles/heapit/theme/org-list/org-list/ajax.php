<? 

<div class='bzcw5kluwu' >
    <table>
        foreach($orgs as $org) {
        
            <tbody>
        
            <tr>
            
                <td>
                    $icon = "factory";
                    
                    if($org->data("person")) {
                        $icon = "user";
                    }
                    
                    <div class='item $icon' >
                        <a href='{$org->url()}' target='_blank' >{$org->title()}</a>
                    </div>
                
                </td>
                
                <td>
                    echo $org->data("phone");
                </td>
                
                <td>
                    $email = $org->data("email");
                    <a href='mailto:{$email}' target='_blank' >{$email}</a>
                </td>
            
            </tr>
            
            <tr>
                <td colspan='3' class='links' >
                    foreach($org->employees() as $employee) {
                        <a href='{$employee->url()}' target='_blank' >{$employee->title()}</a>
                    }
                    foreach($org->orgs() as $employee) {
                        <a href='{$employee->url()}' target='_blank' >{$employee->title()}</a>
                    }
                </td>
            </tr>
            
            </tbody>
            
        }
    </table>
</div>