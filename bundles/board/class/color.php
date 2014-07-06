<?

namespace Infuso\Board;
use Infuso\Core;

/**
 * Поведение для класса пользователя, добавляющее методы доски
 **/
class Color extends Core\Component {

	public function get($n) {
	
	    $colors = array(
			"#1f77b4",
			"#aec7e8",
			"#ff7f0e",
			"#ffbb78",
			"#2ca02c",
			"#98df8a",
			"#d62728",
			"#ff9896",
			"#9467bd",
			"#c5b0d5",
			"#8c564b",
			"#c49c94",
			"#e377c2",
			"#f7b6d2",
			"#7f7f7f",
			"#c7c7c7",
			"#bcbd22",
			"#dbdb8d",
			"#17becf",
			"#9edae5",
		);
		
		$n %= sizeof($colors);
		$color = $colors[$n];
		
		$color = self::hex2RGB($color);
		$color = "rgba(".$color["red"].",".$color["green"].",".$color["blue"].",.5)";
		
		return $color;
		
	}
	
	function hex2RGB($hexStr) {
	    $hexStr = preg_replace("/[^0-9A-Fa-f]/", '', $hexStr); // Gets a proper hex string
	    $rgbArray = array();
	    if (strlen($hexStr) == 6) { //If a proper hex code, convert using bitwise operation. No overhead... faster
	        $colorVal = hexdec($hexStr);
	        $rgbArray['red'] = 0xFF & ($colorVal >> 0x10);
	        $rgbArray['green'] = 0xFF & ($colorVal >> 0x8);
	        $rgbArray['blue'] = 0xFF & $colorVal;
	    } elseif (strlen($hexStr) == 3) { //if shorthand notation, need some string manipulations
	        $rgbArray['red'] = hexdec(str_repeat(substr($hexStr, 0, 1), 2));
	        $rgbArray['green'] = hexdec(str_repeat(substr($hexStr, 1, 1), 2));
	        $rgbArray['blue'] = hexdec(str_repeat(substr($hexStr, 2, 1), 2));
	    } else {
	        return false; //Invalid hex color code
	    }
	    return $rgbArray;
	}
    
}
