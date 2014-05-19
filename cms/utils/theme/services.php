<? 

admin::header();

<div class='owr2pqc8y2' >

    <h1>Службы, зарегистрированные в системе</h1>

    foreach(mod::service("classmap")->map("infuso\\core\\service") as $class) {
        <div class='service' >
            <div style='margin-bottom:10px;' >
                <span class='name' >{$class::defaultService()}</span>
                <span class='class' >{$class}</span>
            </div>
            <div class='comment' >
                echo $class::inspector()->docComment();
            </div>
        </div>
    }
</div>

admin::footer();