earb.node.gain = function(params) {

    this.init = function(params) {
        earb.node.gain.prototype.init.call(this, params);
    }

    this.init(params);
    
}

earb.node.gain.prototype = new earb.node();
earb.registerNodeType(earb.node.gain, "skfHSI9QRBbv");