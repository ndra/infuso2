mod(".nRjkjN8GAn").init(function() {
    
    var $container = $(this);
    var $content = $container.children(".content");
    var $nodes = $content.children(".nodes");
    
    var data = {};
    try {
        data = JSON.parse(sessionStorage.getItem("song"));
    } catch(ex) {}
    
    var song = new earb.song(data);
    
    song.on("addNode", function(node) {
        var $e = $("<div>").appendTo($nodes);
        node.view.render($e);
    });
    
    setInterval(function() {
        var data = song.storeParams();
        sessionStorage.setItem("song", JSON.stringify(data));
    }, 1000);
    
    
    var $header = $container.find(".header");
    for(var i in earb.nodeTypes) {
        $("<span>")
            .html(i)
            .attr("data:id", i)
            .appendTo($header)
            .click(function() {
                song.addNode({
                    type: $(this).attr("data:id")
                })
            });
    }
    
    //console.log(song.data());
    
    /*song.scale(earb.scales.hminor(0));

    var channel = song.channel({
        store: "mwDwlnhdL5",
        pattern: {
            numberOfSteps: 16    
        }
    });
    channel.controller().html();    
    
    /*$("<div>").css("height", 100).appendTo("body");
    
    var channel2 = song.channel({
        name: "solo"
    });
    var pattern = channel2.pattern(16);
    channel2.html();  */
    
   // song.play();


});