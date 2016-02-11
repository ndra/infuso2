<? 

<table>
    <tr>
        <td>
            <div>
                echo "generated: ".round($data["variables"]["time"], 2)." sec.";
            </div>
        </td>
        
        <td>
            
        </td>
        
        <td>
            echo "Page size : ".\util::bytesToSize1000($data["variables"]["contentSize"]);
        </td>
        
        <td>
            echo "Memory: ".\util::bytesToSize1000($data["variables"]["memory-peak"])." / ".$data["variables"]["memory-limit"];
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