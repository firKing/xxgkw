<?
//==================================================== 
// FileName:GDImage.inc.php 
// Summary: 图片处理程序 
// Author: ice_berg16(寻梦的稻草人) 
// Modifed: bluesea(蓝色海洋)
// CreateTime: 2004-10-12 
// LastModifed:2008-04-18 
// copyright (c)2004 ice_berg16@163.com 
//==================================================== 
class GDImage 
{ 
	private $sourcePath	= ""; //图片存储路径 
	private $galleryPath= ""; //图片缩略图存储路径 
	private $toFile 	= true; //是否生成文件 
	private $fontName	= "./Font/simhei.ttf"; //使用的TTF字体名称 
	private $maxWidth	= 240; //图片最大宽度 
	private $maxHeight	= 240; //图片最大高度 
	
	//========================================== 
	// 函数: GDImage($sourcePath ,$galleryPath, $fontPath) 
	// 功能: constructor 
	// 参数: $sourcePath 图片源路径(包括最后一个"/") 
	// 参数: $galleryPath 生成图片的路径 
	// 参数: $fontPath 字体路径 
	//========================================== 
	function GDImage($sourcePath="", $galleryPath="", $fontPath="") 
	{ 
		$this->sourcePath	= $sourcePath?$sourcePath:$this->sourcePath; 
		$this->galleryPath	= $galleryPath?$galleryPath:$this->galleryPath; 
		$this->fontName		= $fontPath?$fontPath. "simhei.ttf":$this->fontName; 
	} 
	//========================================== 
	// 函数: makeThumb($sourFile,$width=128,$height=128) 
	// 功能: 生成缩略图(输出到浏览器) 
	// 参数: $sourFile 图片源文件 
	// 参数: $width 生成缩略图的宽度 
	// 参数: $height 生成缩略图的高度 
	// 返回: 0 失败 成功时返回生成的图片路径 
	//========================================== 
	function makeThumb($sourFile,$width=240,$height=240) 
	{ 
		$sourFile  = basename($sourFile);
		$sourFile  = $this->sourcePath . $sourFile; 
		$imageInfo = $this->getInfo($sourFile); 
		$newName   = substr($imageInfo['name'], 0, strrpos($imageInfo['name'], ".")) . "_thumb.jpg"; 
		switch ($imageInfo['type']) 
		{ 
			case 1: //gif 
				$img = imagecreatefromgif($sourFile); 
				break; 
			case 2: //jpg 
				$img = imagecreatefromjpeg($sourFile); 
				break; 
			case 3: //png 
				$img = imagecreatefrompng($sourFile); 
				break; 
			default: 
				return 0; 
				break; 
		} 
		if (!$img) 
			return 0; 
	
		$width = ($width > $imageInfo['width']) ? $imageInfo['width'] : $width; 
		$height = ($height > $imageInfo['height']) ? $imageInfo['height'] : $height; 
		$srcW = $imageInfo['width']; 
		$srcH = $imageInfo['height']; 
		if ($srcW * $width > $srcH * $height) 
			$height = round($srcH * $width / $srcW); 
		else 
			$width = round($srcW * $height / $srcH); 
		//* 
		if (function_exists("imagecreatetruecolor")) //GD2.0.1 
		{ 
			$new = imagecreatetruecolor($width, $height); 
			imagecopyresampled($new, $img, 0, 0, 0, 0, $width, $height, $imageInfo['width'], $imageInfo['height']); 
		}else{ 
			$new = imagecreate($width, $height); 
			imagecopyresized($new, $img, 0, 0, 0, 0, $width, $height, $imageInfo['width'], $imageInfo['height']); 
		} 
		//*/ 
		if ($this->toFile) 
		{ 
			if (file_exists($this->galleryPath . $newName)) 
				return $this->galleryPath . $newName;  
			imagejpeg($new, $this->galleryPath . $newName); 
			return $this->galleryPath . $newName; 
		}else{ 
			imagejpeg($new); 
		} 
		imagedestroy($new); 
		imagedestroy($img); 
	} 
	//========================================== 
	// 函数: waterMark($sourFile, $text) 
	// 功能: 给图片加水印 
	// 参数: $sourFile 图片文件名 
	// 参数: $text 文本数组(包含二个字符串) 
	// 返回: 1 成功 成功时返回生成的图片路径 
	//========================================== 
	function waterMark($sourFile, $text) 
	{ 
		$sourFile  = basename($sourFile);
		$imageInfo = $this->getInfo($sourFile); 
		$sourFile  = $this->sourcePath.$sourFile; 
		$newName   = substr($imageInfo['name'], 0, strrpos($imageInfo['name'], ".")) . "_mark.jpg"; 
		switch ($imageInfo['type']) 
		{ 
			case 1: //gif 
				$img = imagecreatefromgif($sourFile); 
				break; 
			case 2: //jpg 
				$img = imagecreatefromjpeg($sourFile); 
				break; 
			case 3: //png 
				$img = imagecreatefrompng($sourFile); 
				break; 
			default: 
				return 0; 
				break; 
		} 
		if (!$img) 
			return 0; 
	
		$width = ($this->maxWidth > $imageInfo['width']) ? $imageInfo['width'] : $this->maxWidth; 
		$height = ($this->maxHeight > $imageInfo['height']) ? $imageInfo['height'] : $this->maxHeight; 
		$srcW = $imageInfo['width']; 
		$srcH = $imageInfo['height']; 
		if ($srcW * $width > $srcH * $height) 
			$height = round($srcH * $width / $srcW); 
		else 
			$width = round($srcW * $height / $srcH); 
		//* 
		if (function_exists("imagecreatetruecolor")) //GD2.0.1 
		{ 
			$new = imagecreatetruecolor($width, $height); 
			imagecopyresampled($new, $img, 0, 0, 0, 0, $width, $height, $imageInfo['width'], $imageInfo['height']); 
		} 
		else 
		{ 
			$new = imagecreate($width, $height); 
			imagecopyresized($new, $img, 0, 0, 0, 0, $width, $height, $imageInfo['width'], $imageInfo['height']); 
		} 
		//$white = imageColorAllocate($new, 255, 255, 255); 
		$black = imagecolorallocate($new, 0, 0, 0); 
		$alpha = imagecolorallocatealpha($new, 230, 230, 230, 40); 
		//$rectW = max(strlen($text[0]),strlen($text[1]))*7; 
		imagefilledrectangle($new, 0, $height-26, $width, $height, $alpha); 
		imagefilledrectangle($new, 13, $height-20, 15, $height-7, $black); 
		imagettftext($new, 4.9, 0, 20, $height-14, $black, $this->fontName, $text); 
		imagettftext($new, 4.9, 0, 20, $height-6, $black, $this->fontName, $text); 
		//*/ 
		if ($this->toFile)
		{ 
			if (file_exists($this->galleryPath.$newName)) 
				unlink($this->galleryPath.$newName); 
			imagejpeg($new, $this->galleryPath.$newName); 
			return $this->galleryPath.$newName; 
		}else{ 
			imagejpeg($new); 
		} 
		imagedestroy($new); 
		imagedestroy($img); 
	} 
	//========================================== 
	// 函数: displayThumb($file) 
	// 功能: 显示指定图片的缩略图 
	// 参数: $file 文件名 
	// 返回: 0 图片不存在 
	//========================================== 
	function displayThumb($file) 
	{ 
		$file      = basename($file);
		$imageInfo = $this->getInfo($file); 
		$newName   = substr($imageInfo['name'], 0, strrpos($imageInfo['name'], ".")) . "_thumb.jpg"; 
		$thumbFile = $this->galleryPath.$newName; 
		if (!file_exists($thumbFile))
			$this->makeThumb($file);
		return $thumbFile; 
	} 
	//========================================== 
	// 函数: displayMark($file) 
	// 功能: 显示指定图片的水印图 
	// 参数: $file 文件名 
	// 返回: 0 图片不存在 
	//========================================== 
	function displayMark($file) 
	{ 
		$file      = basename($file);
		$markName  = substr($file, 0, strrpos($file, ".")) . "_mark.jpg"; 
		$thumbFile = $this->galleryPath.$markName; 
		if (!file_exists($thumbFile)) 
			return 0; 
		return $thumbFile; 
	} 
	//========================================== 
	// 函数: getInfo($file) 
	// 功能: 返回图像信息 
	// 参数: $file 文件路径 
	// 返回: 图片信息数组 
	//========================================== 
	function getInfo($file) 
	{ 
		$file = basename($file);
		$file = $this->sourcePath.$file;
		$data = getimagesize($file); 
		$imageInfo['width'] = $data[0]; 
		$imageInfo['height']= $data[1]; 
		$imageInfo['type'] = $data[2]; 
		$imageInfo['name'] = basename($file); 
		return $imageInfo; 
	}
}
?>