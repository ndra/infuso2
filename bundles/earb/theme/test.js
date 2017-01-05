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
    
    song.on("node/render", function(node) {
        node.createView($nodes);
    });
    
    var redrawLinks = function() {

        $links.html("");
        var nodesOffset = $nodes.offset(); 
        
        song.linkManager.links().each(function() {
            var link = this;
            var src = link.src();
            var dest = link.dest();
            
            if(!src.view) {
                return;
            }
            
            if(!dest.view) {
                return;
            }
            
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
                    song.linkManager.remove($(this).data("id"));
                })
                .appendTo($links);
          
            // Провод
            $(document.createElementNS('http://www.w3.org/2000/svg','path'))
                .attr({
                    d: "M "+x1+" "+y1+" C "+x1+" "+(y1-70)+" "+x2+" "+(y2-20)+" "+x2+" "+y2
                }).data("id", link.id())
                .click(function() {
                    song.linkManager.remove($(this).data("id"));
                })
                .attr("class", "link-light")
                .appendTo($links);
                
            
        });
    };
    
    song.on("link/redraw", redrawLinks);
    
    for(var i in earb.nodeTypes) {
        var type = earb.nodeTypes[i];
        var label = type.nodeClassLabel();
        $("<div class='add-type' >")
            .html(label)
            .appendTo($header)
            .data("type", i)
            .click(function() {
                song.nodeManager.add({
                    type: $(this).data("type")
                });
            });
    }
    
    setInterval(function() {
        var data = song.storeParams();
        localStorage.setItem("song", JSON.stringify(data));
    }, 1000);
    
    
    // Удаление нод
    $content.children(".trash").on("mod/drop", function(event) {
        song.nodeManager.remove(event.source.data("node-id"));
    });

});