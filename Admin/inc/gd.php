<?
//==================================================== 
// FileName:GDImage.inc.php 
// Summary: ͼƬ������� 
// Author: ice_berg16(Ѱ�εĵ�����) 
// Modifed: bluesea(��ɫ����)
// CreateTime: 2004-10-12 
// LastModifed:2008-04-18 
// copyright (c)2004 ice_berg16@163.com 
//==================================================== 
class GDImage 
{ 
	private $sourcePath	= ""; //ͼƬ�洢·�� 
	private $galleryPath= ""; //ͼƬ����ͼ�洢·�� 
	private $toFile 	= true; //�Ƿ������ļ� 
	private $fontName	= "./Font/simhei.ttf"; //ʹ�õ�TTF�������� 
	private $maxWidth	= 240; //ͼƬ����� 
	private $maxHeight	= 240; //ͼƬ���߶� 
	
	//========================================== 
	// ����: GDImage($sourcePath ,$galleryPath, $fontPath) 
	// ����: constructor 
	// ����: $sourcePath ͼƬԴ·��(�������һ��"/") 
	// ����: $galleryPath ����ͼƬ��·�� 
	// ����: $fontPath ����·�� 
	//========================================== 
	function GDImage($sourcePath="", $galleryPath="", $fontPath="") 
	{ 
		$this->sourcePath	= $sourcePath?$sourcePath:$this->sourcePath; 
		$this->galleryPath	= $galleryPath?$galleryPath:$this->galleryPath; 
		$this->fontName		= $fontPath?$fontPath. "simhei.ttf":$this->fontName; 
	} 
	//========================================== 
	// ����: makeThumb($sourFile,$width=128,$height=128) 
	// ����: ��������ͼ(����������) 
	// ����: $sourFile ͼƬԴ�ļ� 
	// ����: $width ��������ͼ�Ŀ�� 
	// ����: $height ��������ͼ�ĸ߶� 
	// ����: 0 ʧ�� �ɹ�ʱ�������ɵ�ͼƬ·�� 
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
	// ����: waterMark($sourFile, $text) 
	// ����: ��ͼƬ��ˮӡ 
	// ����: $sourFile ͼƬ�ļ��� 
	// ����: $text �ı�����(���������ַ���) 
	// ����: 1 �ɹ� �ɹ�ʱ�������ɵ�ͼƬ·�� 
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
	// ����: displayThumb($file) 
	// ����: ��ʾָ��ͼƬ������ͼ 
	// ����: $file �ļ��� 
	// ����: 0 ͼƬ������ 
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
	// ����: displayMark($file) 
	// ����: ��ʾָ��ͼƬ��ˮӡͼ 
	// ����: $file �ļ��� 
	// ����: 0 ͼƬ������ 
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
	// ����: getInfo($file) 
	// ����: ����ͼ����Ϣ 
	// ����: $file �ļ�·�� 
	// ����: ͼƬ��Ϣ���� 
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