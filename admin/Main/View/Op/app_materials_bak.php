<include file="Index:header2" />

            <aside class="right-side">
                <!-- Content Header (Page header) -->
                <section class="content-header">
                    <h1>申请物资</h1>
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
                        
                        	 <div class="btn-group" id="catfont">
                                <if condition="rolemenu(array('Op/plans_follow'))"><a href="{:U('Op/plans_follow',array('opid'=>$op['op_id']))}" class="btn btn-default">项目跟进</a></if>
                                <if condition="rolemenu(array('Finance/op'))"><a href="{:U('Finance/op',array('opid'=>$op['op_id']))}" class="btn btn-default">项目预算</a></if>
                                <if condition="rolemenu(array('Op/app_materials'))"><a href="{:U('Op/app_materials',array('opid'=>$op['op_id']))}" class="btn btn-info">申请物资</a></if>
                                <if condition="rolemenu(array('Sale/goods'))"><a href="{:U('Sale/goods',array('opid'=>$op['op_id']))}" class="btn btn-default">项目销售</a></if>
                             </div>
                        	
                             <div class="box box-warning" style="margin-top:15px;">
                                <div class="box-header">
                                    <h3 class="box-title"><php> if($op['status']==1){ echo '<span class="green">项目已成团</span>&nbsp;&nbsp; <span style="font-weight:normal; color:#ff3300;">（团号：'.$op['group_id'].'）</span>';}elseif($op['status']==2){ echo '<span class="red">项目不成团</span>&nbsp;&nbsp; <span style="font-weight:normal">（原因：'.$op['nogroup'].'）</span>';}else{ echo ' <span style=" color:#999999;">该项目暂未成团</span>';} </php></h3>
                                    <h3 class="box-title pull-right" style="font-weight:normal; color:#333333;"><span class="green">项目编号：{$op.op_id}</span> &nbsp;&nbsp;创建者：{$op.create_user_name}</h3>
                                </div><!-- /.box-header -->
                                <div class="box-body">
                                    <div class="content">
                                        
                                       
                                        <div class="form-group col-md-12" style="margin-top:20px;">
                                            <label>项目名称：</label>{$op.project}
                                        </div>
                                        
                                        <div class="form-group col-md-4">
                                            <label>项目类型：</label><?php echo $kinds[$op['kind']]; ?>
                                        </div>
                                        
                                        <div class="form-group col-md-4">
                                            <label>预计人数：</label>{$op.number}人
                                        </div>
                                        
                                        <div class="form-group col-md-4">
                                            <label>出团日期：</label>{$op.departure}
                                        </div>
                                        
                                        <div class="form-group col-md-4">
                                            <label>行程天数：</label>{$op.days}天
                                        </div>
                                        
                                        <div class="form-group col-md-4">
                                            <label>目的地：</label>{$op.destination}
                                        </div>
                                        
                                        <div class="form-group col-md-4">
                                            <label>立项时间：</label>{$op.op_create_date}
                                        </div>
                                        
                                        
                                    </div>
                                    
                                </div><!-- /.box-body -->
                            </div><!-- /.box -->
                            
                        	
                            <php> if($op['audit_status']==1){ </php>
                            <div class="box box-warning">
                                <div class="box-header">
                                    <h3 class="box-title">物资清单</h3>
                                    
                                </div><!-- /.box-header -->
                                <div class="box-body">
                                   
                                    <div class="content" id="opmaterial" style="display:block; margin-top:-10px;">
                                    <table class="table table-striped">
                                        <thead>
                                            <tr>
                                                <th width="">物资名称</th>
                                                <th width="80">单价</th>
                                                <th width="20">&nbsp;</th>
                                                <th width="80">数量</th>
                                                <th width="100">合计</th>
                                                <th width="160">备注</th>
                                                <th width="80">删除</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                        	<foreach name="matelist" item="v">
                                            <tr class="expense" id="wuzi_id_{$v.id}">
                                                <td>
                                                <input type="hidden" name="cost[60002{$v.id}][item]" value="物资费">
                                                <input type="hidden" name="cost[60002{$v.id}][cost_type]" value="4">
                                                <input type="hidden" name="cost[60002{$v.id}][relevant_id]" value="{$v.material_id}">
                                                <input type="hidden" name="cost[60002{$v.id}][remark]" value="{$v.material}">
                                                <input type="hidden" name="resid[60002{$v.id}][id]" value="{$v.id}">
                                                <input type="hidden" name="wuzi[60002{$v.id}][material]" value="{$v.material}">
                                                <input type="hidden" name="wuzi[60002{$v.id}][material_id]" value="{$v.material_id}">
                                                <a href="{:U('Material/stock',array('keywords'=>$v['material']))}">{$v.material}</a>
                                                </td>
                                                <td><input type="text" name="cost[60002{$v.id}][cost]" value="{$v.cost}" placeholder="价格" class="form-control min_input cost"></td>
                                                <td><span>X</span></td>
                                                <td><input type="text" name="cost[60002{$v.id}][amount]" value="{$v.amount}" placeholder="数量" class="form-control min_input amount"></td>
                                                <td class="total">¥<?php echo $v['cost']*$v['amount']; ?></td>
                                                <td><input type="text" name="wuzi[60002{$v.id}][remarks]" value="{$v.remarks}" class="form-control"></td><td><a href="javascript:;" class="btn btn-danger btn-flat" onclick="delbox('wuzi_id_{$v.id}')">删除</a></td>
                                            </tr>
                                            
                                            </foreach>
                                        	
                                        </tbody>
                                    </table>
                                    <?php if(!$budget){ ?><button class="btn btn-success btn-sm" onClick="selectmaterial()" style="margin-top:15px;">新增物资</button><?php } ?>
                                    </div>
                                   
                                    
                                    
                              </div><!-- /.box-body -->
                            </div><!-- /.box -->     
                            
                            
                            
                            <div class="box box-warning">
                                <div class="box-header">
                                    <h3 class="box-title">申请物资</h3>
                                    
                                </div><!-- /.box-header -->
                                <div class="box-body">
                                    <div class="content">
                                    <?php if($budget){ ?>
                                    <div class="form-group col-md-4 viwe" style="margin-top:10px;">
                                        <p>审批状态：{$op.showstatus}</p>
                                    </div>
                                    <div class="form-group col-md-4 viwe" style="margin-top:10px;">
                                        <p>审批人：{$op.show_user}</p>
                                    </div>
                                    <div class="form-group col-md-4 viwe" style="margin-top:10px;">
                                        <p>审批时间：{$op.show_time}</p>
                                    </div>
                                    
                                    <?php if($op['show_reason']){ ?>
                                    <div class="form-group col-md-4 viwe" style="padding-bottom:20px;">
                                        <p>审批说明：{$op.show_reason}</p>
                                    </div>
                                    <?php } ?>
                                    <?php }else{ ?>
                                    <form method="post" action="{:U('Finance/appcost')}" name="myform">
                                    <input type="hidden" name="dosubmit" value="1">
                                    <input type="hidden" name="info[op_id]" value="{$op.op_id}">
                                    <input type="hidden" name="info[name]" value="{$op.project}">
                                    <input type="hidden" name="info[budget]" value="{$chengben}">
                                    <div id="formsbtn" style="padding-bottom:10px;">
                                        <button type="submit" class="btn btn-info btn-lg" id="lrpd">立即申请所需物资</button>
                                    </div>
                                    <div id="formsbtn" style="padding-bottom:50px;">请确认项目所需物资，这些物资将计为您项目的成本，请务必确认，不可反复提交申请</div>
                                    </form>
                                    <?php } ?>
                                    </div>
                                </div>
                            </div>
                            
                            
                           <php>}</php>
                            
                        </div><!--/.col (right) -->
                    </div>   <!-- /.row -->
                    
                </section><!-- /.content -->
                
            </aside><!-- /.right-side -->
			
  </div>
</div>

<include file="Index:footer2" />

<script>

	//物资申请
	function selectmaterial() {
		art.dialog.open('<?php echo U('Op/select_material'); ?>',{
			lock:true,
			title: '申请物资',
			width:1000,
			height:500,
			okValue: '提交',
			fixed: true,
			ok: function () {
				var origin = artDialog.open.origin;
				var wuzi = this.iframe.contentWindow.gosubmint();	
				var i = parseInt($('#wuzi_val').text())+1;
				
				var cost = '<input type="hidden" name="cost['+(4000+parseInt(i))+'][item]" value="物资费"><input type="hidden" name="cost['+(4000+parseInt(i))+'][cost_type]" value="4"><input type="hidden" name="cost['+(4000+parseInt(i))+'][relevant_id]" value="'+wuzi[0].id+'"><input type="hidden" name="cost['+(4000+parseInt(i))+'][remark]" value="'+wuzi[0].materialname+'">';
				var wuzi_html = '<tr class="expense" id="wuzi_'+i+'"><td>'+cost+'<input type="hidden" name="wuzi['+i+'][material]" value="'+wuzi[0].materialname+'"><input type="hidden" name="wuzi['+i+'][material_id]" value="'+wuzi[0].id+'"><a href="index.php?m=Main&c=Material&a=stock&keywords='+wuzi[0].materialname+'">'+wuzi[0].materialname+'</a></td><td><input type="text" name="cost['+(4000+parseInt(i))+'][cost]" value="'+wuzi[0].unit_price+'" placeholder="价格" class="form-control min_input cost" /></td><td><span>X</span></td><td><input type="text" name="cost['+(4000+parseInt(i))+'][amount]" value="'+wuzi[0].amount+'" placeholder="数量" class="form-control min_input amount" /></td><td class="total">&yen;'+parseInt(wuzi[0].unit_price)*parseInt(wuzi[0].amount)+'</td><td><input type="text" name="wuzi['+i+'][remarks]" value="'+wuzi[0].remarks+'" class="form-control" /></td><td><a href="javascript:;" class="btn btn-danger btn-flat" onclick="delbox(\'wuzi_'+i+'\')">删除</a></td></tr>';
				
				$('#opmaterial').find('tbody').append(wuzi_html);	
				total();
			},
			cancelValue:'取消',
			cancel: function () {
			}
		});	
	}
	
	//更新价格与数量
	function total(){
		$('.expense').each(function(index, element) {
            $(this).find('.cost').blur(function(){
				var cost = $(this).val();
				var amount = $(this).parent().parent().find('.amount').val();
				$(this).parent().parent().find('.total').html('&yen;'+accMul(cost,amount));	
				$(this).parent().parent().find('.cost_cost').val(cost);	
				$(this).parent().parent().find('.totalval').val(accMul(cost,amount));	
			});
			 $(this).find('.amount').blur(function(){
				var amount = $(this).val();
				var cost = $(this).parent().parent().find('.cost').val();
				$(this).parent().parent().find('.total').html('&yen;'+accMul(cost,amount));	
				$(this).parent().parent().find('.cost_amount').val(amount);	
				$(this).parent().parent().find('.totalval').val(accMul(cost,amount));	
			});
        });		
	}
	
</script>

     


