<?php
// +----------------------------------------------------------------------
// | ThinkPHP
// +----------------------------------------------------------------------
// | Copyright (c) 2007 http://thinkphp.cn All rights reserved.
// +----------------------------------------------------------------------
// | Licensed ( http://www.apache.org/licenses/LICENSE-2.0 )
// +----------------------------------------------------------------------
// | Author: liu21st <liu21st@gmail.com>
// +----------------------------------------------------------------------
// $Id: common.php 2601 2012-01-15 04:59:14Z liu21st $

//公共函数
function toDate($time, $format = 'Y-m-d H:i:s') {
	if (empty ( $time )) {
		return '';
	}
	$format = str_replace ( '#', ':', $format );
	return date ($format, $time );
}

function getStatus($status, $imageShow = true) {
	switch ($status) {
		case 0 :
			$showText = '禁用';
			$showImg = '<IMG SRC="/Public/Images/locked.gif" WIDTH="20" HEIGHT="20" BORDER="0" ALT="禁用">';
			break;
		case 2 :
			$showText = '待审';
			$showImg = '<IMG SRC="/Public/Images/prected.gif" WIDTH="20" HEIGHT="20" BORDER="0" ALT="待审">';
			break;
		case - 1 :
			$showText = '删除';
			$showImg = '<IMG SRC="/Public/Images/del.gif" WIDTH="20" HEIGHT="20" BORDER="0" ALT="删除">';
			break;
		case 1 :
		default :
			$showText = '正常';
			$showImg = '<IMG SRC="/Public/Images/ok.gif" WIDTH="20" HEIGHT="20" BORDER="0" ALT="正常">';

	}
	return ($imageShow === true) ?  $showImg  : $showText;

}

function getNodeGroupName($id) {
	if (empty ( $id )) {
		return '未分组';
	}
	if (isset ( $_SESSION ['nodeGroupList'] )) {
		return $_SESSION ['nodeGroupList'] [$id];
	}
	$Group = D ( "Group" );
	$list = $Group->getField ( 'id,title' );
	$_SESSION ['nodeGroupList'] = $list;
	$name = $list [$id];
	return $name;
}

//囚鸟先生
function showStatus($status, $id, $callback="", $url, $dwz) {
	switch ($status) {
		case 0 :
			$info = '<a href="'.$url.'/resume/id/' . $id . '/navTabId/'.$dwz.'" target="ajaxTodo" callback="'.$callback.'">恢复</a>';
			break;
		case 2 :
			$info = '<a href="'.$url.'/checkPass/id/' . $id . '/navTabId/'.$dwz.'" target="ajaxTodo" callback="'.$callback.'">批准</a>';
			break;
		case 1 :
			$info = '<a href="'.$url.'/forbid/id/' . $id . '/navTabId/'.$dwz.'" target="ajaxTodo" callback="'.$callback.'">禁用</a>';
			break;
		case - 1 :
			$info = '<a href="'.$url.'/recycle/id/' . $id . '/navTabId/'.$dwz.'" target="ajaxTodo" callback="'.$callback.'">还原</a>';
			break;
	}
	return $info;
}


function getGroupName($id) {
	if ($id == 0) {
		return '无上级组';
	}
	if ($list = F ( 'groupName' )) {
		return $list [$id];
	}
	$dao = D ( "Role" );
	$list = $dao->select( array ('field' => 'id,name' ) );
	foreach ( $list as $vo ) {
		$nameList [$vo ['id']] = $vo ['name'];
	}
	$name = $nameList [$id];
	F ( 'groupName', $nameList );
	return $name;
}

function pwdHash($password, $type = 'md5') {
	return hash ( $type, $password );
}

function list_to_tree($list, $pk='id',$pid = 'pid',$child = '_child',$root=0){
    // 创建Tree
    $tree = array();
    if(is_array($list)) {
        // 创建基于主键的数组引用
        $refer = array();
        foreach ($list as $key => $data) {
            $refer[$data[$pk]] =& $list[$key];
        }
        foreach ($list as $key => $data) {
            // 判断是否存在parent
            $parentId = $data[$pid];
            if ($root == $parentId) {
                $tree[] =& $list[$key];
            }else{
                if(isset($refer[$parentId])) {
                    $parent =& $refer[$parentId];
                    $parent[$child][] =& $list[$key];
                }
            }
        }
    }
    return $tree;
}



//CommonModel 自动继承
function CM($name){
	static $_model = array();
	if(isset($_model[$name])){
		return $_model[$name];
	}
	$class=$name."Model";
	import('@.Model.' . $className);
	if(class_exists($class)){
		$return=new $class();
	}else{
		$return=M("CommonModel:".$name);
	}
	$_model[$name]=$return;
	//print_r($return);
	return $return;
}
//add by eaglezhao
//展示加密机配置是否默认
function showHsmDefault($isdefault){
	switch ($isdefault) {
		case 0 :
			$info = '是';
			break;
		case 1 :
			$info = '否';
			break;
		default:
			$info = '未知';
			break;

	}
	return $info;
}

function showLoadBalanceType($LoadBalanceType){
	switch ($LoadBalanceType) {
		case 'random' :
			$info = '权重随机';
			break;
		case 'roundRobin' :
			$info = '权重轮询';
			break;
		default:
			$info = '未知';
			break;
		
	}
	return $info;
}

//把字符转换为其所对应的十六进制
function stringToHex($asc)
{
	$r = '';
	$hexes = array ("0","1","2","3","4","5","6","7","8","9","A","B","C","D","E","F");
	for ($i=0; $i<strlen($asc); $i++) {$r .= ($hexes [(ord($asc{$i}) >> 4)] . $hexes [(ord($asc{$i}) & 0xf)]);}
	return $r;
}
//把十六进制转化为其所对应的字符
function hexToString($h)
{
	$r = "";
	for ($i= (substr($h, 0, 2)=="0x")?2:0; $i<strlen($h); $i+=2) {$r .= chr (base_convert (substr ($h, $i, 2), 16, 10));}
	return $r;
}
//对于字符按位异或
function getCrc($data,$length)
{
	$crc = hexToString('00');
	for($i=0;$i<$length;$i++)
		$crc = $crc^$data[$i];
		return $crc;
}

/*截取汉字字符串*/
function utf8_substr($String,$Length) {
	if (mb_strwidth($String, 'UTF8') <= $Length ){
		return $String;
	}else{
		$I = 0;
		$len_word = 0;
		while ($len_word < $Length){
		$StringTMP = substr($String,$I,1);
		if ( ord($StringTMP) >=224 ){
			$StringTMP = substr($String,$I,3);
			$I = $I + 3;
			$len_word = $len_word + 2;
			}elseif( ord($StringTMP) >=192 ){
			$StringTMP = substr($String,$I,2);
			$I = $I + 2;
			$len_word = $len_word + 2;
			}else{
			$I = $I + 1;
			$len_word = $len_word + 1;
			}
			$StringLast[] = $StringTMP;
			}
			/* raywang edit it for dirk for (es/index.php)*/
			if (is_array($StringLast) && !empty($StringLast)){
			$StringLast = implode("",$StringLast);
			$StringLast .= "...";
			}
			return $StringLast;
	}
}
//截取汉字字符串
function cut_str($string, $start = 0, $sublen, $code = 'UTF-8')
	{
	if($code == 'UTF-8'){
	$pa = "/[\x01-\x7f]|[\xc2-\xdf][\x80-\xbf]|\xe0[\xa0-\xbf][\x80-\xbf]|[\xe1-\xef][\x80-\xbf][\x80-\xbf]|\xf0[\x90-\xbf][\x80-\xbf][\x80-\xbf]|[\xf1-\xf7][\x80-\xbf][\x80-\xbf][\x80-\xbf]/";
	preg_match_all($pa, $string, $t_string);

	if(count($t_string[0]) - $start > $sublen) return join('', array_slice($t_string[0], $start, $sublen));
        return join('', array_slice($t_string[0], $start, $sublen));
   	 }
   	 else
   	 {
        $start = $start*2;
        $sublen = $sublen*2;
        $strlen = strlen($string);
        $tmpstr = '';

        for($i=0; $i< $strlen; $i++)
        {
        if($i>=$start && $i< ($start+$sublen))
        {
        if(ord(substr($string, $i, 1))>129)
        {
        $tmpstr.= substr($string, $i, 2);
	}
	else{
        	$tmpstr.= substr($string, $i, 1);
        }
        }
        if(ord(substr($string, $i, 1))>129) $i++;
        }
        return $tmpstr;
        }
        }
        
 //显示渠道切换各实例的状态
 function showChannelInstanceStatus($status){
 	switch ($status['status']) {
 	    case 0 :
 	        if( (intval($status['failedCheckTimes']) > 0) || (intval($status['successedCheckTimes']) > 0) ){
 	            $info = '正在检测';
 	        }else{
 	            $info = '未知';
 	        }
 		break;
 	    case 1 :
 	        if(intval($status['failedCheckTimes']) > 0){
 	            $info = '正在检测';
 	        }else{
 	            $info = '正常交易';
 	        }
 	    break;
 	    case 2 :
 	        if(intval($status['successedCheckTimes']) > 0){
 	            $info = '正在检测';
 	        }else{
 	            $info = '渠道异常';
 	        }
 	    break;
 	    case 3 :
 	     	$info = '暂停交易';
 	    break;
 	}
 	return $info;
 }

 //显示渠道状态
 function showChannelStatus($status){
 	switch ($status) {
 		/* case 0 :
 			$info = '未知';
 			break;
 		case 1 :
 			$info = '畅通';
 			break;
 		case 2 :
 			$info = '异常';
 			break;
 		case 3 :
 			$info = '已通知切换渠道';
 			break;
 		case 4:
 			$info ='没有实例';
 			break;
 		default:
 			$info = '未知';
 			break; */
 			
		case 0 :
		    $info = '未知（待检测）';
		    break;
		case 1 :
		    $info = '正常';
		    break;
		case 2 :
		    $info = '<span style="color:red">异常</span>';
		    break;
		case 3 :
		    $info = '<span style="color:red">异常（可能需要手动切换渠道）</span>';
		    break;
		case 4 :
		    $info = '已通知切换渠道';
		    break;
		case 5 :
		    $info = '没有实例';
		    break;
		case 6 :
		    $info = '已通知切换渠道（探测正常，等待手动切回该渠道）';
		    break;
		default:
		 	$info = '未知（待检测）';
		break;
 
 	}
 	return $info;
 
 }
 
 //判断数组真实性；2015-11-13
 function checkIsArray($arr)
 {
     if(!is_array($arr) || empty($arr) || count($arr) < 1 || !isset($arr[0]) || empty($arr[0]) ){
         return false;
     }else{
         return true;
     }
 }
