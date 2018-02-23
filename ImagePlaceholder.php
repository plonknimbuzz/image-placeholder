<?php
class ImagePlaceholder{
	private $config=[
			'width' => [100, 1, 1024],
			'height' => [100, 1, 1024],
			'text' => '',
			'backgroundColor' => 'C0C0C0',
			'fontColor' => 'FFFFFF',
			'fontFamily' => 'arial',
			'fontSize' => [16, 1, 80],
			'fontAngle' => 0,
			'fontPath' => 'fonts/',
			'availableFont' => ['arial']
		];
	private $width = 100; //0
	private $height = 100; //1
	private $text = ''; //2
	private $backgroundColor = 'C0C0C0'; //3
	private $fontColor = 'FFFFFF'; //4
	private $fontFamily = 'arial'; //5
	private $fontSize = 16; //6
	private $fontAngle = 0; //7
	
	public function __construct($config)
	{
		if(isset($config['width']) && is_array($config['width']))
		{	
			if(isset($config['width'][1]) && $config['width'][1] > 0)
				$this->config['width'][1] = $config['width'][1];
			if(isset($config['width'][2]) && $config['width'][2] >= $this->config['width'][1])
				$this->config['width'][2] = $config['width'][2];
			if(isset($config['width'][0]) && $config['width'][0] >= $this->config['width'][1] && $config['width'][0] <= $this->config['width'][2])
				$this->config['width'][0] = $config['width'][0];
		}
		
		if(isset($config['height']) && is_array($config['height']))
		{	
			if(isset($config['height'][1]) && $config['height'][1] > 0)
				$this->config['height'][1] = $config['height'][1];
			if(isset($config['height'][2]) && $config['height'][2] >= $this->config['height'][1])
				$this->config['height'][2] = $config['height'][2];
			if(isset($config['height'][0]) && $config['height'][0] >= $this->config['height'][1] && $config['height'][0] <= $this->config['height'][2])
				$this->config['height'][0] = $config['height'][0];
		}
		
		if(isset($config['text']) && !empty($config['text']))
		{
			$this->config['text'] = $config['text'];
		}
		
		if(isset($config['backgroundColor']))
		{
			if($this->checkHexColor($config['backgroundColor']) !== false)
				$this->config['backgroundColor'] = $config['backgroundColor'];
		}
		
		if(isset($config['fontColor']))
		{
			if($this->checkHexColor($config['fontColor']) !== false)
				$this->config['fontColor'] = $config['fontColor'];
		}
		
		if(isset($config['fontPath']))
		{
			$this->config['fontPath'] = $config['fontPath'];
		}
		
		if(isset($config['availableFont']) && is_array($config['availableFont']) && !empty($config['availableFont']))
		{
			foreach($config['availableFont'] as $aF)
			{				
				if(file_exists($this->config['fontPath'] . $aF .'.ttf'))
					$this->config['availableFont'] = $config['availableFont'];
				else
				{
					echo "Font not found: ".$this->config['fontPath'] . $aF .'.ttf';
					exit;
				}
			}
		}
		
		if(isset($config['fontFamily']) && in_array($config['fontFamily'], $this->config['availableFont']))
		{
			$this->config['fontFamily'] = $config['fontFamily'];
		}
		else
		{
			$this->config['fontFamily'] = $this->config['availableFont'][0];
		}
		
		if(isset($config['fontAngle']) && is_int($config['fontAngle']))
		{
			if($config['fontAngle'] >= -360 && $config['fontAngle'] <=360)
				$this->config['fontAngle'] = $config['fontAngle'];
		}
			
		if(isset($config['fontSize']) && is_array($config['fontSize']))
		{	
			if(isset($config['fontSize'][1]) && $config['fontSize'][1] > 0)
				$this->config['fontSize'][1] = $config['fontSize'][1];
			if(isset($config['fontSize'][2]) && $config['fontSize'][2] >= $this->config['fontSize'][1])
				$this->config['fontSize'][2] = $config['fontSize'][2];
			if(isset($config['fontSize'][0]) && $config['fontSize'][0] >= $this->config['fontSize'][1] && $config['fontSize'][0] <= $this->config['fontSize'][2])
				$this->config['fontSize'][0] = $config['fontSize'][0];
		}
		
	}
	
	public function parseRequest($req)
	{
		$exp = explode('-', $req);
		$this->setFromRequest($exp);
		return $this;
	}
	
	public function draw(){
		$this->createImage();
	}
	
	public function getConfig(){
		return $this->config;
	}
	
	
	
	private function setFromRequest($req)
	{
		if(isset($req[0]))
		{
			$val = (int) $req[0];
			if($val >= $this->config['width'][1] && $val <= $this->config['width'][2])
				$this->setVar('width', $val);
		}
		
		if(isset($req[1]))
		{
			$val = (int) $req[1];
			if($val >= $this->config['height'][1] && $val <= $this->config['height'][2])
				$this->setVar('height', $val);
		}
		
		if(isset($req[2]) && $req[2] != '')
		{
			$this->setVar('text', $req[2]);
		}
		else
		{
			$this->setVar('text', $this->width .'x'. $this->height);
		}

		if(isset($req[3]) && !empty($req[3]))
		{
			$hex = $this->checkHexColor($req[3]);
			if($hex !== false)
				$this->setVar('backgroundColor', $hex);
		}

		if(isset($req[4]) && !empty($req[4]))
		{
			$hex = $this->checkHexColor($req[4]);
			if($hex !== false)
				$this->setVar('fontColor', $hex);
		}
		
		if(isset($req[5]))
		{
			if(in_array($req[5], $this->config['availableFont']))
				$this->setVar('fontFamily', $req[5]);
		}
		
		if(isset($req[6]))
		{
			$val = (int) $req[6];
			if($val > 0 && $val <=1024)
				$this->setVar('fontSize', $val);
		}

		if(isset($req[7]))
		{
			$val = (int) $req[7];
			if($val >= -360 && $val <=360)
				$this->setVar('fontAngle', $val);
		}
	}
	
	private function checkHexColor($hex)
	{
		$hex = str_replace('#', '', $hex);
		if(preg_match('/([a-f0-9]{3}){1,2}\b/i', $hex))
		{
			if(strlen($hex) ==6)
				return $hex;
			else
				return $hex[0].$hex[0].$hex[1].$hex[1].$hex[2].$hex[2];
		}
		else
			return false;
	}
	
	private function setVar($var, $val)
	{
		if(isset($this->{$var}))
			$this->{$var} = $val;
		else
			die("no var: $var found");
	}
	
	public function getVar($var)
	{
		if(isset($this->{$var}))
			return $this->{$var};
		else
			die("no var: $var found");
	}

	//private function hex2rgb($color)
	public function hex2rgb($color)
	{
		$color = preg_replace("/[^abcdef0-9]/i", "", $color);
		if (strlen($color) == 6)
		{
			list($r, $g, $b) = str_split($color, 2);
			return [hexdec($r), hexdec($g), hexdec($b)];
		}
		elseif (strlen($color) == 3)
		{
			list($r, $g, $b) = array($color[0] . $color[0], $color[1] . $color[1], $color[2] . $color[2]);
			return [hexdec($r), hexdec($g), hexdec($b)];    
		}
		return false;
	}
	
	private function createImage()
	{
		$font = $this->config['fontPath'] . $this->fontFamily .'.ttf';
		$image = ImageCreate($this->width, $this->height);  
		
		//prepare background color
		$bgColorRGB = $this->hex2rgb($this->backgroundColor);
		$bgColor = ImageColorAllocate($image, $bgColorRGB[0], $bgColorRGB[1], $bgColorRGB[2]);
		//fill background with color
		ImageFill($image, 0, 0, $bgColor);

		//prepare font color
		$fontColorRGB = $this->hex2rgb($this->fontColor);
		$fontColor = ImageColorAllocate($image, $fontColorRGB[0], $fontColorRGB[1], $fontColorRGB[2]);

		// Get Bounding Box Size
		$text_box = $this->calculateTextBox($this->fontSize, $this->fontAngle, $font, $this->text);
		
		// Calculate coordinates of the text
		$x = $text_box["left"] + ($this->width / 2) - ($text_box["width"] / 2); 
		$y = $text_box["top"] + ($this->height / 2) - ($text_box["height"] / 2); 
		
		//write text to image
		imagettftext($image, $this->fontSize, $this->fontAngle, $x, $y, $fontColor, $font, $this->text);
		header("Content-Type: image/png"); 
		imagepng($image);
		ImageDestroy($image);
	}
	
	private function calculateTextBox($fontSize, $fontAngle, $fontFile, $text) { 
		/************ 
		credits
		author: jodybrabec@gmail.com
		link: http://php.net/manual/en/function.imagettfbbox.php#105593
		desc: simple function that calculates the *exact* bounding box (single pixel precision). 
			The function returns an associative array with these keys: 
			left, top:  coordinates you will pass to imagettftext 
			width, height: dimension of the image you have to create 
		*************/
		$rect = imagettfbbox($fontSize,$fontAngle,$fontFile,$text); 
		$minX = min(array($rect[0],$rect[2],$rect[4],$rect[6])); 
		$maxX = max(array($rect[0],$rect[2],$rect[4],$rect[6])); 
		$minY = min(array($rect[1],$rect[3],$rect[5],$rect[7])); 
		$maxY = max(array($rect[1],$rect[3],$rect[5],$rect[7])); 
		
		return array( 
		 "left"   => abs($minX) - 1, 
		 "top"    => abs($minY) - 1, 
		 "width"  => $maxX - $minX, 
		 "height" => $maxY - $minY, 
		 "box"    => $rect 
		); 
	} 
	
}
