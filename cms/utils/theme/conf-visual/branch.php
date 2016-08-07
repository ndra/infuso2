<?

<div class='ySKppTIlwg' >
    foreach($data as $key => $val) {
        <div>
            echo $key;
            
            if(is_array($val) && $val["item"] !== true) {
                <div style='padding-left: 20px;' >
                    $newParents = $parents;
                    $newParents[] = $key;
                    exec("../branch", array(
                        "data" => $val,
                        "parents" => $newParents,
                    ));
                </div>
            } else {
                
                if(is_string($val)) {
                    $title = $val;
                    $type = "string";
                    $help = "";
                } else {
                    $title = $val["title"];
                    $type = $val["type"] ?: "string";
                    $help = $val["help"];
                }
                
                $p = $parents;
                $p[] = $key;
                $value = call_user_func_array(array("Infuso\\Core\\Conf", "general"), $p);
                if($value) {
                    <span> <b class='value' >$value</b></span>
                }
                <span class='descr' >&nbsp;&mdash; {$title}<span>
            }
            
        </div>
    }
</div>