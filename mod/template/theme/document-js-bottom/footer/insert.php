<?

echo app()->tm()->conveyor()->exec(array (
    "singlecss" => false,
    "packcss" => false,
    "singlejs" => "link",
    "packjs" => "link",
    "script" => "link",
    "head" => false,
));