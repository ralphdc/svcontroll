<?php if (!defined('THINK_PATH')) exit();?><div id="monitorlist<?php echo ($_GET['mmId']); ?>">

<input type='hidden' id="setting<?php echo ($_GET['mmId']); ?>" value="<?php echo ($_GET['batchmerSetting']); ?>"/>
<input type='hidden' id="pauseStrategyBat<?php echo ($_GET['mmId']); ?>" value="1"/>
<div class="pageContent" style="width:100%">
<?php
 if($setRes['listSetting']){ $listSet = explode("|",trim($setRes['listSetting'],'|')); $width = 0; $th = ''; $td = ''; foreach ($listSet as $v){ $width += $list[$v]['W']; $th .= "<th style='width:".$list[$v]['W']."px'>".$list[$v]['T']."</th>"; $td .= "<td height='0'></td>"; $$v = true; } }else{ $width = '100%'; $td = '当前未设置监控数据显示，请点击“监控设置”进行设置！'; } ?>

<table class="list" width="<?php if($width<1260){ echo 1260;}else{echo $width;}?>" layoutH="30">
	<thead>
		<tr>
		<?php echo $th;?>
		</tr>
	</thead>
	<tbody>
		<tr><?php echo $td;?></tr>
	</tbody>
</table>
</div>
</div>


<script type="text/javascript">
//var strategyComet = null;Strategy
var isconn = 0;
var timestamp = 0;
var checkcode = '';
var strategyURL = '/InvokRedis.php';
var cardflag = new Array('否','是');
var isiccard = new Array('否','是');
var msgflag = new Array('否','是');
var trnum = 0;
var tid = '';
var app = '';
var appname = new Array();
<?php foreach($appname as $k=>$v){?>
appname['<?php echo $k; ?>'] = '<?php echo $v; ?>';
<?php }?>


var StrategyComet = function (data_url,strategyid){
	this.strategyURL = data_url;
	this.connect = function(){
		//多个策略页面，关闭页面后，不再请求网络
		var pause = $("#pauseStrategyBat"+strategyid).val();
		if(pause == 0 || pause == ''|| pause == undefined){
			return;
		}
		timestamp = new Date().getTime();
	    var self = this;
	    $.ajax({
	    	cache : false,
			type : 'post',
			url : this.strategyURL,
			global: false,
			dataType : 'json',
			async : true,
			data : {'_' : timestamp,'StrategyBatid':strategyid},
			success : function(response){
				if(response.id !== "undefined" && response.id !== "" && response.id !== "0000"){
					//过滤商户号终端号
					var merchcodeTermon = response.lm_merchcode + response.ltl_termno;
					var settingCode = $("#setting<?php echo ($_GET['mmId']); ?>").val();
					if(settingCode == ''){return;}
					var settingCodeArr = settingCode.split(";"); 
					if($.inArray(merchcodeTermon, settingCodeArr) >= 0){
						self.handleResponse(response);
						tid = response.id;
					}
				}
			},
			complete : function(){
				self.connect();
			}
	    });
	};
	

	this.handleResponse = function(response){
		trnum ++;
		var css = '';
		var ishow = false;
		var str='';
		var std = '';
		if(response.v_ltl_status != "1"){
			css = ' style="color:red;"';
		}
		if(trnum % 2 == 1){
			str = '<tr>';
		}else{
			str = '<tr class="trbg">';
		}
		//1接入端交易时间
		ishow = '<?php echo $LTL_TIME;?>';
		if(ishow){
			std += '<td'+css+'>'+response.ltl_time+'</td>';
		}
		
		//2接入终端号
		ishow = '<?php echo $LTL_TERMNO;?>';
		if(ishow){
			std += '<td'+css+'>'+response.ltl_termno+'</td>';
		}

		//3终端版本号
		ishow = '<?php echo $TERM_VER;?>';
		if(ishow){
			std += '<td'+css+'>'+response.term_ver+'</td>';
		}

		//4交易类型
		ishow = '<?php echo $V_LTL_TYPE;?>';
		if(ishow){
			std += '<td'+css+'>'+response.v_ltl_type+'</td>';
		}

		//5交易金额
		ishow = '<?php echo $LTL_AMOUNT;?>';
		if(ishow){
			std += '<td'+css+'>'+response.ltl_amount+'</td>';
		}

		//6交易状态
		ishow = '<?php echo $V_LTL_STATUS;?>';
		if(ishow){
			var trdstate = new Array('已发送','成功','失败');
			std += '<td'+css+'>'+trdstate[response.v_ltl_status]+'</td>';
		}

		//7接入应答码
		ishow = '<?php echo $LTL_DEMO;?>';
		if(ishow){
			std += '<td'+css+'>'+response.ltl_demo+'</td>';
		}
		
		//8卡号
		ishow = '<?php echo $LTL_CARDNO;?>';
		if(ishow){
			std += '<td'+css+'>'+response.ltl_cardno+'</td>';
		}

		//9接入端流水号
		ishow = '<?php echo $LTL_VOUCHNO;?>';
		if(ishow){
			std += '<td'+css+'>'+response.ltl_vouchno+'</td>';
		}

		//10接入端商户号
		ishow = '<?php echo $LM_MERCHCODE;?>';
		if(ishow){
			std += '<td'+css+'>'+response.lm_merchcode+'</td>';
		}

		//11接入端商户名
		ishow = '<?php echo $LM_MERCHNAME;?>';
		if(ishow){
			std += '<td'+css+'>'+response.lm_merchname+'</td>';
		}

		//12接入端清算时间
		ishow = '<?php echo $LTL_RECKON;?>';
		if(ishow){
			std += '<td'+css+'>'+response.ltl_reckon+'</td>';
		}

		//13接入端自增ID
		ishow = '<?php echo $LTL_AUTOID;?>';
		if(ishow){
			std += '<td'+css+'>'+response.ltl_autoid+'</td>';
		}

		//14路由规则名
		ishow = '<?php echo $RR_NAME;?>';
		if(ishow){
			std += '<td'+css+'>'+response.rr_name+'</td>';
		}

		//15卡名称
		ishow = '<?php echo $CARD_NAME;?>';
		if(ishow){
			std += '<td'+css+'>'+response.card_name+'</td>';
		}

		//16卡类型
		ishow = '<?php echo $CARD_TYPE;?>';
		if(ishow){
			std += '<td'+css+'>'+response.card_type+'</td>';
		}

		//17是否外卡
		ishow = '<?php echo $LTL_CARDFLAG;?>';
		if(ishow){
			std += '<td'+css+'>'+cardflag[response.ltl_cardflag]+'</td>';
		}

		//18短信认证状态
		ishow = '<?php echo $LTL_MSG_STATUS;?>';
		if(ishow){
			std += '<td'+css+'>'+msgflag[response.ltl_msg_status]+'</td>';
		}

		//19风控规则名
		ishow = '<?php echo $RULENAME;?>';
		if(ishow){
			std += '<td'+css+'>'+response.rulename+'</td>';
		}

		//20应用ID
		ishow = '<?php echo $LTL_APPID;?>';
		if(ishow){
			if(appname[response.ltl_appid] !== 'undefined' && appname[response.ltl_appid] != null){
				app = ' ' + appname[response.ltl_appid];
			}
			std += '<td'+css+'>'+response.ltl_appid+app+'</td>';
		}

		//21系统参考号
		ishow = '<?php echo $LTL_REFNO;?>';
		if(ishow){
			std += '<td'+css+'>'+response.ltl_refno+'</td>';
		}

		//22是否IC卡
		ishow = '<?php echo $RSD_BICC;?>';
		if(ishow){
			if(response.rsd_bicc ==""){
				response.rsd_bicc = 1;
			}
			std += '<td'+css+'>'+isiccard[response.rsd_bicc]+'</td>';
		}

		//23渠道终端号
		ishow = '<?php echo $RTL_TERMNO;?>';
		if(ishow){
			std += '<td'+css+'>'+response.rtl_termno+'</td>';
		}

		//24渠道应答码
		ishow = '<?php echo $RTL_DEMO;?>';
		if(ishow){
			std += '<td'+css+'>'+response.rtl_demo+'</td>';
		}

		//25渠道流水号
		ishow = '<?php echo $RTL_VOUCHNO;?>';
		if(ishow){
			std += '<td'+css+'>'+response.rtl_vouchno+'</td>';
		}

		//26渠道商户号
		ishow = '<?php echo $RM_MERCHCODE;?>';
		if(ishow){
			std += '<td'+css+'>'+response.rm_merchcode+'</td>';
		}

		//27渠道商户名
		ishow = '<?php echo $RM_MERCHNAME;?>';
		if(ishow){
			std += '<td'+css+'>'+response.rm_merchname+'</td>';
		}

		//28渠道清算时间
		ishow = '<?php echo $RTL_RECKON;?>';
		if(ishow){
			std += '<td'+css+'>'+response.rtl_reckon+'</td>';
		}
		
		//29渠道自增ID
		ishow = '<?php echo $CHANNELId;?>';
		if(ishow){
			std += '<td'+css+'>'+response.CHANNELId+'</td>';
		}
		
		var trss = str + std +'</tr>';
		var $box = $("#monitorlist<?php echo ($_GET['mmId']); ?>");
		var tbody = $box.find("tbody");
    	$(tbody).prepend(trss);
	};
};

$(function(){
	var strategyComett = new StrategyComet(strategyURL,"<?php echo ($_GET['mmId']); ?>");
	strategyComett.connect();
})

</script>