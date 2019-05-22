<?

js($this->bundle()->path()."/res/js/jquery.tablesorter.min.js");

<div class='x0zD0C7SrZE' >

    <div class='ajax-container-heading' >
        exec("ajax-heading");
    </div>
    
    // Сводная таблица ячеек
    exec("cells");
    
    <div class='container' >
        <div class='left' >
            exec("form");
        </div>
        <div class='right'  >
            <div class='preloader' >Загрузка</div>
            <div class='ajax-container-top' >
                exec("ajax-top");
            </div>
        </div>
    </div>
    
    <div class='ajax-container-bottom' >
        exec("ajax-bottom");
    </div>

</div>