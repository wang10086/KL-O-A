<include file="Index:header2" />

            <aside class="right-side">
                <!-- Content Header (Page header) -->
                <section class="content-header">
                    <h1>项目预算详情</h1>
                    <ol class="breadcrumb">
                        <li><a href="{:U('Index/index')}"><i class="fa fa-home"></i> 首页</a></li>
                        <li><a href="{:U('Finance/budget')}"><i class="fa fa-gift"></i> 项目预算</a></li>
                    </ol>
                </section>

                <!-- Main content -->
                <section class="content">
                
                    <div class="row">
                         <!-- right column -->
                        <div class="col-md-12">
                             
                             <div class="box box-warning" style="margin-top:15px;">
                                <div class="box-header">
                                    <h3 class="box-title">
                                    <php> if($op['status']==1){ echo '<span class="green">项目已成团</span>&nbsp;&nbsp; <span style="font-weight:normal; color:#ff3300;">（团号：'.$op['group_id'].'）</span>';}elseif($op['status']==2){ echo '<span class="red">项目不成团</span>&nbsp;&nbsp; <span style="font-weight:normal">（原因：'.$op['nogroup'].'）</span>';}else{ echo ' <span style=" color:#999999;">该项目暂未成团</span>';} </php>
                                    </h3>
                                    <h3 class="box-title pull-right" style="font-weight:normal; color:#333333;"><span class="green">项目编号：{$op.op_id}</span> &nbsp;&nbsp;创建者：{$op.create_user_name}</h3>
                                </div><!-- /.box-header -->
                                <div class="box-body">
                                    <div class="content">
                                        <table width="100%" id="font-14" rules="none" border="0" cellpadding="0" cellspacing="0">
                                        	<tr>
                                            	<td colspan="3">项目名称：{$op.project}</td>
                                            </tr>
                                            <tr>
                                            	<td width="33.33%">项目类型：<?php echo $kinds[$op['kind']]; ?></td>
                                                <td width="33.33%">预计人数：{$op.number}人</td>
                                                <td width="33.33%">预计出团日期：{$op.departure}</td>
                                            </tr>
                                            <tr>
                                            	<td width="33.33%">预计行程天数：{$op.days}天</td>
                                                <td width="33.33%">目的地：{$op.destination}</td>
                                                <td width="33.33%">立项时间：{$op.op_create_date}</td>
                                            </tr>
                                        </table>
                                    </div>
                                    
                                </div><!-- /.box-body -->
                            </div><!-- /.box -->
                            
                        	
                            <?php if($op['audit_status']==1 && $costacc){ ?>
                            
                            <div class="box box-warning">
                                <div class="box-header">
                                    <h3 class="box-title">项目预算</h3>
                                </div><!-- /.box-header -->
                                <div class="box-body">
                                    <include file="budget_loan_info" />
                                </div>
                            </div>
                            <?php } ?> 
                            
                        </div><!--/.col (right) -->
                    </div>   <!-- /.row -->
                    
                </section><!-- /.content -->
                
            </aside><!-- /.right-side -->
			
  </div>
</div>

<include file="Index:footer2" />



<!--<script>
	$(document).ready(function(e) {
        cost_total();
    });
	//新成本核算项
	function add_costacc(){
		var i = parseInt($('#costacc_val').text())+1;

		var html = '<div class="userlist cost_expense" id="costacc_'+i+'"><span class="title"></span><input type="text" class="form-control" name="costacc['+i+'][title]"><input type="text"  class="form-control cost" name="costacc['+i+'][unitcost]"  value="0"><input type="text" class="form-control amount" name="costacc['+i+'][amount]" value="1"><input type="text" class="form-control totalval" name="costacc['+i+'][total]"  value="0"><select class="form-control"  name="costacc['+i+'][type]" ><option value="1">物资</option><option value="2">专家辅导员</option><option value="3">合格供方</option><option value="4">其他</option></select><input type="text" class="form-control longinput" name="costacc['+i+'][remark]"><a href="javascript:;" class="btn btn-danger btn-flat" onclick="delbox(\'costacc_'+i+'\')">删除</a></div>';
		$('#costacc').append(html);	
		$('#costacc_val').html(i);
		orderno();
		cost_total();
	}
	
	//编号
	function orderno(){
		$('#mingdan').find('.title').each(function(index, element) {
            $(this).text(parseInt(index)+1);
        });
		$('#pretium').find('.title').each(function(index, element) {
            $(this).text(parseInt(index)+1);
        });
		$('#costacc').find('.title').each(function(index, element) {
            $(this).text(parseInt(index)+1);
        });	
	}
	
	//移除
	function delbox(obj){
		$('#'+obj).remove();
		orderno();
		cost_total();
	}
	
	//更新成本核算
	function cost_total(){
        var costaccsum = get_costaccsum();

		$('#costaccsum').html('&yen; '+costaccsum.toFixed(2));	
		$('#costaccsumval').val(costaccsum.toFixed(2));	
		lilv();
	}

	function get_costaccsum() {
        var costaccsum = 0;
        $('.cost_expense').each(function(index, element) {
            $(this).find('.cost').blur(function(){
                var cost = $(this).val();
                var amount = $(this).parent().find('.amount').val();
                var ct = accMul(cost,amount);
                $(this).parent().find('.totalval').val(ct.toFixed(2));
                cost_total();
            });
            $(this).find('.amount').blur(function(){
                var amount = $(this).val();
                var cost = $(this).parent().find('.cost').val();
                var ct = accMul(cost,amount);
                $(this).parent().find('.totalval').val(ct.toFixed(2));
                cost_total()
            });
        });
        $('.totalval').each(function(index, element) {
            costaccsum += parseFloat($(this).val());
        });
        return costaccsum;
    }
	
	
	
	//更新利率
	function lilv(){
		var chengben = parseFloat($('#costaccsumval').val());   //成本
		var renshu   = parseInt($('#renshu').val());        //人数
		var shouru   = parseFloat($('#shouru').val());        //收入
		
		//毛利
		if(shouru && chengben){
			var maoli    = accSub(shouru,chengben).toFixed(2);
			$('#maoli').val(maoli);
		}

		//毛利率
		if(maoli && shouru){
			var maolilv    = accDiv(maoli,shouru).toFixed(4);
			$('#maolilv').val(accMul(maolilv,100)+'%');
		}
		
		//人均成本
		if(maoli && renshu){
			var renjunmaoli       = accDiv(maoli,renshu).toFixed(2);
			$('#renjunmaoli').val(renjunmaoli);
		}
		
	}
	
	
	
	function appcost(){
		if (confirm("您确认要提交审批吗？")){
			var renshu   = parseInt($('#renshu').val());        //人数
			var shouru   = parseInt($('#shouru').val());        //收入
            var maolilv  = toPoint($('#maolilv').val());        //毛利率
            var is_dijie = <?php /*echo $is_dijie; */?>;            //内部地接毛利率不能大于10%
			if(shouru && renshu){
                if (is_dijie != 0 && maolilv > 0.1){
                    art.dialog.alert('该团为内部地接团,毛利额不能超过10%');
                    return false;
                }else{
                    $('#appsubmint').submit();
                }
			}else{
				alert('请填写人数和预算收入');
				return false;
			}
		}else{
			return false;
		}
	}

	//百分数转化为小数
    function toPoint(percent){
        var str=percent.replace("%","");
            str= str/100;
        var res = str.toFixed(2);
        return res;
    }

</script>-->

     


