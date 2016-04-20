<?php if (!defined('THINK_PATH')) exit();?><style type="text/css">
.foldContent{display:none;}
.curveContent{display:none;}
.linkContent{height:390px;}
</style>
<div class="pageFormContent linkContent"  id="set_link_dialog">
	<div class="innerContent" layoutH="58">
		<!-- <p>
			<label>连线类型：</label>
			<select class="linkType" name="linkType" onchange="toggleLinkType('linkType')">
				<option value="straight" selected="selected">直线</option>
				<option value="fold">折线</option>
				<option value="curve">曲线</option>
			</select>
		</p> -->
		
		<p><label>连线类型：</label><span class="ltname"></span></p>
		<p>
			<label>连线文本：</label>
			<input type="text" name="linkText" class="linkText" value="" />
		</p>
		<div class="straightContent">
			<p>
				<label>线宽：</label>
				<select name="straight_link_width" class="straight_link_width">
					<option value="1" selected="selected">1</option>
					<option value="2">2</option>
					<option value="3">3</option>
					<option value="4">4</option>
					<option value="5">5</option>
					<option value="6">6</option>
					<option value="7">7</option>
					<option value="8">8</option>
					<option value="9">9</option>
					<option value="10">10</option>
				</select>
			</p> 
			<p>
				<label>箭头大小：</label>
				<select name="straight_arrow_size" class="straight_arrow_size">
					<option value="1" selected="selected">1</option>
					<option value="2">2</option>
					<option value="3">3</option>
					<option value="4">4</option>
					<option value="5">5</option>
					<option value="6">6</option>
					<option value="7">7</option>
					<option value="8">8</option>
					<option value="9">9</option>
					<option value="10">10</option>
					<option value="11" >11</option>
					<option value="12">12</option>
					<option value="13">13</option>
					<option value="14">14</option>
					<option value="15">15</option>
					<option value="16">16</option>
					<option value="17">17</option>
					<option value="18">18</option>
					<option value="19">19</option>
					<option value="20">20</option>
				</select>
			</p> 
			<p>
				<label>线体：</label>
				<select name="straight_link_dash_pattern" class="straight_link_dash_pattern">
					<option value="default" selected="selected">实线</option>
					<option value="dashedPattern">虚线</option>
				</select>
			</p> 
				<!--
			<p>
				<label>线条间隔：</label>
				<select name="straight_link_bundleGap" class="straight_link_bundleGap">
					<option value="1" selected="selected">1</option>
					<option value="2">2</option>
					<option value="3">3</option>
					<option value="4">4</option>
					<option value="5">5</option>
					<option value="6">6</option>
					<option value="7">7</option>
					<option value="8">8</option>
					<option value="9">9</option>
					<option value="10">10</option>
				</select>
			</p>
			-->
			<!-- 
			<p>
				<label>文本偏移量：</label>
				<select name="straight_link_offset" class="straight_link_offset">
					<option value="10" selected="selected">10</option>
					<option value="20">20</option>
					<option value="30">30</option>
					<option value="40">40</option>
					<option value="50">50</option>
					<option value="60">60</option>
					<option value="70">70</option>
					<option value="80">80</option>
					<option value="90">90</option>
					<option value="100">100</option>
				</select>
			</p>
			 -->
			<p>
				<label>线体颜色：</label>
				<input type="text" name="straight_link_color" class="straight_link_color" value="255,255,0" placeholder="255,255,0" />
			</p>
		</div>
		<div class="foldContent">
			<p>
				<label>线宽：</label>
				<select name="fold_link_width" class="fold_link_width">
					<option value="1" selected="selected">1</option>
					<option value="2">2</option>
					<option value="3">3</option>
					<option value="4">4</option>
					<option value="5">5</option>
					<option value="6">6</option>
					<option value="7">7</option>
					<option value="8">8</option>
					<option value="9">9</option>
					<option value="10">10</option>
					<option value="11">11</option>
					<option value="12">12</option>
					<option value="13">13</option>
					<option value="14">14</option>
					<option value="15">15</option>
					<option value="16">16</option>
					<option value="17">17</option>
					<option value="18">18</option>
					<option value="19">19</option>
					<option value="20">20</option>
				</select>
			</p> 
			<p>
				<label>箭头大小：</label>
				<select name="fold_arrow_size" class="fold_arrow_size">
					<option value="1" selected="selected">1</option>
					<option value="2">2</option>
					<option value="3">3</option>
					<option value="4">4</option>
					<option value="5">5</option>
					<option value="6">6</option>
					<option value="7">7</option>
					<option value="8">8</option>
					<option value="9">9</option>
					<option value="10">10</option>
					<option value="11" >11</option>
					<option value="12">12</option>
					<option value="13">13</option>
					<option value="14">14</option>
					<option value="15">15</option>
					<option value="16">16</option>
					<option value="17">17</option>
					<option value="18">18</option>
					<option value="19">19</option>
					<option value="20">20</option>
				</select>
			</p> 
			<!-- 
			<p>
				<label>拐角长度：</label>
				<select name="fold_bundleOffset" class="fold_bundleOffset">
					<option value="1" selected="selected">10</option>
					<option value="20">20</option>
					<option value="30">30</option>
					<option value="40">40</option>
					<option value="50">50</option>
					<option value="60">60</option>
					<option value="70">70</option>
					<option value="80">80</option>
					<option value="90">90</option>
					<option value="100">100</option>
					<option value="110" >110</option>
					<option value="120">120</option>
					<option value="130">130</option>
					<option value="140">140</option>
					<option value="150">150</option>
					<option value="160">160</option>
					<option value="170">170</option>
					<option value="180">180</option>
					<option value="190">190</option>
					<option value="200">200</option>
				</select>
			</p> 
			 -->
			 <!-- 
			<p>
				<label>文本偏移量：</label>
				<select name="fold_link_offset" class="fold_link_offset">
					<option value="10" selected="selected">10</option>
					<option value="20">20</option>
					<option value="30">30</option>
					<option value="40">40</option>
					<option value="50">50</option>
					<option value="60">60</option>
					<option value="70">70</option>
					<option value="80">80</option>
					<option value="90">90</option>
					<option value="100">100</option>
				</select>
			</p>
			 -->
			<!--
			<p>
				<label>线条间隔：</label>
				<select name="fold_link_bundleGap" class="fold_link_bundleGap">
					<option value="1" selected="selected">1</option>
					<option value="2">2</option>
					<option value="3">3</option>
					<option value="4">4</option>
					<option value="5">5</option>
					<option value="6">6</option>
					<option value="7">7</option>
					<option value="8">8</option>
					<option value="9">9</option>
					<option value="10">10</option>
				</select>
			</p>
				-->
			<p>
				<label>线体：</label>
				<select name="fold_link_dash_pattern" class="fold_link_dash_pattern">
					<option value="default" selected="selected">实线</option>
					<option value="dashedPattern">虚线</option>
				</select>
			</p>
			<p>
				<label>线体颜色：</label>
				<input type="text" name="fold_link_color" class="fold_link_color" value="255,255,0" placeholder="255,255,0" />
			</p>
		</div>
		<div class="curveContent">
			<p>
				<label>线宽：</label>
				<select name="curve_link_width" class="curve_link_width">
					<option value="1" selected="selected">1</option>
					<option value="2">2</option>
					<option value="3">3</option>
					<option value="4">4</option>
					<option value="5">5</option>
					<option value="6">6</option>
					<option value="7">7</option>
					<option value="8">8</option>
					<option value="9">9</option>
					<option value="10">10</option>
					<option value="11" >11</option>
					<option value="12">12</option>
					<option value="13">13</option>
					<option value="14">14</option>
					<option value="15">15</option>
					<option value="16">16</option>
					<option value="17">17</option>
					<option value="18">18</option>
					<option value="19">19</option>
					<option value="20">20</option>
				</select>
			</p> 
			<p>
				<label>箭头大小：</label>
				<select name="curve_arrow_size" class="curve_arrow_size">
					<option value="1" selected="selected">1</option>
					<option value="2">2</option>
					<option value="3">3</option>
					<option value="4">4</option>
					<option value="5">5</option>
					<option value="6">6</option>
					<option value="7">7</option>
					<option value="8">8</option>
					<option value="9">9</option>
					<option value="10">10</option>
					<option value="11" >11</option>
					<option value="12">12</option>
					<option value="13">13</option>
					<option value="14">14</option>
					<option value="15">15</option>
					<option value="16">16</option>
					<option value="17">17</option>
					<option value="18">18</option>
					<option value="19">19</option>
					<option value="20">20</option>
				</select>
			</p> 
			<!-- 
			<p>
				<label>文本偏移量：</label>
				<select name="curve_link_offset" class="curve_link_offset">
					<option value="10" selected="selected">10</option>
					<option value="20">20</option>
					<option value="30">30</option>
					<option value="40">40</option>
					<option value="50">50</option>
					<option value="60">60</option>
					<option value="70">70</option>
					<option value="80">80</option>
					<option value="90">90</option>
					<option value="100">100</option>
				</select>
			</p>
			 -->
			 <!-- 
				曲线-虚线设置无效果；
			<p>
				<label>线体：</label>
				<select name="curve_link_dash_pattern" class="curve_link_dash_pattern">
					<option value="default" selected="selected">实线</option>
					<option value="dashedPattern">虚线</option>
				</select>
			</p>
			 -->
			<!--
			 <p>
				<label>线条间隔：</label>
				<select name="curve_link_bundleGap" class="curve_link_bundleGap">
					<option value="1" selected="selected">1</option>
					<option value="2">2</option>
					<option value="3">3</option>
					<option value="4">4</option>
					<option value="5">5</option>
					<option value="6">6</option>
					<option value="7">7</option>
					<option value="8">8</option>
					<option value="9">9</option>
					<option value="10">10</option>
				</select>
			</p>
			 -->
			<p>
				<label>线体颜色：</label>
				<input type="text" name="curve_link_color" class="curve_link_color" value="255,255,0" placeholder="255,255,0" />
			</p>
		</div>
	</div>
	<div class="formBar">
		<ul>
			<li><div class="buttonActive"><div class="buttonContent"><button type="submit" id="setLinkSubmit" onclick="setLinkNewConfig()">保存</button></div></div></li>
			<li><div class="button"><div class="buttonContent"><button type="button" class="close">取消</button></div></div></li>
		</ul>
	</div>
</div>

<script type="text/javascript">

	//读取配置，确定当前连线类型；
	//2016-0310
	$(document).ready(function(){
		if(!JPStore) alertMsg.error("您的浏览器版本不兼容此项功能~！");
		var currentType = getCurrentLinkType();
		if(currentType == 'straight'){
			$(".ltname").text('直线');
			var cLTContent = $(".straightContent");
		}else if(currentType == 'fold'){
			$(".ltname").text('折线');
			var cLTContent = $(".foldContent");
		}else if(currentType == 'curve'){
			$(".ltname").text('曲线');
			var cLTContent = $(".curveContent");
		}else{
			alertMsg.error("程序出现错误！请稍后再试~！");
			$.pdialog.closeCurrent();
			return false;
		}
		cLTContent.show();
		cLTContent.siblings("div:not('.formBar')").hide();
	})
	/**
		** 获取当前联线类型；2016-03-10；
	**/
	function getCurrentLinkType()
	{
		var lkNode = scene.selectedElements;
		if (lkNode[0] instanceof JTopo.Link) {
			return lkNode[0].linkSetInfo.ltype || '';
		}
	}
	
	function setLinkNewConfig()
	{
		if (!scene) return false;
		var lkNode = scene.selectedElements;
		if (lkNode[0] instanceof JTopo.Link) {
			//scene.remove(lkNode[0]);
			var sLType = getCurrentLinkType();
			var JPlinkSelect = {};
			//获取连线文本；
			JPlinkSelect.ltext = $(".linkText").val();
			//直线
			if(sLType == 'straight'){
				//线体类型；
				JPlinkSelect.ltype 			= 'straight';
				//线宽；
				JPlinkSelect.lwidth 		= $(".straight_link_width").val();
				//箭头大小；
				JPlinkSelect.larrowsize 	= $(".straight_arrow_size").val();
				//虚实；
				JPlinkSelect.lpattern 		= $(".straight_link_dash_pattern").val();
				//线体间隔；
				//JPlinkSelect.lbundlegap 	= $(".straight_link_bundleGap").val();
				//文本偏移量；
				//JPlinkSelect.loffset 		= $(".straight_link_offset").val();
				//线体颜色；
				JPlinkSelect.lcolor 		= $(".straight_link_color").val();
			//折线；
			}else if(sLType == 'fold'){
				//线体类型；
				JPlinkSelect.ltype 					= 'fold';
				//线宽；
				JPlinkSelect.lwidth 				= $(".fold_link_width").val();
				//箭头大小；
				JPlinkSelect.larrowsize 			= $(".fold_arrow_size").val();
				//虚实；
				JPlinkSelect.lpattern 				= $(".fold_link_dash_pattern").val();
				//线体间隔；
				//JPlinkSelect.lbundlegap 			= $(".fold_link_bundleGap").val();
				//文本偏移量；
				//JPlinkSelect.loffset 				= $(".fold_link_offset").val();
				//线体颜色；
				JPlinkSelect.lcolor 				= $(".fold_link_color").val();
				//拐角长度；
				//JPlinkSelect.lbundleOffset 			= $(".fold_bundleOffset").val();
			//曲线；
			}else{
				//线体类型；
				JPlinkSelect.ltype 					= 'curve';
				//线宽；
				JPlinkSelect.lwidth 				= $(".curve_link_width").val();
				//箭头大小；
				JPlinkSelect.larrowsize 			= $(".curve_arrow_size").val();
				//虚实；
				//JPlinkSelect.lpattern 				= $(".curve_link_dash_pattern").val();
				//线体间隔；
				//JPlinkSelect.lbundlegap 			= $(".curve_link_bundleGap").val();
				//文本偏移量；
				//JPlinkSelect.loffset 				= $(".curve_link_offset").val();
				//线体颜色；
				JPlinkSelect.lcolor 				= $(".curve_link_color").val();
			}
			lkNode[0].text				=	 JPlinkSelect.ltext;			//连线文本；
			lkNode[0].lineWidth 		= 	 JPlinkSelect.lwidth; 			//宽度
			//lkNode[0].bundleGap 		= 	 JPlinkSelect.lbundlegap; 		//线体间隔；
			//lkNode[0].textOffsetY 		= 	 JPlinkSelect.loffset;			//文本偏移；
			lkNode[0].arrowsRadius 		= 	 JPlinkSelect.larrowsize;		//箭头大小；
			lkNode[0].strokeColor		=	 JPlinkSelect.lcolor;			//连线颜色；
			//虚实；
			if(JPlinkSelect.lpattern == 'dashedPattern') {
				lkNode[0].dashedPattern = JPlinkSelect.lwidth; 
			}else{
				lkNode[0].dashedPattern = null;
			}
			//折线拐角；
			/* if((JPlinkSelect.ltype == 'fold') && (JPlinkSelect.lbundleOffset > 0)){
				lkNode[0].bundleOffset = JPlinkSelect.lbundleOffset; 
			} */
			lkNode[0].linkSetInfo		=	 JPlinkSelect;
			$.pdialog.closeCurrent();
		} else {
			createTextNode('请先选择连线，然后点击删除！');
			$.pdialog.closeCurrent();
		}
	}
</script>