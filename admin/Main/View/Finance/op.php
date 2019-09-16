<include file="Index:header2" />

            <aside class="right-side">
                <!-- Content Header (Page header) -->
                <section class="content-header">
                    <h1>项目预算</h1>
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

                            <include file="Op:op_navigate" />
                             
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
                                    <?php if($is_zutuan == 1){ ?>
                                        <?php if ($dijie_shouru && !in_array($audit['dst_status'],array(1,3))  && (!$jd || in_array(cookie('userid'),array($jd,1,11)))){ ?>
                                            <include file="op_edit" />
                                        <?php }else{ ?>
                                            <?php if ($dijie_shouru && in_array(cookie('userid'),array(1,11))){ ?>
                                                <include file="op_edit" />
                                            <?php }else{ ?>
                                                <include file="op_read" />
                                            <?php } ?>
                                        <?php } ?>
                                    <?php }else{ ?>
                                        <?php if(!in_array($audit['dst_status'],array(1,3)) && (!$jd || in_array(cookie('userid'),array($jd,1,11)))){ ?>
                                            <include file="op_edit" />
                                        <?php }else{ ?>
                                            <?php if (in_array(cookie('userid'),array(1,11))){ ?>
                                                <include file="op_edit" />
                                            <?php }else{ ?>
                                                <include file="op_read" />
                                            <?php } ?>
                                    <?php } } ?>
                                </div>
                            </div>
                            
                                            
                            <div id="formsbtn" style="padding-bottom:10px;">
                                <div class="content">
                                    <?php if(!in_array($audit['dst_status'],array(1,3)) || in_array(cookie('userid'),array(1,11))){ ?>
                                        <form method="post" action="{:U('Finance/appcost')}" name="myform" id="appsubmint">
                                        <input type="hidden" name="dosubmit" value="1">
                                        <input type="hidden" name="opid" value="{$op.op_id}">
                                        </form>
                                        
                                        <div id="formsbtn" style="padding-bottom:20px; margin-top:10px;color:#ff3300;">当审核未被通过时，请调整预算后可能会被通过哦</div>
                                        
                                        
                                        <!--<button type="button" onClick="$('#save_appcost').submit()" class="btn btn-info btn-lg" style=" padding-left:40px; padding-right:40px; margin-right:10px;">保存预算</button>-->
                                        <button type="button" onClick="check_appcost()" class="btn btn-info btn-lg" style=" padding-left:40px; padding-right:40px; margin-right:10px;">保存预算</button>
                                        <button type="button" onClick="appcost()" class="btn btn-success btn-lg" style=" padding-left:40px; padding-right:40px; margin-left:10px;">申请审批</button>
                                
                                        
                                    <?php } ?>
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

<script>
	$(document).ready(function(e) {
        cost_total();
    });
    /*$('.costaccType').change(function () {
        console.log('aa');
    })*/
	//新成本核算项
	function add_costacc(){
		var i = parseInt($('#costacc_val').text())+1;

		var html = '<div class="userlist cost_expense" id="costacc_'+i+'">' +
            '<span class="title"></span>' +
            '<input type="text" class="form-control" name="costacc['+i+'][title]">' +
            '<input type="text"  class="form-control cost" name="costacc['+i+'][unitcost]"  value="0">' +
            '<input type="text" class="form-control amount" name="costacc['+i+'][amount]" value="1">' +
            '<input type="text" class="form-control totalval" name="costacc['+i+'][total]"  value="0">' +
            '<select class="form-control costaccType"  name="costacc['+i+'][type]" >' +
            '<foreach name="kind" key="k" item="v">'+
            '<option value="{$k}">{$v}</option>'+
            '</foreach>'+
            '</select><input type="text" class="form-control longinput" name="costacc['+i+'][remark]">' +
            '<a href="javascript:;" class="btn btn-danger btn-flat" onclick="delbox(\'costacc_'+i+'\')">删除</a>' +
            '</div>';
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
        $('#payment').find('.title').each(function(index, element) {
            $(this).text(parseInt(index)+1);
        });
        $('#payment').find('.payno').each(function(index, element) {
            $(this).val(parseInt(index)+1);
        });
	}
	
	//移除
	function delbox(obj){
		$('#'+obj).remove();
		orderno();
		cost_total();
	}

    //新增回款计划
    function add_payment(){
        var i = parseInt($('#payment_val').text())+1;

        var html = '<div class="userlist" id="pretium_'+i+'">';
        html += '<span class="title"></span>';
        html += '<input type="hidden" name="payment['+i+'][no]" class="payno" value="">';
        html += '<div class="f_15"><input type="text" class="form-control money_back_amount" name="payment['+i+'][amount]" onblur="check_ratio('+i+',$(this).val())" value=""></div>';
        html += '<div class="f_15"><input type="text" class="form-control" name="payment['+i+'][ratio]" value=""></div>';
        html += '<div class="f_15"><input type="text" class="form-control inputdate"  name="payment['+i+'][return_time]" value=""></div>';
        html += '<div class="f_15"><select class="form-control" name="payment['+i+'][company]"><foreach name="company" key="k" item="v"><option value="{$k}">{$v}</option></foreach></select></div>';
        html += '<div class="f_15"><select class="form-control" name="payment['+i+'][type]"><foreach name="type" key="k" item="v"><option value="{$k}">{$v}</option></foreach></select></div>';
        html += '<div class="f_25"><input type="text" class="form-control" name="payment['+i+'][remarks]" value=""></div>';
        html += '<a href="javascript:;" class="btn btn-danger btn-flat" onclick="delbox(\'pretium_'+i+'\')">删除</a>';
        html += '</div>';
        $('#payment').append(html);
        $('#payment_val').html(i);
        orderno();
        relaydate();
    }

    //更新成本核算
    function cost_total(){
        var costaccsum      = get_costaccsum();

        $('#costaccsum').html('&yen; '+costaccsum.toFixed(2));
        $('#costaccsumval').val(costaccsum.toFixed(2));
        lilv();
        untraffic_lilv();
    }

    function untraffic_lilv() {
	    var chengben            = $('#costaccsumval').val(); //总成本
        var untraffic_chengben  = parseFloat($('#untraffic_sum').val());   //成本(不包含大交通)
        var traffic_cost        = accSub(chengben,untraffic_chengben).toFixed(2); //大交通费用
        var shouru              = parseFloat($('#shouru').val());   //收入
        var maoli               = $('#maoli').val(); //毛利

        //收入(不包含大交通)
        if(shouru && chengben){
            //var maoli    = accSub(shouru,chengben).toFixed(2);
            //$('#untraffic_maoli').val(maoli);
            var untraffic_shouru= accSub(shouru,traffic_cost).toFixed(2);
            $('#untraffic_shouru').val(untraffic_shouru);
        }

        //毛利率(不包含大交通)
        if(maoli && untraffic_shouru){
            var untraffic_maolilv= accDiv(maoli,untraffic_shouru).toFixed(4);
            $('#untraffic_maolilv').val(accMul(untraffic_maolilv,100)+'%');
        }
    }

    function get_costaccsum() {
        var costaccsum          = 0;
        var untraffic_sum       = 0; //不含大交通合计
        $('.cost_expense').each(function(index, element) {
            $(this).find('.cost').blur(function(){
                var cost        = $(this).val();
                var amount      = $(this).parent().find('.amount').val();
                var ct          = accMul(cost,amount);
                $(this).parent().find('.totalval').val(ct.toFixed(2));
                cost_total();
            });
            $(this).find('.amount').blur(function(){
                var amount      = $(this).val();
                var cost        = $(this).parent().find('.cost').val();
                var ct          = accMul(cost,amount);
                $(this).parent().find('.totalval').val(ct.toFixed(2));
                cost_total();
            });
            $(this).find('.costaccType').change(function () {
                cost_total();
            })

            var costacctype     = $(this).find('.costaccType').val();
            var untraffictotalval = costacctype == 12 ? 0 : $(this).find('.totalval').val();
            untraffic_sum       += parseFloat(untraffictotalval);
        });
        //console.log(untraffic_sum);
        $('#untraffic_sum').val(untraffic_sum.toFixed(2));
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
        var should_back_money = "{$budget.should_back_money}"?"{$budget.should_back_money}":shouru;
        $('#sum_money_return').html(should_back_money);

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
            var is_dijie = <?php echo $is_dijie; ?>;            //内部地接毛利率不能大于10%
            var userid   = <?php echo session('userid'); ?>;
			if(shouru && renshu){
                if (is_dijie != 0 && maolilv > 0.1){
                    if (userid == 11){
                        //$('#appsubmint').submit();
                        checkGrossRate();
                    }else{
                        art.dialog.alert('该团为内部地接团,毛利额不能超过10%');
                        return false;
                    }
                }else{
                    //$('#appsubmint').submit();
                    checkGrossRate();
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

    //自动计算回款比例
    function check_ratio(num,obj) {
        var sum         = $('#sum_money_return').html(); //预算收入
        if (sum == 0){
            art_show_msg('预算收入有误,请重新输入');
            return false;
        }else{
            var money_back  = obj;
            var ratio       = accDiv(money_back,sum); //相除
            var ratio       = ratio.toFixed(4); //保留4位小数
            var average     = accMul(ratio,'100')+'%'; //相加
            $('input[name="payment['+num+'][ratio]"]').val(average);
        }

    }
    
    function check_appcost() {
        var dijie           = {$is_dijie};
        var shouru          = $('#shouru').val().trim();
        if (!shouru || shouru==0){ art_show_msg('收入不能为空',3); return false; }
        var money_return_plan = 0;
        $('#payment').find('.money_back_amount').each(function () {
            money_return_plan += parseInt($(this).val());
        })
        if (money_return_plan != shouru && dijie == 0){ art_show_msg('请确保回款总金额和收入一致',3); return false; }
        $('#save_appcost').submit();
    }

    //检查最低毛利率
    function checkGrossRate() {
        var opid        = {$op['op_id']};
        var maolilv     = $('#maolilv').val();
        var untraffic_maolilv = $('#untraffic_maolilv').val(); //不含大交通毛利率
        if (!maolilv) { art_show_msg('毛利率不能为空',3); return false; }

        $.ajax({
            type : 'POST',
            url  : "{:U('Ajax/checkGrossRate')}",
            data : {opid:opid, maolilv:untraffic_maolilv},
            success : function(data){
                if (data.stu == 1){
                    $('#appsubmint').submit();
                }else if(data.stu == 2){
                    if (confirm(data.msg)){ //未达到规定毛利率
                        $('#appsubmint').submit();
                    }else{
                        return false;
                    }
                }
            },
            error : function(){
                alert('msg error');
            }
        })
    }

</script>

     


