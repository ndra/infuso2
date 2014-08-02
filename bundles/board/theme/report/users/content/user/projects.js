mod.init(".tlajvftvvk", function() {
    
    var $container = $(this);

    var w = 600,                        //width
    h = 600,                            //height
    r = 200,                            //radius
    color = d3.scale.category20();     //builtin range of colors
 
    data = JSON.parse($container.find(".pie").attr("data:data"));
    
    var vis = d3.select($container.find(".pie")[0])
        .append("svg:svg") 
        .data([data])
        .attr("width", w)
        .attr("height", h)
        .append("svg:g")
        .attr("transform", "translate(" + w/2 + "," + h/2 + ")")
 
    var arc = d3.svg.arc()
        .innerRadius(r/3)
        .outerRadius(r);
 
    var pie = d3.layout.pie()
        .value(function(d) { return d.value; });
 
    var arcs = vis.selectAll("g.slice")     //this selects all <g> elements with class slice (there aren't any yet)
        .data(pie)                          //associate the generated pie data (an array of arcs, each having startAngle, endAngle and value properties) 
        .enter()                            //this will create <g> elements for every "extra" data element that should be associated with a selection. The result is creating a <g> for every object in the data array
        .append("svg:g")                //create a group to hold each slice (we will have a <path> and a <text> element associated with each slice)
        .attr("class", "slice");    //allow us to style things in the slices (like text)
 
    arcs.append("svg:path")
        .attr("fill", function(d, i) { return color(i); } ) //set the color for each slice to be chosen from the color function defined above
        .attr("d", arc);                                    //this creates the actual SVG path using the associated data (pie) with the arc drawing function
        
    arcs.append("a")
        .attr("xlink:href", function(d) {
            return d.data.href;
        })
        .attr("transform", function(d) {
            return "rotate ("+(-90 + (d.startAngle + d.endAngle)/Math.PI*90)+") translate("+(r+10)+",6)";            
        })
        .append("svg:text")        
        .text(function(d, i) { return data[i].label; });;   
        
    arcs.append("svg:text")
        .attr("transform", function(d) {
            return "translate(" + arc.centroid(d) + ") translate(0,6)"; 
        })
        .attr("text-anchor", "middle")
        .text(function(d, i) { return data[i].value; });   

});