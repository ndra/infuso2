<?

if($task->data("group")) {
    exec("group");
} else {
    exec("normal");
}