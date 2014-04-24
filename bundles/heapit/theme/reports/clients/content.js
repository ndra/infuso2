$(function() {

    var diameter = $(window).height(),
        format = d3.format(",d"),
        color = d3.scale.category20c();
    
    var bubble = d3.layout.pack()
        .sort(false)
        .size([$(window).width() - 30, diameter])
        .padding(10);
    
    var svg = d3.select(".h7sa84p707").append("svg")
        .attr("width", $(window).width() - 30)
        .attr("height", diameter)
        .attr("class", "bubble");
    
    var f = function(data) {
    
        $("svg").html("");
    
        var node = svg.selectAll(".node")
            .data(bubble.nodes(data).filter(function(d) { return !d.children; }))
            .enter().append("g")
            .style("font-size", function(data) {
                var size = data.r / 3;
                return size;
            })
            .attr("clip-path", function(data, n) { return "url(#circle-"+n+")" })
            .attr("class", "node")
            .attr("transform", function(d) {
                return "translate(" + d.x + "," + d.y + ")";
            });
        
        node.append("circle")
            .attr("r", function(d) { return d.r + 1; })
            .style("fill", function(d) {
                if(d.type === "income") {
                    return "#003388";
                } else {
                    return "red";
                }
            });
            
        node.append("clipPath")
            .attr("id", function(data, n) { return "circle-"+n })
            .append("circle")
            .attr("r", function(d) { return d.r + 1})
        
        node.append("text")
            .attr("class", "title")
            .text(function(d) { return d.title });
            
        node.append("text")
            .attr("dy", "1.3em")
            .attr("class", "amount")
            .text(function(d) { return d.total + " т." });
            
        node.append("text")
            .attr("dy", "2em")
            .attr("class", "percent")
            .text(function(d) { return d.percent + " %" });
            
    };
    
    var updateReport = function() {
    
        var filter = {};
        mod.fire("beforeReportLoaded", filter);
    
        mod.call({
            cmd: "Infuso/Heapit/Controller/Report/clientsData",
            filter: filter
        },function(data) {
            f(data);
        });
    
    }
    
    setTimeout(updateReport,100);
    
    mod.on("updateReport", updateReport);
    
});