$(function() {

    mod.call({
        cmd: "Infuso/Heapit/Controller/Report/referralsData"
    },function(data) {
        createGraph(data);
    });
    
    var createGraph = function(dataset) {
    
        var w = 1000;
        var h = 500;
    
        // Initialize a default force layout, using the nodes and edges in dataset
        var force = d3.layout.force()
            .nodes(dataset.nodes)
            .links(dataset.edges)
            .size([w, h])
            .linkDistance([50])
            .charge([-50])
            .start();
    
        // Create SVG element
        var svg = d3.select(".o1enr7d8tf")
            .append("svg")
            .attr("width", w)
            .attr("height", h);
        
        // Create edges as lines
        var edges = svg.selectAll("line")
            .data(dataset.edges)
            .enter()
            .append("line")
            .style("stroke", "#ccc")
            .style("stroke-width", 1);
        
        // Create nodes as circles
        var nodes = svg.selectAll("circle")
            .data(dataset.nodes)
            .enter()
            .append("circle")
            .attr("r", function(data) {
                return data.radius
            })
            .style("fill", "red")           
            .call(force.drag);
            
        // Create nodes as circles
        var labels = svg.selectAll("text")
            .data(dataset.nodes)
            .enter()
            .append("text")
            .text(function(data) {
                return data.title;
            })    
            .style("color","black")     
            .call(force.drag);
        
        // Every time the simulation "ticks", this will be called
        force.on("tick", function() {
    
            edges.attr("x1", function(d) { return d.source.x; })
                .attr("y1", function(d) { return d.source.y; })
                .attr("x2", function(d) { return d.target.x; })
                .attr("y2", function(d) { return d.target.y; });
        
            nodes.attr("cx", function(d) { return d.x; })
                .attr("cy", function(d) { return d.y; });
                
            labels.attr("x", function(d) { return d.x; })
                .attr("y", function(d) { return d.y; });
    
        });
    
    }
    
});