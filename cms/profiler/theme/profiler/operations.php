<?

<div class='glass' >

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
                        
                            uasort($keys, function($a, $b) {
                                $d = $b["time"] - $a["time"];
                                if($d > 0) {
                                    return 1;
                                }
                                if($d < 0) {
                                    return -1;
                                }
                                return 0;
                            }); 
                        
                            foreach($keys as $key => $val) {
                                <span style='display:inline-block;width:30px;' >{$val[count]}</span>
                                $time = round($val["time"], 6);
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