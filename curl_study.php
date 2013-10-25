<?php
/*
 * Created on 2013-10-23
 *
 * To change the template for this generated file go to
 * Window - Preferences - PHPeclipse - PHP - Code Templates
 */
 	//$headers=array('Authorization'=>'Basic ZGFzZGFzOmRhc2Rhcw==');
 	function getData($a)
 	{
 		$i=0;
 		$a=$a/8;  //转换成Byte
 		while($i<2)  //到了G就不再转换了
 		{
 			$a=$a/1024;
 			$i++;
 		}
 		$ret=number_format($a,2).'MB';
 		return $ret;
 	}
 	$username="dasdas";
 	$password="dasdas";
 	$ch=curl_init();
 	curl_setopt($ch,CURLOPT_URL,"http://192.168.32.1/userRpm/SystemStatisticRpm.htm?interval=5&sortType=5&autoRefresh=2&Num_per_page=10&Goto_page=1");
 	//curl_setopt($ch,CURLOPT_URL,"http://192.168.32.1/");
 	curl_setopt($ch,CURLOPT_TIMEOUT,200);
 	//curl_setopt($ch,CURLOPT_HTTPHEADER,$headers);
 	curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
 	curl_setopt($ch,CURLOPT_HTTPAUTH,CURLAUTH_BASIC);
 	curl_setopt($ch,CURLOPT_USERPWD,"{$username}:{$password}");

 	$result=curl_exec($ch);
 	if($result===FALSE)
 	{
 		print curl_error($ch);
 	}
 	else
 	{
 		$pos1=stripos($result,"Array(");
 		$pos2=stripos($result,");");
 		$info=substr($result,$pos1+7,$pos2-$pos1-7);
 		$arr=explode(',',$info);
 		$result=array();
 		for($i=0;$i<intval(count($arr)/13);$i++)
 		{
 			//将每一项放到数组中
 			$ip=trim(trim($arr[13*$i+1]),'""');
 			$mac=trim(trim($arr[13*$i+2]),'"');
 			$speed=number_format(trim($arr[13*$i+6])/8/1024,2)."KB/s";
 			$data=number_format(trim($arr[13*$i+4])/8/1024/1024,2)."MB";
 			$a=array("IP"=>$ip,"MAC"=>$mac,"Speed"=>$speed,"Data"=>$data);
 			$result[$i]=$a;
 		}
 		print json_encode($result);
 	}
 	curl_close($ch);

?>
