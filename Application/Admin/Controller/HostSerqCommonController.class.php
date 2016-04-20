<?php
/**
 *主机质量和服务质量监控共用类
 *
 */
class HostSerqCommonController extends CommonController {
	
	//CPU
	function getCPUchartData(){
		$ip =  "172.17.3.86";//$_REQUEST['ip'];
		$begin = 1;//(time()-1)*1000;
		$end = time()*1000;
		
		$urlpath = "/cpu/$ip/$begin/$end";
		$model = CM("Serqualitymon");
		$result = $model->sendHostSerqualitBase($urlpath);
		$list = $result['data'];
		
		echo $list;
	}
	
	//内存
	function getMemchartData(){
		$ip =  "172.17.3.86";//$_REQUEST['ip'];
		$begin =  1;//(time()-1)*1000;
		$end = time()*1000;
		
		$urlpath = "/mem/$ip/$begin/$end";
		$model = CM("Serqualitymon");
		$result = $model->sendHostSerqualitBase($urlpath);
		$list = json_encode($result['data']);
		
		echo $list;
	}
	//磁盘
	function getDiskchartData(){
		$ip =  "172.17.3.86";//$_REQUEST['ip'];
		$begin =  1;//(time()-1)*1000;
		$end = time()*1000;
	
		$urlpath = "/disk/$ip/$begin/$end";
		$model = CM("Serqualitymon");
		$result = $model->sendHostSerqualitBase($urlpath);
		$list = $result['data'];
		echo $list;
	}
	//网络
	function getNetworkchartData(){
		$ip =  "172.17.3.86";//$_REQUEST['ip'];
		$begin = 1;
		$end = time()*1000;
	
		$urlpath = "/network/$ip/$begin/$end";
		$model = CM("Serqualitymon");
		$result = $model->sendHostSerqualitBase($urlpath);
		$list = json_encode($result['data']);
		
		echo $list;
		//echo 'data":[{"time":1437121385000，"load1":"70"，"load5":"75"，"load15":"80"，"userPercent":"用户占比"，"sysPercent":"系统占比"，"idlePercent":"空闲占比"}]';
	}
	
	function getNetCpuMemchartData(){
		$model = CM("Serqualitymon");
		///////////////得到cpu信息/////////////////////////////
		$ip =  "172.17.3.86";//$_REQUEST['ip'];
		$begin = 1;//(time()-1)*1000;
		$end = time()*1000;//$_REQUEST['endTime'];//
		
		$urlpath = "/cpu/$ip/$begin/$end";
		$result = $model->sendHostSerqualitBase($urlpath);
		$list = $result['data'];
		$time = array();
		$load1 = array();
		$load5 = array();
		$load15 = array();
		$userpercent = array();
		$sysPercent = array();
		$idlePercent= array();;
		foreach($list as $k =>$v){
			$time[$k] = date("m-d H:i:s",$v['time']/1000);
			$load1[$k] = $v['load1'];
			$load5[$k] = $v['load5'];
			$load15[$k] = $v['load15'];
			$userpercent[$k] = $v['userPercent'];
			$sysPercent[$k] = $v['sysPercent'];
			$idlePercent[$k] = $v['idlePercent'];
			
		}
		$this->assign("time",json_encode($time));
		$this->assign("load1",json_encode($load1));
		$this->assign("load5",json_encode($load5));
		$this->assign("load15",json_encode($load15));
		$this->assign("userpercent",json_encode($userpercent));
		$this->assign("sysPercent",json_encode($sysPercent));
		$this->assign("idlePercent",json_encode($idlePercent));
		////////////////////完///////////////////////////////////
		//////////////获取主机内存数据///////////////////////////////
		$urlpath = "/mem/$ip/$begin/$end";
		$result = $model->sendHostSerqualitBase($urlpath);
		$list = $result['data'];
		$totalSwap = array();
		$availSwap = array();
		$totalReal = array();
		$availReal = array();
		$totalFree = array();
		foreach($list as $k =>$v){
			$time[$k] = date("m-d H:i:s",$v['time']/1000);
			$totalSwap[$k] = $v['totalSwap'];
			$availSwap[$k] = $v['availSwap'];
			$totalReal[$k] = $v['totalReal'];
			$availReal[$k] = $v['availReal'];
			$totalFree[$k] = $v['totalFree'];
				
		}
		$this->assign("timeMem",json_encode($time));
		$this->assign("totalSwap",json_encode($totalSwap));
		$this->assign("availSwap",json_encode($availSwap));
		$this->assign("totalReal",json_encode($totalReal));
		$this->assign("availReal",json_encode($availReal));
		$this->assign("totalFree",json_encode($totalFree));
		////////////////完///////////////////////////////
		//////////////获取网络数据//////////////////////////
		$urlpath = "/network/$ip/$begin/$end";
		$result = $model->sendHostSerqualitBase($urlpath);
		$list = $result['data'];
		$eth0In = array();
		$eth0Out= array();
		$loIn = array();
		$loOut = array();
		$nettime = array();
		foreach($list as $k =>$v){
			if($v['ifName'] == 'eth0'){
				$eth0In[] = $v['bytesIn'];
				$eth0Out[] = $v['bytesOut'];
			}
			if($v['ifName'] == 'lo'){
				$loIn[] = $v['bytesIn'];
				$loOut[] = $v['bytesOut'];
			}
			if(!in_array(date("m-d H:i:s",$v['time']/1000),$nettime)){
				$nettime[] = date("m-d H:i:s",$v['time']/1000);
			}
		
		}
		$this->assign("timeNet",json_encode($nettime));
		$this->assign("eth0In",json_encode($eth0In));
		$this->assign("eth0Out",json_encode($eth0Out));
		$this->assign("loIn",json_encode($loIn));
		$this->assign("loOut",json_encode($loOut));
		///////////////////////////////////////////////
		//////////////获取磁盘数据//////////////////////////
		$urlpath = "/disk/$ip/$begin/$end";
		$result = $model->sendHostSerqualitBase($urlpath);
		$list = $result['data'];
		$total = array();
		$free = array();
		$used = array();
		$disktime = array();
		foreach($list as $k =>$v){
			$total[] = $v['total'];
			$free[] = $v['free'];
			$used[] = $v['used'];
			$disktime[] = date("m-d H:i:s",$v['time']/1000);
		}
		$this->assign("disktime",json_encode($disktime));
		$this->assign("total",json_encode($total));
		$this->assign("free",json_encode($free));
		$this->assign("used",json_encode($used));
		///////////////////////////////////////////////
	}
	
		
}
