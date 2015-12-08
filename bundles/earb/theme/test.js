$(function() {
    
    var context = new window.AudioContext();
    
    var length = 150000;
    
    var buffer = context.createBuffer(
        1,
        length,
        context.sampleRate
    );
    
    mod.msg(context.sampleRate);
    
    var fr = Math.floor(Math.random() * 440 + 140);
    //fr = ;
    fr = 300;
    
    for(var i = 0; i < buffer.length; i ++) {
        buffer.getChannelData(0)[i] = Math.sin(i / fr * Math.PI * 2) * .5 - .5;
    }
    
    var a = Math.random() * 1000;
    var b = a + fr * Math.floor(2 + Math.random() * 30) + 2;
    
    console.log(a + ":" + b);
    
    var source = context.createBufferSource();
    source.connect(context.destination);
    source.buffer = buffer;
    source.loop = true;
    source.loopStart = a / context.sampleRate;
    source.loopEnd = b / context.sampleRate;
    
    setTimeout(function() {
        source.start();
    },Math.random() * 1000);
    
    setTimeout(function() {
        source.stop();    
    },3000);

});
