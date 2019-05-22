mod.init(".zRfYi7ftb9", function() {
    
    if(!window.afmXp7mKNi) {
        google.charts.load('current', {'packages':['corechart']});
        window.afmXp7mKNi = true;
    }

    var $container = $(this);
    var data = JSON.parse($container.find("input").val());
    
    google.charts.setOnLoadCallback(function() {
        var chart = new google.visualization.LineChart($container.find(".chart").get(0));
        chart.draw(google.visualization.arrayToDataTable(data.values), data.options);
    });

});