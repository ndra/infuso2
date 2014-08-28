<?

$tasks = \Infuso\Board\Model\Task::all()->withMyParticipation();

<div class='myywnW2kwO' >
    foreach($tasks as $task) {
        exec("/board/shared/task-sticker", array(
            "task" => $task,
        ));
    }
</div>