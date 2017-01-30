<?

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

// Добавляем меты
foreach(array("head/keywords","head/description") as $name) {
    $val = app()->tm()->param($name);
    if($val) {
		$name = str_replace("head/","",$name);
        head("<meta name='{$name}' content='{$val}' />\n");
    }
}

echo app()->tm()->conveyor()->exec(array (
    "singlecss" => "link",
    "packcss" => "link",
    "singlejs" => false,
    "packjs" => false,
    "script" => false,
    "head" => true,
));