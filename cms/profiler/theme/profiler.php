<?

<div class='nw5bny9hxyu6' >

    <div class='close' >&times;</div>
    
    <div class='glass' >

        exec("main");
        
        //exec("milestones");

        <table class='t1' >    
            foreach($data["log"] as $group => $items) {
                <tr>
        
                    <td class='title'>$group</td>
        
                    <td>
                        foreach($items as $operation => $params) {
            
                            $time = number_format($params["time"],6);                    
                            $keys = $params["keys"];
                            
                            $n = 0;
                            foreach($keys as $key) {
                                $n += $key["count"];
                            }              
            
                            <div class='a' >
                                <span>$operation</span>
                                <span>$n</span>
                                <span>$time sec.</span>
                            </div>
                            
                            <div class='b' >
                                foreach($keys as $key=>$val) {
                                    <span style='display:inline-block;width:30px;' >{$val[count]}</span>
                                    $time = round($val["time"],6);
                                    <span style='display:inline-block;width:60px;' >{$time}</span>
                                    echo " — $key<br/>";
                                }
                            </div>
                        }
                    </td>
                    
                </tr>
        
            }
            
        </table>
    
    </div>
    
    exec("server");
    
</div>