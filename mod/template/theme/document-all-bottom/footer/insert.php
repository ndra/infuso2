<?

echo app()->tm()->conveyor()->exec(array (
    "singlecss" => "link",
    "packcss" => "link",
    "singlejs" => "link",
    "packjs" => "link",
    "script" => "link",
    "head" => false,
));