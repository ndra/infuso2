<? 

<div class='xularn5ng1' >

    if($_POST["query"]) {
        try {
        
            $result = \mod::service("db")->query($_POST["query"])->exec();
            
            <table class='result' >
                
                foreach($result->fetchAll() as $rowIndex => $row) {
                
                    // Заголовок таблицы
                    if($rowIndex == 0) {
                        <thead>
                            <tr>
                                foreach($row as $key => $val) {
                                    <td>{$key}</td>
                                }
                            </tr>
                        </thead>
                    }
                
                    <tr>                
                        foreach($row as $key => $val) {
                            <td>
                                echo \infuso\util\util::str($val)->esc();
                            </td>        
                        }
                    </tr>
                }
                
            </table>
            
        } catch(\Exception $ex) {
            app()->msg($ex->getMessage(),1);
        }
    }
    
</div>