<include file="Index:header2" />

            <aside class="right-side">
                <!-- Content Header (Page header) -->
                <section class="content-header">
                    <h1>项目结算</h1>
                    <ol class="breadcrumb">
                        <li><a href="{:U('Index/index')}"><i class="fa fa-home"></i> 首页</a></li>
                        <li><a href="{:U('Finance/settlementlist')}"><i class="fa fa-gift"></i> 项目结算</a></li>
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
                                            	<td width="33.33%">项目类型：{$kinds.name}</td>
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
                        	
                            <?php if($budget['audit_status']==1 || (!$budget && $settlement['audit_status']==1)){ ?>
                            <div class="box box-warning">
                                <div class="box-header">
                                    <h3 class="box-title">项目结算</h3>
                                </div><!-- /.box-header -->
                                <div class="box-body">
                                    <?php if(!in_array($audit['dst_status'],array(1,3)) || session('userid')==11){ ?>
                                        <include file="settlement_edit" />
                                    <?php }else{ ?>
                                        <include file="settlement_read" />
                                    <?php } ?>
                                </div>
                            </div>
                                     
                            <div id="formsbtn" style="padding-bottom:10px;">
                                <div class="content">
                                    <?php if(!in_array($audit['dst_status'],array(1,3)) || cookie('userid')==11){ ?>
                                        <form method="post" action="{:U('Finance/appsettlement')}" name="myform" id="appsubmint">
                                        <input type="hidden" name="dosubmit" value="1">
                                        <input type="hidden" name="opid" value="{$op.op_id}">
                                        <input type="hidden" name="noSupplierResNum" value="{$noSupplierResNum}">
                                        </form>
                                        
                                        <div id="formsbtn" style="padding-bottom:20px; margin-top:10px; color:#ff3300;">请确认各项结算费用是否正确，请务必确认，不可反复提交申请</div>
                                        <button type="button" onClick="$('#save_settlement').submit()" class="btn btn-info btn-lg" style=" padding-left:40px; padding-right:40px; margin-right:10px;">保存结算</button>
                                        <!--<button type="button" onClick="check_huikuan()" class="btn btn-success btn-lg" style=" padding-left:40px; padding-right:40px; margin-left:10px;">申请审批</button>-->
                                        <button type="button" onClick="check_huikuan()" class="btn btn-success btn-lg" style=" padding-left:40px; padding-right:40px; margin-left:10px;">申请审批</button>

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
    //const userkey = {$userkey};
	$(document).ready(function(e) {
        get_total_group_shouru(); //各拼团收入之和
        cost_total();
		orderno();

        $('.cost_expense').each(function(index, element) {
            var title           = $(this).find('.costTitle').val().trim();
            let costTypeStr     = "{$op_cost_type_str}";
            let costTypeArr     = new Array();
            costTypeArr         = costTypeStr.split(','); //分割字符串
            if (in_array(title,costTypeArr)){
                $(this).find('.supplier-name-class').attr({'readonly':true,'disabled':true});
            }
        })
    });
	//新成本核算项
	function add_costacc(){
		var i = parseInt($('#costacc_val').text())+1;

		var html = '<div class="userlist cost_expense" id="costacc_'+i+'">' +
            '<span class="title"></span>' +
            '<input type="text" class="form-control" name="costacc['+i+'][title]" list="'+i+'_cost_title" onblur="check_title('+i+',$(this).val())">' +
            '<datalist id="'+i+'_cost_title">'+
            '<foreach name="op_cost_type" item="ct">'+
            '<option value="{$ct}" label="" />'+
            '</foreach>'+
            '</datalist>'+
            '<input type="text"  class="form-control cost" name="costacc['+i+'][unitcost]"  value="0">' +
            '<input type="text" class="form-control amount" name="costacc['+i+'][amount]" value="1">' +
            '<input type="text" class="form-control totalval" name="costacc['+i+'][total]"  value="0">' +
            '<select class="form-control costaccType"  name="costacc['+i+'][type]" id="'+i+'_costacc_type" onchange="set_supplier_null('+i+')">' +
            '<foreach name="kind" key="k" item="v">'+
            '<option value="{$k}">{$v}</option>'+
            '</foreach>'+
            '</select>' +
            '<input type="hidden" class="form-control" name="costacc['+i+'][supplier_id]" id="'+i+'_supplierRes_id">'+
            '<input type="text" class="form-control" name="costacc['+i+'][supplier_name]" id="'+i+'_supplierRes_name" onfocus="get_supplierRes('+i+')">'+
            '<input type="text" class="form-control longinput" name="costacc['+i+'][remark]">' +
            '<a href="javascript:;" class="btn btn-danger btn-flat" onclick="delbox(\'costacc_'+i+'\')">删除</a>' +
            '</div>';
		$('#setcostacc').append(html);
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
		var costaccsum          = 0;
        var untraffic_sum       = 0; //不含大交通合计
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
            $(this).find('.costaccType').change(function () {
                cost_total();
            })

            var costacctype     = $(this).find('.costaccType').val();
            var untraffictotalval = costacctype == 12 ? 0 : $(this).find('.totalval').val();
            untraffic_sum       += parseFloat(untraffictotalval);
        });
        $('#untraffic_sum').val(untraffic_sum);
		$('.totalval').each(function(index, element) {
            costaccsum += parseFloat($(this).val());	
        });
		$('#costaccsum').html('&yen; '+costaccsum.toFixed(2));	
		$('#costaccsumval').val(costaccsum.toFixed(2));	
		lilv();
        untraffic_lilv();
	}

    function untraffic_lilv() {
        var chengben            = $('#costaccsumval').val(); //总成本
        var untraffic_chengben  = parseFloat($('#untraffic_sum').val());   //成本(不包含大交通)
        var traffic_cost        = accSub(chengben,untraffic_chengben).toFixed(2); //大交通费用
        var shouru              = parseFloat($('#shouru').val()); //收入
        var maoli               = $('#maoli').val(); //毛利

        //收入(不包含大交通)
        if(shouru && chengben){
            var untraffic_shouru= accSub(shouru,traffic_cost).toFixed(2);
            $('#untraffic_shouru').val(untraffic_shouru);
        }

        //毛利率(不包含大交通)
        if(maoli && untraffic_shouru){
            var untraffic_maolilv= accDiv(maoli,untraffic_shouru).toFixed(4);
            $('#untraffic_maolilv').val(accMul(untraffic_maolilv,100)+'%');
        }
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
            var zt_rate  = {$maoli_rate['zt_rate'] ? $maoli_rate['zt_rate'] : 0};
            var dj_rate  = {$maoli_rate['dj_rate'] ? $maoli_rate['dj_rate'] : 0};
            var one_maoli= accDiv(maoli,10); //毛利/10
            var zt_maoli = accMul(one_maoli,zt_rate).toFixed(2);
            var dj_maoli = accMul(one_maoli,dj_rate).toFixed(2);
            $('#zt_maoli').val(zt_maoli);
            $('#dj_maoli').val(dj_maoli);
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

	/*function appcost(){
		if (confirm("您确认要提交审批吗？审批后您将无法修改预算？")){
			var renshu   = parseInt($('#renshu').val());        //人数
			var shouru   = parseInt($('#shouru').val());        //收入
			if(shouru && renshu){
				$('#appsubmint').submit();
			}else{
				alert('请填写实际人数和实际收入');
				return false;
			}
		}else{
			return false;
		}
	}*/

	//检查是否全部回款
    function check_huikuan(){
        let add_group           = {$op.add_group};
        if (add_group == 1) { //拼团 检查结算收入数据和个拼团数据收入
            let total_shouru    = parseFloat($('#shouru').val());
            let group_shouru    = parseFloat($('#groupShouruSum').html());
            if (group_shouru != total_shouru){
                art_show_msg('请保证各拼团收入之和等于该团总收入',3);
                return false;
            }
        }
        let noSupplierResNum = {$noSupplierResNum};
        if(noSupplierResNum){ art_show_msg('您有结算项未填写合格供方',3); return false; }
        let yihuikuan  = <?php echo $yihuikuan?$yihuikuan:0; ?>;

        if (yihuikuan){
           checkGrossRate();
        }else{
            art_show_msg('该团未全部回款',5);
            return false;
        }
    }
    
    //检查最低毛利率
    function checkGrossRate() {
        let opid        = {$op['op_id']};
        let maolilv     = $('#maolilv').val();
        let untraffic_maolilv = $('#untraffic_maolilv').val(); //不含大交通毛利率
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

    //选择合格供方
    function get_supplierRes(num){
        let costType    = $('#'+num+'_costacc_type').val();
        if (!costType || costType==0){ art_show_msg('请先选择费用项类型'); return false; }
        art.dialog.open("/index.php?m=Main&c=Product&a=public_select_supplierRes&kind="+costType,{
            lock:true,
            title: '选择合格供方',
            width:1000,
            height:500,
            okVal: '提交',
            fixed: true,
            ok: function () {
                var origin     = artDialog.open.origin;
                var supplierRes= this.iframe.contentWindow.gosubmint();
                var res_id     = supplierRes.id;
                var res_name   = supplierRes.name;
                $('#'+num+'_supplierRes_id').val(res_id);
                $('#'+num+'_supplierRes_name').val(res_name);
            },
            cancelValue:'取消',
            cancel: function () {
            }
        });
    }

    //清空合格供方
    function set_supplier_null(num){
        $('#'+num+'_supplierRes_id').val('');
        $('#'+num+'_supplierRes_name').val('');
    }

    //检查费用项  判断是否需要选择合格供方
    function check_title(num,title){
        let costTypeStr     = "{$op_cost_type_str}";
        let costTypeArr     = new Array();
        let tit             = title.trim();
        costTypeArr         = costTypeStr.split(','); //分割字符串
        if (in_array(tit,costTypeArr)){
            $('#'+num+'_supplierRes_id').val('');
            $('#'+num+'_supplierRes_name').val('');
            $('#'+num+'_supplierRes_name').attr({'readonly':true,'disabled':true});
        }else{
            $('#'+num+'_supplierRes_name').attr({'readonly':false,'disabled':false});
        }
    }

    //各拼团方毛利
    function get_group_maoli(group_shouru,num) { //各自毛利 = (各自收入/总收入)*总毛利
        let total_shouru = $('#shouru').val() ? $('#shouru').val() : 0;
        let total_maoli  = $('#maoli').val() ? $('#maoli').val() : 0;
        let num1        = accDiv(group_shouru,total_shouru); //相除
        let group_maoli = accMul(num1,total_maoli).toFixed(2); //相乘

        $('#group_maoli_'+num).val(group_maoli);
        get_total_group_shouru();
    }

    //更新拼团各团总收入
    function get_total_group_shouru(){
        let op_total_shouru = $('#shouru').val() ? parseFloat($('#shouru').val()) : 0;
        let total   = 0;
        $('.group-content').each(function () {
            let groupShouru = $(this).find($('.group-shouru')).val() ? $(this).find($('.group-shouru')).val() : 0;
            total   += parseFloat(groupShouru);
        })

        if (total > op_total_shouru){ art_show_msg('各拼团方收入合计不应超过该团总收入',3); }
        $('#groupShouruSum').html(total);
    }
</script>

     


