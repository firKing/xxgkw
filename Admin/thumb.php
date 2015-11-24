<?php
/*
* 文件名:thumb.php
* 功能:文章添加时对图片的缩略处理
* 工作流程:
* 1.未知
* 更新日志:
* 2012.10.31    黄劼  代码整理
*/
function setMemoryForImage($filename){
	$imageInfo = getimagesize($filename);
	$MB = 1048576;  // number of bytes in 1M
	$K64 = 65536;    // number of bytes in 64K
	$TWEAKFACTOR = 1.5;  // Or whatever works for you
	$memoryNeeded = round( ( $imageInfo[0] * $imageInfo[1]
										   * $imageInfo['bits']
										   * $imageInfo['channels'] / 8
							 + $K64
						   ) * $TWEAKFACTOR
						 );
	//ini_get('memory_limit') only works if compiled with "--enable-memory-limit" also
	//Default memory limit is 8MB so well stick with that. 
	//To find out what yours is, view your php.ini file.
	$memoryLimitMB=8;
	$memoryLimit = $memoryLimitMB*$MB;
	if (function_exists('memory_get_usage')&&(memory_get_usage()+$memoryNeeded)> $memoryLimit) 
	{
		$addMB=ceil((memory_get_usage()+ $memoryNeeded-$memoryLimit)/$MB)+10;
		//$addMB=50;
		$newLimit = $memoryLimitMB +$addMB ;
		ini_set('memory_limit',$newLimit.'M' );
		return true;
	}
	else
	{
		return false;
	}
}

function getImageInfo($img) {
        $imageInfo = getimagesize($img);
        if ($imageInfo !== false) {
            $imageType = strtolower(substr(image_type_to_extension($imageInfo[2]), 1));
            $imageSize = filesize($img);
            $info = array(
                "width" => $imageInfo[0],
                "height" => $imageInfo[1],
                "type" => $imageType,
                "size" => $imageSize,
                "mime" => $imageInfo['mime']
            );
            return $info;
        } else {
            return false;
        }
}
function thumb($image, $thumbname, $type='', $maxWidth=200, $maxHeight=50, $interlace=true) {
        // 获取原图信息
		setMemoryForImage($image);
        $info = getImageInfo($image);
				
        if ($info !== false) {
            $srcWidth = $info['width'];
            $srcHeight = $info['height'];
            $type = empty($type) ? $info['type'] : $type;
            $type = strtolower($type);
            $interlace = $interlace ? 1 : 0;
            unset($info);
            $scale = min($maxWidth / $srcWidth, $maxHeight / $srcHeight); // 计算缩放比例
            if ($scale >= 1) {
                // 超过原图大小不再缩略
                $width = $srcWidth;
                $height = $srcHeight;
            } else {
                // 缩略图尺寸
                $width = (int) ($srcWidth * $scale);
                $height = (int) ($srcHeight * $scale);
            }

            // 载入原图
            $createFun = 'ImageCreateFrom' . ($type == 'jpg' ? 'jpeg' : $type);
            $srcImg = $createFun($image);

            //创建缩略图
            if ($type != 'gif' && function_exists('imagecreatetruecolor'))
                $thumbImg = imagecreatetruecolor($width, $height);
            else
                $thumbImg = imagecreate($width, $height);

            // 复制图片
            if (function_exists("ImageCopyResampled"))
                imagecopyresampled($thumbImg, $srcImg, 0, 0, 0, 0, $width, $height, $srcWidth, $srcHeight);
            else
                imagecopyresized($thumbImg, $srcImg, 0, 0, 0, 0, $width, $height, $srcWidth, $srcHeight);
            if ('gif' == $type || 'png' == $type) {
                //imagealphablending($thumbImg, false);//取消默认的混色模式
                //imagesavealpha($thumbImg,true);//设定保存完整的 alpha 通道信息
                $background_color = imagecolorallocate($thumbImg, 0, 255, 0);  //  指派一个绿色
                imagecolortransparent($thumbImg, $background_color);  //  设置为透明色，若注释掉该行则输出绿色的图
            }

            // 对jpeg图形设置隔行扫描
            if ('jpg' == $type || 'jpeg' == $type)
                imageinterlace($thumbImg, $interlace);

            //$gray=ImageColorAllocate($thumbImg,255,0,0);
            //ImageString($thumbImg,2,5,5,"ThinkPHP",$gray);
            // 生成图片
            $imageFun = 'image' . ($type == 'jpg' ? 'jpeg' : $type);
            $imageFun($thumbImg, $thumbname);
            imagedestroy($thumbImg);
            imagedestroy($srcImg);
            return $thumbname;
        }
        return false;
}

//thumb("1280851264_0.jpg", "th1280851264_0.jpg", $type='jpg', $maxWidth=200, $maxHeight=150, $interlace=true);

?>