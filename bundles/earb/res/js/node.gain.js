earb.Node.Gain = class extends earb.Node {

    viewConstructor() {
        return earb.Node.Gain.View;
    }

    static nodeClassLabel() {
        return "Гейн";
    }

}

earb.registerNodeType(earb.Node.Gain, "skfHSI9QRBbv");