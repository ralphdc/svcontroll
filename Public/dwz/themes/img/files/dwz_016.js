/**
 * @author ZhangHuihua@msn.com
 */
(function($){
	// jQuery validate
	$.extend($.validator.messages, {
		required: "必填项",
		remote: "请修正该字段",
		email: "邮箱格式不正确",
		url: "请输入合法的网址",
		date: "请输入合法的日期",
		dateISO: "日期格式(ISO).",
		number: "请输入合法的数字",
		digits: "只能输入整数",
		creditcard: "请输入合法的信用卡号",
		equalTo: "请再次输入相同的值",
		accept: "字符串后缀名不正确",
		maxlength: $.validator.format("长度最长 {0} 位"),
		minlength: $.validator.format("长度最少 {0} 位"),
		rangelength: $.validator.format("长度介于 {0} 至 {1}"),
		range: $.validator.format("数值介于 {0}至{1}"),
		max: $.validator.format("不能超过最大值 {0}"),
		min: $.validator.format("不能小于最小值 {0}"),
		
		alphanumeric: "字母、数字、下划线",
		lettersonly: "必须是字母",
		phone: "数字、空格、括号"
	});
	
	// DWZ regional
	$.setRegional("datepicker", {
		dayNames: ['日', '一', '二', '三', '四', '五', '六'],
		monthNames: ['一月', '二月', '三月', '四月', '五月', '六月', '七月', '八月', '九月', '十月', '十一月', '十二月']
	});
	$.setRegional("alertMsg", {
		title:{error:"错误", info:"提示", warn:"警告", correct:"成功", confirm:"确认提示"},
		butMsg:{ok:"确定", yes:"是", no:"否", cancel:"取消"}
	});
})(jQuery);