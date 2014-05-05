<?

add("center", "/board/shared/task-list", array(
    "enbaleToolbar" => 1,
    "status" => $status,
));
add("right", "/board/shared/task-list");
exec("/board/layout");