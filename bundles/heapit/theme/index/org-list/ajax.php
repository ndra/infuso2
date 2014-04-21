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
                        <a href='{$org->url()}' >{$org->title()}</a>
                    </div>
                
                </td>
                
                <td>
                    echo $org->data("phone");
                </td>
                
                <td>
                    echo $org->data("email");
                </td>
            
            </tr>
            
            <tr>
                <td colspan='3' class='links' >
                    foreach($org->employees() as $employee) {
                        <a href='{$employee->url()}' >{$employee->title()}</a>
                    }
                    foreach($org->orgs() as $employee) {
                        <a href='{$employee->url()}' >{$employee->title()}</a>
                    }
                </td>
            </tr>
            
            </tbody>
            
        }
    </table>
</div>