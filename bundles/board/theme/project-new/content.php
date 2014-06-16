<?

<form style='padding: 50px;' class='jLuIIGVTPp' >
    $project = new \Infuso\Board\Model\Project;
    exec("/board/project-form", array(
        "project" => $project,
    ));
</form>