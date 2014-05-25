<?

<!DOCTYPE html>
<html>
    <head>
        <meta http-equiv='Content-Type' content='text/html; charset=utf-8' />
        
        // Добавляем <title>
        $title = e(tmp::param("head/title"));
        tmp::head("<title>{$title}</title>");
        
        // Добавляем noindex
        if(tmp::param("head/noindex")) {
            tmp::head("<meta name='ROBOTS' content='NOINDEX,NOFOLLOW' >");
        }
        
        // Добавляем noindex
        if(tmp::param("head/insert")) {
            tmp::head(tmp::param("head/insert"));
        }
        
        echo \tmp_delayed::add(array(
            "class" => "tmp",
            "method" => "headInsert",
            "priority" => 1000,
        ));
        
    </head>
<body>