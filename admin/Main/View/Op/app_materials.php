<include file="Index:header2" />

            <aside class="right-side">
                <!-- Content Header (Page header) -->
                <section class="content-header">
                    <h1>申请物资</h1>
                    <ol class="breadcrumb">
                        <li><a href="{:U('Index/index')}"><i class="fa fa-home"></i> 首页</a></li>
                        <li><a href="{:U('Op/app_materials')}"><i class="fa fa-gift"></i> 申请物资</a></li>
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
                                <if condition="rolemenu(array('Finance/op'))"><a href="{:U('Finance/op',array('opid'=>$op['op_id']))}" class="btn btn-default">项目预算</a></if>
                                <if condition="rolemenu(array('Op/app_materials'))"><a href="{:U('Op/app_materials',array('opid'=>$op['op_id']))}" class="btn btn-info">申请物资</a></if>
                                <!--
                                <if condition="rolemenu(array('Sale/goods'))"><a href="{:U('Sale/goods',array('opid'=>$op['op_id']))}" class="btn btn-default">项目销售</a></if>
                                -->
                                <if condition="rolemenu(array('Finance/settlement'))"><a href="{:U('Finance/settlement',array('opid'=>$op['op_id']))}" class="btn btn-default">项目结算</a></if>
                            </div>
                        	
                             <div class="box box-warning" style="margin-top:15px;">
                                <div class="box-header">
                                    <h3 class="box-title"><php> if($op['status']==1){ echo '<span class="green">项目已成团</span>&nbsp;&nbsp; <span style="font-weight:normal; color:#ff3300;">（团号：'.$op['group_id'].'）</span>';}elseif($op['status']==2){ echo '<span class="red">项目不成团</span>&nbsp;&nbsp; <span style="font-weight:normal">（原因：'.$op['nogroup'].'）</span>';}else{ echo ' <span style=" color:#999999;">该项目暂未成团</span>';} </php></h3>
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
                                                <td width="33.33%">出团日期：{$op.departure}</td>
                                            </tr>
                                            <tr>
                                            	<td width="33.33%">行程天数：{$op.days}天</td>
                                                <td width="33.33%">目的地：{$op.destination}</td>
                                                <td width="33.33%">立项时间：{$op.op_create_date}</td>
                                            </tr>
                                        </table>
                                        
                                        
                                    </div>
                                    
                                </div><!-- /.box-body -->
                            </div><!-- /.box -->
                            
                        	
                            <php> if($budget['audit_status']==1){ </php>
                            <div class="box box-warning">
                                <div class="box-header">
                                    <h3 class="box-title">物资清单</h3>
                                </div><!-- /.box-header -->
                                <div class="box-body">
                                   
                                    <div class="content"  style="display:block; margin-top:-5px;">
                                    <table class="table table-striped">
                                        <thead>
                                            <tr>
                                                <th >物资名称</th>
                                                <th align="center" style="text-align:center;">当前库存</th>
                                                <th align="center" style="text-align:center;">申请数量</th>
                                                <th align="center" style="text-align:center;">预算价</th>
                                                <th align="center" style="text-align:center;">最近入库价</th>
                                                <th align="center" style="text-align:center;">分摊期数</th>
                                                <th align="center" style="text-align:center;">单次使用费</th>
                                                <th align="center" style="text-align:center;">申请操作</th>
                                                <th align="center" style="text-align:center;">已采购</th>
                                                <th align="center" style="text-align:center;">已出库</th>
                                                <th align="center" style="text-align:center;">已归还</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                        	<foreach name="matelist" item="v">
                                            <tr>
                                                <td><a href="{:U('Material/stock',array('keywords'=>$v['material']))}" target="_blank">{$v.material}</a></td>
                                                <td align="center" style="font-size:14px;"><span >{$v.stock}</span></td>
                                                <td align="center" style="font-size:14px;">{$v.amount}</td>
                                                <td align="center" style="font-size:14px;">{$v.cost}</td>
                                                <td align="center" style="font-size:14px;">{$v.lastcost}</td>
                                                <td align="center" style="font-size:14px;">{$v.stages}</td>
                                                <td align="center" style="font-size:14px;"><?php echo sprintf("%.2f", $v['lastcost']/$v['stages']) ; ?></td>
                                                <td align="center" >{$v.status}</td>
                                                <td align="center"  style="font-size:14px;">{$v.purchasesum}</td>
                                                <td align="center"  style="font-size:14px;">{$v.outsum}</td>
                                                <td align="center"  style="font-size:14px;">{$v.returnsum}</td>
                                            </tr>
                                            </foreach>
                                        </tbody>
                                    </table>
                                    
                                    </div>
                                   
                                    
                                    
                              </div><!-- /.box-body -->
                            </div><!-- /.box -->     
                            
                            
                            <?php if($settlement['audit_status']!=1){ ?>
                            <div class="box box-warning">
                                <div class="box-header">
                                    <h3 class="box-title">申请物资</h3>
                                    
                                </div><!-- /.box-header -->
                                <div class="box-body">
                                    <div class="content" style="padding-bottom:50px;">
                                        <div id="formsbtn" style="line-height:2;"><span class="red">注意：</span>请确认所需物资，申请出库成功后将计入成本！项目结束后归还物资只计算单次使用费用，物资损坏或者丢失将承担物资采购成本。<br>库存不足物资在申请后将会自动生成采购申请，请关注采购进程，物资到库后请及时申请。</div>
                                        
                                        <div id="formsbtn" style="padding-bottom:10px; padding-top:20px;">
                                            <button class="btn btn-info btn-lg" onClick="appmateials();" style="padding-left:50px; padding-right:50px; margin-right:10px;">申请物资</button> <a class="btn btn-success btn-lg" href="{:U('Material/into',array('opid'=>$op['op_id']))}" style="padding-left:50px; padding-right:50px; margin-left:10px;">归还物资</a>
                                        </div>
                                        
                                    </div>
                                </div>
                            </div>
                            <?php } ?>
                            
                           <php>}else{</php>
                           <div class="box box-warning">
                                <div class="box-header">
                                    <h3 class="box-title">申请物资</h3>
                                </div><!-- /.box-header -->
                                <div class="box-body">
                                    <div class="content">
                                    预算尚未审批，或者项目尚未成团！
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

<script type="text/javascript">

artDialog.alert = function (content, status) {
	return artDialog({
		id: 'Alert',
		icon: status,
		width:300,
		height:120,
		fixed: true,
		lock: true,
		time: 1,
		content: content,
		ok: true
	});
};
	
function appmateials(){
	if (confirm("您确认提交申请吗？")){
		$.ajax({
        	type: "POST",
        	url: '<?php echo U('Op/out_materials'); ?>',
		 	dataType:'json', 
        	data: {opid:<?php echo $op['op_id']; ?>},
        	success:function(data){
            	if(parseInt(data)>0){
					art.dialog.alert('已提交申请！','success');
					setTimeout("history.go(0)",1000);
				}else{
					art.dialog.alert('未提交任何申请！','warning');	 
				}
	    	}
    	});	
	}else{
		return false;
	}
}
</script>


     


