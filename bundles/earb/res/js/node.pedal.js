earb.Node.Pedal = class extends earb.Node {

    constructor(params) {
        super(params);
        
        var ctx = earb.Song.context();    
        
        var real = new Float32Array(2);
        var imag = new Float32Array(2);
        real[0] = 1;
        imag[0] = 1;
        real[1] = 1;
        imag[1] = 1;        
        this.oscillator = ctx.createOscillator(); 
        var wave = ctx.createPeriodicWave(real, imag);        
        this.oscillator.setPeriodicWave(wave);
        this.oscillator.frequency.value = 0;
        this.oscillator.start();
        
        this.gain = ctx.createGain();
        this.gain.gain.value = 0;  
        this.oscillator.connect(this.gain);
        
    }   
    
    press() {
        this.gain.gain.value = 1;
    }
    
    release() {
        this.gain.gain.value = 0;
    }

    viewConstructor() {
        return earb.Node.Pedal.View;
    }

    static nodeClassLabel() {
        return "Педаль";
    }
    
    outConnector(port) {
        if(port == "default") {
            return this.gain;
        }
    }

}

earb.registerNodeType(earb.Node.Pedal, "oKBHE5bA31zm");