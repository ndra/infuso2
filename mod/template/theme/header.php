<?

<!DOCTYPE html>
<html>
    <head>
        <meta http-equiv='Content-Type' content='text/html; charset=utf-8' />
        
        // Добавляем <title>
        $title = e(app()->tm()->param("head/title"));
        head("<title>{$title}</title>");
        
        // Добавляем noindex
        if(app()->tm()->param("head/noindex")) {
            head("<meta name='ROBOTS' content='NOINDEX,NOFOLLOW' >");
        }
        
        // Добавляем хэд
        if(app()->tm()->param("head/insert")) {
            head(app()->tm()->param("head/insert"));
        }
        
        echo \tmp_delayed::add(array(
            "class" => "infuso\\template\\processor",
            "method" => "headInsert",
            "priority" => 1000,
        ));
        
    </head>
<body>