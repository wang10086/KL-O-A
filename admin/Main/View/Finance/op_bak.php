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
                        	 
                             <div class="btn-group" id="catfont">
                                <if condition="rolemenu(array('Op/plans_follow'))"><a href="{:U('Op/plans_follow',array('opid'=>$op['op_id']))}" class="btn btn-default">项目跟进</a></if>
                                <if condition="rolemenu(array('Finance/costacc'))"><a href="{:U('Finance/costacc',array('opid'=>$op['op_id']))}" class="btn btn-default">成本核算</a></if>
                                <if condition="rolemenu(array('Finance/op'))"><a href="{:U('Finance/op',array('opid'=>$op['op_id']))}" class="btn btn-info">项目预算</a></if>
                                <if condition="rolemenu(array('Op/app_materials'))"><a href="{:U('Op/app_materials',array('opid'=>$op['op_id']))}" class="btn btn-default">申请物资</a></if>
                                <if condition="rolemenu(array('Sale/goods'))"><a href="{:U('Sale/goods',array('opid'=>$op['op_id']))}" class="btn btn-default">项目销售</a></if>
                                <if condition="rolemenu(array('Finance/settlement'))"><a href="{:U('Finance/settlement',array('opid'=>$op['op_id']))}" class="btn btn-default">项目结算</a></if>
                            </div>
                            
                             
                             <div class="box box-warning" style="margin-top:15px;">
                                <div class="box-header">
                                    <h3 class="box-title">
                                    <php> if($op['status']==1){ echo '<span class="green">项目已成团</span>&nbsp;&nbsp; <span style="font-weight:normal; color:#ff3300;">（团号：'.$op['group_id'].'）</span>';}elseif($op['status']==2){ echo '<span class="red">项目不成团</span>&nbsp;&nbsp; <span style="font-weight:normal">（原因：'.$op['nogroup'].'）</span>';}else{ echo ' <span style=" color:#999999;">该项目暂未成团</span>';} </php>
                                    </h3>
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
                                    <h3 class="box-title">项目预算</h3>
                                    
                                </div><!-- /.box-header -->
                                <div class="box-body">
                                    <div class="content" id="supplierlist" style="display:block; margin-top:-10px;">
                                    <table class="table table-striped">
                                        <thead>
                                            <tr>
                                                <th width="">项目</th>
                                                <th width="15%">单价</th>
                                                <th width="15%">数量</th>
                                                <th width="15%">合计</th>
                                                <th width="30%">备注</th>
                                                
                                            </tr>
                                        </thead>
                                        <tbody>
                                        	<foreach name="costlist" item="v">
                                            <tr>
                                                <td>{$v.item}</td>
                                                <td>&yen; {$v.cost}</td>
                                                <td>{$v.amount}</td>
                                                <td>&yen; {$v.total}</td>
                                                <td>{$v.remark}</td>
                                            </tr>
                                            </foreach>
                                        </tbody>
                                    </table>
                                    <table style="border-top:1px solid #ddd;" width="100%" border="0" cellpadding="0" cellspacing="0" rules="none">
                                    	<tbody>
                                            <tr>
                                            	<td><?php if(!$budget){ ?><button class="btn btn-success btn-sm" onClick="add_pro_cost()">新增项目</button><?php } ?></td>
                                            	<td colspan="5" align="right" style="font-size:14px;">总计费用：<strong style=" color:#39b95a; font-size:18px;">&yen; {$chengben}</strong></td>
                                            </tr>
                                        </tbody>
                                    </table>
                                    </div>
                            	</div><!-- /.box-body -->
                            </div><!-- /.box -->     
                            
                            
                            
                            <div class="box box-warning">
                                <div class="box-header">
                                    <h3 class="box-title">预算申请</h3>
                                    
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
                                        <button type="submit" class="btn btn-info btn-lg" id="lrpd">确认预算并申请审批</button>
                                    </div>
                                    <div id="formsbtn" style="padding-bottom:50px;">请确认项目所需费用，这些费用将计为您项目的成本，请务必确认，不可反复提交申请</div>
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

	function add_pro_cost(){
		art.dialog.open('<?php echo U('Finance/addcost',array('opid'=>$op['op_id'])); ?>',{
			lock:true,
			title: '新增费用项',
			width:800,
			height:300,
			okValue: '提交',
			ok: function () {
				this.iframe.contentWindow.gosubmint();
				return false;
			},
			cancelValue:'取消',
			cancel: function () {
			}
		});	
	}
</script>

     


