<?

<!DOCTYPE html>
<html>
    <head>
        <meta http-equiv='Content-Type' content='text/html; charset=utf-8' />
        
        /*echo \tmp_delayed::add(array(
            "class" => "infuso\\template\\processor",
            "method" => "headInsert",
            "priority" => 1000,
        )); */
        
        tmp("insert")->delayed(1000);
        
    </head>
<body>