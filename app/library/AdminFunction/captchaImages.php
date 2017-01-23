<?php
/*
* @Created by: HSS
* @Author	 : nguyenduypt86@gmail.com
* @Date 	 : 12/2016
* @Version	 : 1.0
*/
class captchaImages{
	public $random_dots = 0;
	public $random_lines = 10;
	public $text_color="0x142864";
	public $noice_color = "0x142864";
	
	function __construct($width='120',$height='40', $characters='5'){
		$font = Config::get('config.DIR_ROOT').'/assets/fonts/monofont.ttf';
		
		$code = $this->generateCode($characters);
		$font_size = $height * 0.75;
		if (ob_get_level()) { ob_end_clean();}
		$image = @imagecreate($width, $height);
		//background
		$background_color = @imagecolorallocate($image, 255, 255, 255);
		
		//text color
		$arr_text_color = $this->hexrgb($this->text_color);
		$text_color = @imagecolorallocate($image, $arr_text_color['red'], $arr_text_color['green'], $arr_text_color['blue']);
		
		//noice color
		$arr_noice_color = $this->hexrgb($this->noice_color);
		$image_noise_color = @imagecolorallocate($image, $arr_noice_color['red'],$arr_noice_color['green'], $arr_noice_color['blue']);
		
		//generating the dots
		for( $i=0; $i<$this->random_dots; $i++ ) {
			@imagefilledellipse($image, mt_rand(0,$width),mt_rand(0,$height), 2, 3, $image_noise_color);
		}
		
		//generating lines randomly
		for( $i=0; $i<$this->random_lines; $i++ ) {
			@imageline($image, mt_rand(0,$width), mt_rand(0,$height),mt_rand(0,$width), mt_rand(0,$height), $image_noise_color);
		}
		
		//create a text box and add number letters code in it
		$textbox = @imagettfbbox($font_size, 0, $font, $code); 
		$x = ($width - $textbox[4])/2;
		$y = ($height - $textbox[5])/2;
		@imagettftext($image, $font_size, 0, $x, $y, $text_color, $font , $code);
		
		//defining the image type header
		header('Content-Type: image/jpeg');
		//showing the image
		@imagejpeg($image);
		//destroy the image
		@imagedestroy($image);
		Session::put('security_code', $code, 60*24);
		Session::save();
		exit();
	}
	
	function generateCode($characters) {
		$possible = '123456789bcdfghjkmnpqrstvwxyz';
		$code = '';
		$i = 0;
		while ($i < $characters) { 
			$code .= substr($possible, mt_rand(0, strlen($possible)-1), 1);
			$i++;
		}
		return $code;
	}
	
	function hexrgb($hexstr){
  		$int = hexdec($hexstr);
 		return array(
					"red" => 0xFF & ($int >> 0x10),
               		"green" => 0xFF & ($int >> 0x8),
               		"blue" => 0xFF & $int);
	}
}
