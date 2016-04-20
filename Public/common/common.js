/**
 * 公共函数库；
 * 2016-04-07；
 */

function IsTrue(str){
	if(str == null || str == undefined || str=='' || typeof(str) == 'undefined'){
		return false;
	}else{
		return true;
	}
}


/**
计算字符串中一个字符出现次数
**/

function countStrNumber(strChild,strParent){
	if(strChild.length > 1){
		alert('调用错误，请传入长度为一的单个字符！');
		return false;
	}
	if(IsTrue(strChild) && IsTrue(strParent)){
		if(strParent.indexOf(strChild) > -1){
			var parentArr = strParent.split("");
			var i=0;
			var count = 0;
			for(i; i<parentArr.length; i++){
				if(parentArr[i] == strChild) count++;
			}
			return count;
		}else{
			return 0;
		}
	}else{
		alert('子字符串或父字符串为假货！');
		return false;
	}
}