<?

add("center", "/board/shared/task-list", array(
    "enbaleToolbar" => 1,
    "status" => $status,
));

add("right", "/board/shared/task-list", array(
    "status" => \Infuso\Board\Model\TaskStatus::STATUS_IN_PROGRESS,
));

exec("/board/layout");