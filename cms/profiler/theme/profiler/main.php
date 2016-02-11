<? 

<table>
    <tr>
        <td>
            <div>
                echo "generated: ".round(microtime(1)-$GLOBALS["infusoStarted"],2)." sec.";
            </div>
            <div>
                echo "classload: ".round($GLOBALS["infusoClassTimer"],4)." sec.";
            </div>
        </td>
        
        <td>
            
        </td>
        
        <td>
            echo "Page size : ".\util::bytesToSize1000($data["variables"]["contentSize"]);
        </td>
        
        <td>
            echo "Peak memory: ".\util::bytesToSize1000(memory_get_peak_usage())." / ".ini_get("memory_limit");
        </td>
        
        <td>
        echo app()->action()->canonical();
        
        /*$obj = tmp::obj();
        if($obj->exists()) {
            echo " ";
            <a href='{$obj->editor()->url()}' target='_blank' >Редактировать </a>
        } */
        </td>
        
    </tr>
</table>