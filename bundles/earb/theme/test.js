mod(".nRjkjN8GAn").init(function() {
    
    var $container = $(this);
    var $content = $container.children(".content");
    var $nodes = $content.children(".nodes");
    var $links = $content.children(".links");
    var $header = $container.children(".header");
    
    var data = {};
    try {
        data = JSON.parse(localStorage.getItem("song"));
    } catch(ex) {}

    var song = new earb.Song(data);
    
    song.on("addNode", function(node) {
        var $e = $("<div>").appendTo($nodes);
        node.view.render($e);
    });
    
    var redrawLinks = function() {
        
       // var c = $links.get(0);
       // var ctx = c.getContext("2d");
       // ctx.clearRect(0, 0, c.width, c.height);
        $links.html("");
        var nodesOffset = $nodes.offset(); 
        
        for(var i in song.links) {
            var link = song.links[i];
            var src = link.src();
            var dest = link.dest();
            
            var $src = src.view.getOutElement(link.params.srcPort);
            var $dest = dest.view.getInElement(link.params.destPort);
            
            if(!$src || !$dest) {
                return;
            }
            
            var x1 = $src.offset().left - nodesOffset.left + 5;
            var y1 = $src.offset().top - nodesOffset.top + 5;
            var x2 = $dest.offset().left - nodesOffset.left + 5;
            var y2 = $dest.offset().top - nodesOffset.top + 5;
            
            // Тень
            $(document.createElementNS('http://www.w3.org/2000/svg','path'))
                .attr({
                    d: "M "+x1+" "+y1+" C "+x1+" "+(y1-70)+" "+x2+" "+(y2-20)+" "+x2+" "+y2
                })
                .attr("class", "link-shadow")
                .appendTo($links);
          
            // Провод
            $(document.createElementNS('http://www.w3.org/2000/svg','path'))
                .attr({
                    d: "M "+x1+" "+y1+" C "+x1+" "+(y1-70)+" "+x2+" "+(y2-20)+" "+x2+" "+y2
                }).data("id", link.id())
                .click(function() {
                    song.removeLink($(this).data("id"));
                })
                .appendTo($links);
                
            
        }
    };
    
    song.on("link/create", redrawLinks);
    song.on("node/move", redrawLinks);
    
    for(var i in earb.nodeTypes) {
        var type = earb.nodeTypes[i];
        var label = type.nodeClassLabel();
        $("<div class='add-type' >")
            .html(label)
            .appendTo($header)
            .data("type", i)
            .click(function() {
                song.addNode({
                    type: $(this).data("type")
                });
            });
    }
    
    setInterval(function() {
        var data = song.storeParams();
        localStorage.setItem("song", JSON.stringify(data));
    }, 1000);
    
    
    //song.addNode();
    //song.addNode();

});