$(function() {

    var container =  $(".bv3vjfvd5n");
    
    container.find("input[type=checkbox]").change(function() {
        mod.fire("updateReport");
    })
    
    mod.on("beforeReportLoaded",function(filter) {    
        filter.years = [];        
        container.find("input[name=year]:checked").each(function() {
            filter.years.push($(this).val());
        });
        
        filter.income = container.find("input[name=income]").prop("checked");
        filter.expenditure = container.find("input[name=expenditure]").prop("checked");
        
    });

});