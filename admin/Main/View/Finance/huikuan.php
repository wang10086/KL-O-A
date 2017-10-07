<include file="Index:header2" />

            <aside class="right-side">
                <!-- Content Header (Page header) -->
                <section class="content-header">
                    <h1>项目回款</h1>
                    <ol class="breadcrumb">
                        <li><a href="{:U('Index/index')}"><i class="fa fa-home"></i> 首页</a></li>
                    </ol>
                </section>

                <!-- Main content -->
                <section class="content">
                
                    <div class="row">
                         <!-- right column -->
                        <div class="col-md-12">
                        	 
                             <div class="btn-group no-print" id="catfont">
                                <if condition="rolemenu(array('Op/plans_follow'))"><a href="{:U('Op/plans_follow',array('opid'=>$op['op_id']))}" class="btn btn-default">项目跟进</a></if>
                                <if condition="rolemenu(array('Finance/costacc'))"><a href="{:U('Finance/costacc',array('opid'=>$op['op_id']))}" class="btn btn-default">成本核算</a></if>
                                <if condition="rolemenu(array('Finance/op'))"><a href="{:U('Finance/op',array('opid'=>$op['op_id']))}" class="btn btn-default">项目预算</a></if>
                                <if condition="rolemenu(array('Op/app_materials'))"><a href="{:U('Op/app_materials',array('opid'=>$op['op_id']))}" class="btn btn-default">申请物资</a></if>
                               
                                <!--
                                <if condition="rolemenu(array('Sale/goods'))"><a href="{:U('Sale/goods',array('opid'=>$op['op_id']))}" class="btn btn-default">项目销售</a></if>
                                -->
                                <if condition="rolemenu(array('Finance/settlement'))"><a href="{:U('Finance/settlement',array('opid'=>$op['op_id']))}" class="btn btn-default">项目结算</a></if>
                                <if condition="rolemenu(array('Finance/huikuan'))"><a href="{:U('Finance/huikuan',array('opid'=>$op['op_id']))}" class="btn btn-info">项目回款</a></if>
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
                                            <?php if($settlement['audit_status']==1){ ?>
                                            <tr>
                                                <td width="33.33%">实际人数：{$settlement.renshu}</td>
                                                <td width="33.33%">实际收入：{$settlement.shouru}</td>
                                                <td width="33.33%">合同签订：<?php if($settlement['hetong']){ echo '已签订';}else{ echo '未签订';} ?></td>
                                            </tr>
                                            <tr>
                                                <td width="33.33%">毛利：{$settlement.maoli}</td>
                                                <td width="33.33%">毛利率：{$settlement.maolilv}</td>
                                                <td width="33.33%">人均毛利：{$settlement.renjunmaoli}</td>
                                            </tr>
                                            <tr>
                                                <td width="33.33%">已回款金额：{$settlement.huikuan}</td>
                                            </tr>
                                            <?php } ?>
                                        </table>
                                    </div>
                                    
                                </div><!-- /.box-body -->
                            </div><!-- /.box -->
                            
                        	
                            <?php if($settlement['audit_status']==1){ ?>
                            
                            <div class="box box-warning">
                                <div class="box-header">
                                    <h3 class="box-title">项目回款</h3>
                                </div><!-- /.box-header -->
                                <div class="box-body">
                                    <form method="post" action="{:U('Finance/save_huikuan')}" name="myform" id="save_huikuan">
                                    <input type="hidden" name="dosubmint" value="1">
                                    <input type="hidden" name="info[op_id]" value="{$op.op_id}">
                                    <input type="hidden" name="info[name]" value="{$op.project}">
                                    <input type="hidden" name="settlement" value="{$settlement.id}" />
                                    <input type="hidden" name="referer" value="<?php echo $_SERVER['HTTP_REFERER']; ?>" />
                                    <div class="content" >
                                        <div style="width:100%; float:left;">
                                            <div class="form-group col-md-4">
                                                <label>本次回款金额：</label>
                                                <input type="text" name="info[huikuan]" id="renshu" class="form-control" value=""/>
                                            </div>
                                            
                                            <div class="form-group col-md-4">
                                                <label>收款方式：</label>
                                                <select class="form-control" name="info[type]">
                                                	<option value="">选择</option>
                                                    <option value="转账">转账</option>
                                                    <option value="支票">支票</option>
                                                    <option value="现金">现金</option>
                                                    <option value="其他">其他</option>
                                                </select>
                                            </div>
                                            
                                            <div class="form-group col-md-4">
                                                <label>备注：</label>
                                                <input type="text" name="info[remark]" id="remark" class="form-control" value=""/>
                                            </div>
                                            
                                            <div class="form-group col-md-12"  style="margin-top:50px; padding-bottom:20px; text-align:center;">
                                            	<button class="btn btn-success btn-lg">保存并提交审核</button>
                                            </div>
                                        </div>
                                        
                                    </div>
                                    
                                    </form>  
                                </div>
                            </div>
                            
                            
                            
                            
                             <div class="box box-warning">
                                <div class="box-header">
                                    <h3 class="box-title">回款记录</h3>
                                </div><!-- /.box-header -->
                                <div class="box-body">
                                    <div class="content" style="padding-top:0px;">
                                         <table class="table table-striped" id="font-14-p">
                                            <thead>
                                                <tr>
                                                    <th width="120">回款金额</th>
                                                    <th width="120">回款方式</th>
                                                    <th width="180">申请时间</th>
                                                    <th>回款备注</th>
                                                    
                                                    <th width="120">审批状态</th>
                                                    <th width="120">审批者</th>
                                                    <th width="">审批说明</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <foreach name="huikuan" key="k" item="v">
                                                    <tr class="userlist">
                                                        <td>&yen; {$v.huikuan}</td>
                                                        <td>{$v.type}</td>
                                                        <td>{$v.create_time|date='Y-m-d H:i:s',###}</td>
                                                        <td>{$v.remark}</td>
                                                        
                                                        <td>{$v.showstatus}</td>
                                                        <td>{$v.show_user}</td>
                                                        <td>{$v.show_reason}</td>
                                                    </tr> 
                                                </foreach>
                                            </tbody>
                                        </table>
                                        
                                    </div>
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
	
</script>

     


