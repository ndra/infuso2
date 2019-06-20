<?php

namespace Infuso\ReCaptcha\Widgets;
use Infuso\Core;

/**
* Виджет рекапчи
*/

class ReCaptchaForm extends \Infuso\Template\Helper {

	public function name() {
	     return "Форма с кнопкой гугл рекапча v2";
	}
	
	public function alias() {
	    return "recaptchaform";
	}
	
	public function execWidget() {
		 app()->tm("/recaptcha/widgets/recaptchaform")
            ->param("widget", $this)
            ->params($this->params())
            ->exec();
	}

}