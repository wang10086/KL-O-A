<include file="Index:header2" />

            <aside class="right-side">
                <!-- Content Header (Page header) -->
                <section class="content-header print">
                    <h1>成本核算</h1>
                    <ol class="breadcrumb">
                        <li><a href="{:U('Index/index')}"><i class="fa fa-home"></i> 首页</a></li>
                        <li><a href="{:U('Finance/costacclist')}" ><i class="fa fa-gift"></i> 成本核算</a></li>
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

                                        <include file="Finance:op_pro" />

                                    </div>

                                </div><!-- /.box-body -->
                            </div><!-- /.box -->

                            <?php if(!$budget && $costacc_res['status'] != 1){ ?>
                            	<include file="costacc_edit" />
                            <?php }else{ ?>
                            	<include file="costacc_read" />
                            <?php } ?>

                            <div class="box box-warning">
                                <div class="box-header">
                                    <h3 class="box-title">项目报价</h3>
                                </div><!-- /.box-header -->
                                <div class="box-body">
                                    <div class="content">
                                        <?php if ($costacc_res['status'] != 1){ ?>
                                            <div class="form-group col-md-12">请先完成成本核算！</div>
                                        <?php }else{ ?>
                                            <?php if (!$budget && in_array(cookie('userid'),array($manage_id,1,11))){ ?>
                                                <include file="baojia_edit" />
                                            <?php }else{ ?>
                                                <include file="baojia_read" />
                                            <?php } ?>
                                        <?php } ?>

                                    </div>
                                </div>
                            </div>


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
	//新成本核算项
	function add_costacc(){
		var i = parseInt($('#costacc_val').text())+1;

		var html = '<div class="userlist cost_expense" id="costacc_'+i+'">';
			html += '<span class="title"></span>';
			html += '<input type="text" class="form-control" name="costacc['+i+'][title]">';
			html += '<input type="text"  class="form-control cost" name="costacc['+i+'][unitcost]"  value="0">';
			html += '<input type="text" class="form-control amount" name="costacc['+i+'][amount]" value="1">';
			html += '<input type="text" class="form-control totalval" name="costacc['+i+'][total]"  value="0">';
			html += '<select class="form-control"  name="costacc['+i+'][type]"  onChange="bijia(\'cc_bijia_'+i+'\',this)">';
			<?php foreach($kind as $k=>$v){ ?>
			html += '<option value="{$k}">{$v}</option>';
			<?php } ?>
			html += '</select>';
			html += '<input type="text" class="form-control longinput" name="costacc['+i+'][remark]">';
			html += '<a href="javascript:;" class="btn btn-danger btn-flat" onclick="delbox(\'costacc_'+i+'\')">删除</a>';
			html += '<a href="javascript:;" class="btn btn-success btn-flat" id="cc_bijia_'+i+'" style="display:none;">比价</a>';
			html += '</div>';
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
		$('#costaccsum').html('&yen; '+costaccsum.toFixed(2));
		let final_cost      = costaccsum.toFixed(2)
        let gross           = "{$gross}";
		let min_a           = accAdd(1,gross); //加 "建议最低报价”由系统生成，即=成本价格×（1+同类产品平均毛利率）；“建议最高报价”由系统生成，即=成本价格×（1+1.5×同类产品平均毛利率）
		let min_cost        = accMul(final_cost,min_a); //乘
        let max_a           = accMul(1.5,gross); //乘
        let max_b           = accAdd(1,max_a); //加
        let max_cost        = accMul(final_cost,max_b); //
		$('#costaccsumval').val(final_cost);
        $('input[name="info[costacc_min_price]"]').val(min_cost);
        $('input[name="info[costacc_max_price]"]').val(max_cost)
		console.log(min_a);
		console.log(min_cost);
	}


	function bijia(obj,tt){
		var z = $(tt).val();
		if(z == 7 || z == 8 || z == 9){

			var url = "{:U('Op/relpricelist')}"+"&opid={$op.op_id}&type="+z;
			$('#'+obj).attr('href',url).attr('target','_blank');
			$('#'+obj).show();
		}else{
			$('#'+obj).hide();
		}
	}

	/*var is_dijie = <?php /*echo $is_dijie; */?>;
    function beforeSubmit(from) {
        var result='';
        var dijie = '[13]'; /!*13内部地接*!/
        $('.dijie').each(function () {
            result = result + '['+$(this).val()+'],';
        })

        if (is_dijie==1 && result.indexOf(dijie)==-1){
            art.dialog.alert('本团是内部地接团，请填写内部地接费用!','warning');
            return false;
        }else{
            from.submit();
        }
    }*/

	function submintform() {
        let costacc_min_price   = parseInt($('input[name="info[costacc_min_price]"]').val());
        let costacc_max_price   = parseInt($('input[name="info[costacc_max_price]"]').val());
        if (!costacc_min_price || !costacc_max_price){
            art.dialog.alert('报价信息填写有误','warning');
            return false;
        }else{
            $('#myform').submit();
        }
	}
	

</script>




