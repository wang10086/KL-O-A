<?php use Sys\P; ?>
<!DOCTYPE html>
<html>
    <head>
        <meta charset="UTF-8">
        <title><?php echo P::SYSTEM_NAME; ?></title>
        <meta content='width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no' name='viewport'>
        <!-- bootstrap 3.0.2 -->
        <link href="__HTML__/css/bootstrap.min.css" rel="stylesheet" type="text/css" />
        <!-- font Awesome -->
        <link href="__HTML__/css/font-awesome.min.css" rel="stylesheet" type="text/css" />
        <!-- Ionicons -->
        <link href="__HTML__/css/ionicons.min.css" rel="stylesheet" type="text/css" />
        <!-- jquery-ui style -->
        <link href="__HTML__/css/jQueryUI/jquery-ui-1.10.3.custom.min.css" rel="stylesheet" type="text/css" />
        <!-- ArtDialog -->
        <link href="__HTML__/css/artDialog.css" rel="stylesheet" type="text/css"  />
        <link href="__HTML__/css/artdialog/ui-dialog.css" rel="stylesheet" type="text/css" />
        <!-- Theme style -->
        <link href="__HTML__/comm/jquery.autocomplete.css" rel="stylesheet" type="text/css" />
        <link href="__HTML__/css/py.css" rel="stylesheet" type="text/css" />
        <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
        <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
        <!--[if lt IE 9]>
          <script src="__HTML__/js/html5shiv.min.js"></script>
          <script src="__HTML__/js/respond.min.js"></script>
        <![endif]-->
        <script src="__HTML__/js/jquery-1.7.2.min.js"></script>
        <script src="__HTML__/js/public.js"></script>
        <!-- Bootstrap -->
        <script src="__HTML__/js/bootstrap.min.js" type="text/javascript"></script>
        <?php echo PHP_EOL . $__additional_css__ ?>

    </head>
    <body>

		<script type="text/javascript">
        window.gosubmint= function(){
			$('#gosub').submit();
		} 
        </script>
       
        <section class="content">
        	<form method="post" action="{:U('Sale/signup')}" name="myform" id="gosub">
            <input type="hidden" name="dosubmit" value="1">
            <input type="hidden" name="opid" value="{$opid}">
            <input type="hidden" name="fornum" id="fornum" value="{$fornum}">
            <input type="hidden" name="info[pretium_id]" value="{$id}">
            <input type="hidden" name="info[group_id]" value="{$op.group_id}">
            <div class="form-group box-float-12" style="margin-bottom:5px;">
                <label style=" width:100%; padding-bottom:15px;border-bottom:2px solid #00c0ef">
                	<div style=" width:100%; float:left; line-height:34px; padding-bottom:10px;">{$sale.pretium} <font class="red">&yen;{$sale.sale_cost}</font> &nbsp;&nbsp;含{$sale.adult}成人，{$sale.children}儿童</div>
                    <div class="input-group jifenlist" style="width:120px; float:left; margin-right:10px;">
                        <span class="input-group-addon" style="width:30px; text-align:center; font-size:18px; cursor:pointer;" onClick="amount(0)">-</span>
                        <input type="text"  maxlength="2" readonly  class="form-control" value="1" id="aum" name="info[amount]" style=" background:#ffffff; text-align:center;">
                        <span class="input-group-addon" style="width:30px; text-align:center; font-size:18px; cursor:pointer;" onClick="amount(1)">+</span>
                    </div>
                    <div  style="width:176px; float:left; margin-right:10px;">
                    	<input type="text" placeholder="金额" class="form-control" name="info[cost]" id="cost" value="{$sale.sale_cost}" readonly>
                    </div>
                    <div  style="width:176px; float:left; margin-right:10px;">
                    	<input type="text" placeholder="实际付款金额" class="form-control" name="info[actual_cost]" value="">
                    </div>
                    <div  style="width:368px; float:left;">
                    	<input type="text" placeholder="备注" class="form-control" name="info[remark]" value="">
                    </div>
                </label>
            </div>
            
            <div class="form-group box-float-12" id="mingdan" style=" margin-top:-15px;"></div>
            <div id="user_val">1</div>
            <div id="sale_cost" style="display:none">{$sale.sale_cost}</div>
            </form>
        </section>


        <include file="Index:footer" />
        <script type="text/javascript"> 
	
		//新增名单
		function adduser(){
			var nums = parseInt($('#fornum').val());
			var html = '';
			for(i=0;i<nums;i++){
				html += '<div class="userlist" id="user_'+i+'"><span class="title"></span><input type="text" placeholder="姓名" class="form-control mem-name" name="member['+i+'][name]"><div class="input-group"><span class="input-group-addon">男<input type="radio" name="member['+i+'][sex]" value="男"></span><span class="input-group-addon" style="border-left:0;">女<input type="radio" name="member['+i+'][sex]" value="女"></span></div><input type="text" placeholder="证件号码" class="form-control mem-number" name="member['+i+'][number]"><input type="text" placeholder="联系电话" class="form-control mem-tel" name="member['+i+'][mobile]"><input type="text" placeholder="家长姓名" class="form-control mem-name" name="member['+i+'][ecname]"><input type="text" placeholder="家长电话" class="form-control mem-tel" name="member['+i+'][ecmobile]"><input type="text" placeholder="备注" class="form-control" name="member['+i+'][remark]"><!--<a href="javascript:;" class="btn btn-danger btn-flat" onclick="delbox(\'user_'+i+'\')">删除</a>--></div>';
			}
			$('#mingdan').append(html);	
			orderno();
		}
		
		
		//编号
		function orderno(){
			$('#mingdan').find('.title').each(function(index, element) {
				$(this).text(parseInt(index)+1);
			});
			$('#pretium').find('.title').each(function(index, element) {
				$(this).text(parseInt(index)+1);
			});	
		}
		
		function amount(obj){
			var aum  = parseInt($('#aum').val());
			var use  = parseInt($('#user_val').text());
			var nums = parseInt($('#fornum').val());
			var cost = parseInt($('#sale_cost').text());
			if(obj==1){
				var newaum = aum+1;
				$('#aum').val(newaum);	
				$('#user_val').text(use+1);	
				$('#cost').val(accMul(newaum,cost)+'.00');
				var html = '';
				for(j=0;j<nums;j++){
					var i = parseInt(Math.random()*1000+j);
					html += '<div class="userlist" id="user_'+i+'"><span class="title"></span><input type="text" placeholder="姓名" class="form-control mem-name" name="member['+i+'][name]"><div class="input-group"><span class="input-group-addon">男<input type="radio" name="member['+i+'][sex]" value="男"></span><span class="input-group-addon" style="border-left:0;">女<input type="radio" name="member['+i+'][sex]" value="女"></span></div><input type="text" placeholder="证件号码" class="form-control mem-number" name="member['+i+'][number]"><input type="text" placeholder="联系电话" class="form-control mem-tel" name="member['+i+'][mobile]"><input type="text" placeholder="家长姓名" class="form-control mem-name" name="member['+i+'][ecname]"><input type="text" placeholder="家长电话" class="form-control mem-tel" name="member['+i+'][ecmobile]"><input type="text" placeholder="备注" class="form-control" name="member['+i+'][remark]"><!--<a href="javascript:;" class="btn btn-danger btn-flat" onclick="delbox(\'user_'+i+'\')">删除</a>--></div>';
				}
				$('#mingdan').append(html);
				
			}else{
				if(aum>1){
					var newaum = aum-1;
					$('#aum').val(newaum);
					$('#user_val').text(use-1);	
					$('#cost').val(accMul(newaum,cost)+'.00');
					for(j=0;j<nums;j++){
						$('#mingdan').children(".userlist:last-child").remove();
					}
				}
			}
			orderno();
		}
		
		//移除
		function delbox(obj){
			$('#'+obj).remove();
			orderno();
		}
		
		$(document).ready(function(e) {
			adduser();
		});
		</script>