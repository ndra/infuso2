<? 

admin::header();

<div class='w55x5kpuq0' >

    <h1>События зарегистрированные в системе</h1>
    <div style='margin-bottom:20px;' >Заголовком указывается имя события, ниже идет список обработчиков типа Класс::Метод</div>

    foreach(mod::service("classmap")->classmap("handlers") as $event => $handlers) {
        <div class='event' >
            <div class='name' >{$event}</div>
            foreach($handlers as $handler) {
                <div class='handler' >{$handler}</div>
            }
        </div>
    }
</div>

admin::footer();