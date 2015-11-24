<?php
//获取天气信息函数
function weatherInfo($timeout=1,$tryNum=1){
	$source = "http://m.weather.com.cn/data/101040100.html";//"http://hongyan.cqupt.edu.cn/wap/index_mobile.php";
	
	$jsonDir = "admin/js/weather.json";			//本地json文件路径
	$local = "images/weatherImg/";	//本地天气图片路径

	$hasJson = file_exists($jsonDir);
	if($hasJson == true){
		$json = @file_get_contents($jsonDir);
		$json = json_decode($json,true);
		encodingConvert($json,'UTF-8','GBK');
		$dateLast = isset($json['weatherinfo']['date_y']) ? $json['weatherinfo']['date_y'] : '';
		
		$res = array();
		preg_match_all('@(\d{4})年(\d{1,2})月(\d{1,2})日@',$dateLast,$res);
		if(!empty($res[1][0]) && !empty($res[2][0]) && !empty($res[3][0])){
			$jsonTime = $res[1][0].$res[2][0].$res[3][0];
			$e= date('Ymd') - $jsonTime;
			
			if($e == 0){
				$bigImg = $json['weatherinfo']['img1'];
				$result['bigImgPath'] = $local."b".$bigImg.".gif";

				$result['weather1'] = $json['weatherinfo']['weather1'];
				$result['temp1'] = $json['weatherinfo']['temp1'];
				$result['index_d'] = $json['weatherinfo']['index_d'];
				$result['date_y'] = $json['weatherinfo']['date_y'];
				return $result;
			}
		}
	}else{
		file_put_contents($jsonDir,'');
	}
	$ctx = stream_context_create(array(
		'http'=>array(
			'timeout'=>$timeout
			)
		)
	);
	for($i=0; $i<$tryNum; $i++){
		$json = @file_get_contents($source, false, $ctx);
	}
	
	//获取失败则取本地数据，成功则更新本地json文件
	if($json==false){
		$json = file_get_contents($jsonDir);
		if($json==false || $json==''){
			return false;
		}
	}else{
		file_put_contents($jsonDir,$json);
	}
	$json = json_decode($json,true);
	encodingConvert($json,'UTF-8','GBK');

	$bigImg = isset($json['weatherinfo']['img1']) ? $json['weatherinfo']['img1'] : '';
	$result['bigImgPath'] = $bigImg ? ($local."b".$bigImg.".gif") : '';

	$result['weather1'] = isset($json['weatherinfo']['weather1']) ? ($json['weatherinfo']['weather1']) : '无';
	$result['temp1'] = isset($json['weatherinfo']['temp1']) ? ($json['weatherinfo']['temp1']) : '无';
	$result['index_d'] = isset($json['weatherinfo']['index_d']) ? ($json['weatherinfo']['index_d']) : '无';
	$result['date_y'] = isset($json['weatherinfo']['date_y']) ? ($json['weatherinfo']['date_y']) : date('Y年m月d日',time());
	
	return $result;
}

