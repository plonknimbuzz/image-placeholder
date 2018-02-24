# PHP Image Placeholder

PHP image placholder is library/class for create dummy images / image placeholder. You can use this to build website image placeholder creator like [placehold.it](http://placehold.it) / [placeholder.com](http://placeholder.com), just see the example folder. This library is also can used for build mock-up when you starting build new apps.

 * support center image
 * support output format: png, gif, jpeg
 * support quality (only for png and jpeg)
 * Easy to use
 * Lightweight (< 1 KB)
 * Included example for client side
 * Supported setting:
  * width
  * height
  * text
  * background color
  * font color
  * font family
  * font size
  * font angle
  * image format
  * image quality


*Current version: v1.0 - (2018-02-24)*


## Documentation

Visit our documentation [here](http://creativecoder.xyz/image-placeholder)

## Download

Visit our [github](https://github.com/plonknimbuzz/image-placeholder) to download

## Demo

[form builder example](http://creativecoder.xyz/image-placeholder/form.html) or see in the [github example](https://github.com/plonknimbuzz/image-placeholder/tree/master/example)

## Usage

just include the class `imagePlaceholder.php`

```php
<?php
	require('imagePlaceholder.php');

	//set config for default value
	$config = [
		'width' => [100, 1, 1024],
		'height' => [100, 1, 1024],
		'text' => 'auto',
		'backgroundColor' => 'C0C0C0',
		'fontColor' => 'FFFFFF',
		'fontFamily' => 'arial',
		'fontSize' => [16, 1, 80],
		'fontAngle' => 0,
		'fontPath' => '../fonts/',
		'availableFont' => ['arial', 'calibri'],
		'imageFormat' => 'png',
		'imageQuality' => 6
	];
	
	$a = new ImagePlaceholder($config);
	//$a->draw(); //draw with default value from config
	
	$p = '200-100-hello-8D64E7-1E9336-arial-16-27-png-6';
	$a->parseRequest($p)->draw(); //draw from given parameter
```


## Parameter
Full Parameter.
```
200-100-hello-8D64E7-1E9336-arial-16-27-png-6
width: 200px
height: 100px
text: hello
background color: #8D64E7
font color: #1E9336
font family: arial
font size: 16px
font angle: 27 degree
image format: png
image quality: 6
```
Partial Parameter 1
```
100-200
width: 100px
height: 200px
text: default (config)
background color: #8D64E7
font color: default (config)
font family: default (config)
font size: default (config)
font angle: default (config)
image format: default (config)
image quality: default (config)
```
Partial Parameter 2
```
---------6
width: default (config)
height: default (config)
text: default (config)
background color: #8D64E7
font color: default (config)
font family: default (config)
font size: default (config)
font angle: default (config)
image format: default (config)
image quality: 6
```

## Method
#### initialize

You need initialize `imagePlaceholder` class with `$config` as described below:

key | type | example | description
--- | --- | --- | --- 
width | array | array(100, 1, 1024) | default width: 100px, minimum width: 1px, maximum width: 1024
height | array | array(100, 1, 1024) | default height: 100px, minimum height: 1px, maximum height: 1024
text | string | hello | set default text: hello. You can set text `auto` for shortcut to draw `widthxheight`
backgroundColor | string | CC00CC | set default background color as #CC00CC. You can use hex 3-format (C0C) (or 6-format (CC00CC) hex color. any `#` will be trimmed
fontColor | string | FFFFFF | set default font color as #FFFFFF. You can use hex 3-format (FFF) (or 6-format (FFFFFF) hex color. any `#` will be trimmed
fontFamily | string  | 'arial' | set default font family as arial. Only `.ttf` supported. If given value is not match in `availableFont`, 1st value from `availableFont` will be set as default `fontFamily`
fontSize | integer | 16 | set default font size: 16px.
fontAngle | integer | 45 | set default font angle: 45 degree. the valid value is 0 - 360
fontPath | string | ../fonts/ | set default font path:  `../fonts/`.
availableFont | array | array('arial', 'calibri') | set avalible font: arial and calibri. **Note:** must be have atleast 1 font exists 
imageFormat | string | png | set default output as png. Valid format is: png, gif, and jpeg (or jpg)
imageQuality | integer | 6 | set default quality: 6. Quality range 0-9. No quality difference on format `gif`. If format `jpeg` (or `jpg`), the quailty will be `($quality + 1) * 10  = 70`

example config
```php
$config = [
	'width' => [100, 1, 1024], 
	'height' => [100, 1, 1024],
	'text' => 'auto',
	'backgroundColor' => 'C0C0C0',
	'fontColor' => 'FFFFFF',
	'fontFamily' => 'arial',
	'fontSize' => [16, 1, 80],
	'fontAngle' => 0,
	'fontPath' => '../fonts/',
	'availableFont' => ['arial', 'calibri'],
	'imageFormat' => 'png',
	'imageQuality' => 6
];
```

#### parseRequest($parameter)
You can draw image using this from given parameter.

```php
$config = [
	'width' => [100, 1, 1024], 
	'height' => [100, 1, 1024],
	'text' => 'auto',
	'backgroundColor' => 'C0C0C0',
	'fontColor' => 'FFFFFF',
	'fontFamily' => 'arial',
	'fontSize' => [16, 1, 80],
	'fontAngle' => 0,
	'fontPath' => '../fonts/',
	'availableFont' => ['arial', 'calibri'],
	'imageFormat' => 'png',
	'imageQuality' => 6
];
$a = new ImagePlaceholder($config);
$p = '200-300';
$a->parseRequest($p)->draw(); //will draw image with width: 200px and height: 300px
```

#### setVar($varName, $val)
Set parameter manually. All key which mentioned on `$config` above is valid `$varName`

```php
$config = [
	'width' => [100, 1, 1024], 
	'height' => [100, 1, 1024],
	'text' => 'auto',
	'backgroundColor' => 'C0C0C0',
	'fontColor' => 'FFFFFF',
	'fontFamily' => 'arial',
	'fontSize' => [16, 1, 80],
	'fontAngle' => 0,
	'fontPath' => '../fonts/',
	'availableFont' => ['arial', 'calibri'],
	'imageFormat' => 'png',
	'imageQuality' => 6
];
$a = new ImagePlaceholder($config);
$p = '200-300';
$a->parseRequest($p)
	->setVar('text', 'world')
	->setVar('fontFamily', 'calibri')
	->draw(); //will draw image with width: 200px, height: 300px, text: world and font: calibri
```

#### getVar($varName)
Get setted parameter. All key which mentioned on `$config` above is valid `$varName`

```php
$config = [
	'width' => [100, 1, 1024], 
	'height' => [100, 1, 1024],
	'text' => 'auto',
	'backgroundColor' => 'C0C0C0',
	'fontColor' => 'FFFFFF',
	'fontFamily' => 'arial',
	'fontSize' => [16, 1, 80],
	'fontAngle' => 0,
	'fontPath' => '../fonts/',
	'availableFont' => ['arial', 'calibri'],
	'imageFormat' => 'png',
	'imageQuality' => 6
];
$a = new ImagePlaceholder($config);
$p = '200-300';
$a->parseRequest($p); 
echo $a->getVar('width');//200
echo $a->getVar('height');//300
echo $a->getVar('imageFormat');//png
```

#### draw()
Draw image from setted parameter if setted before, if not will use default value from `$config` for parameter which not setted before.

```php
$config = [
	'width' => [100, 1, 1024], 
	'height' => [100, 1, 1024],
	'text' => 'auto',
	'backgroundColor' => 'C0C0C0',
	'fontColor' => 'FFFFFF',
	'fontFamily' => 'arial',
	'fontSize' => [16, 1, 80],
	'fontAngle' => 0,
	'fontPath' => '../fonts/',
	'availableFont' => ['arial', 'calibri'],
	'imageFormat' => 'png',
	'imageQuality' => 6
];
$a = new ImagePlaceholder($config);
$p = '200-300'; //only set widht and height
$a->parseRequest($p)->draw();
/* 
	draw image with this specific:
	width: 200px 
	height: 300px
	text: 200x300
	backgroundColor: #C0C0C0
	fontColor: #FFFFFF
	fontFamily: arial
	fontSize: 16px
	fontAngle: 0
	imageFormat: png
	imageQuality: 6
*/
```

# Issue
if you have Any issue/question, you can post it in `issue` menu, or contact me at plonknimbuzz@gmail.com

## Todo

* setting direction not only center

## Bug

* example `.htaccess` cannot parse special char like space, #, etc


# Credits

* `jodybrabec@gmail.com` for center image function in [imagettfbbox manual](http://php.net/manual/en/function.imagettfbbox.php#105593).

# License

© 2018, __plonknimbuzz__. Released under the [MIT License](http://www.opensource.org/licenses/mit-license.php).