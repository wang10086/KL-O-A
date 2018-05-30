<include file="Index:header2" />

            <aside class="right-side">
                <!-- Content Header (Page header) -->
                <section class="content-header">
                    <h1>项目出团确认</h1>
                    <ol class="breadcrumb">
                        <li><a href="{:U('Index/index')}"><i class="fa fa-home"></i> 首页</a></li>
                        <li><a href="{:U('Op/confirm')}"><i class="fa fa-gift"></i> 项目结算</a></li>
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
                                <if condition="rolemenu(array('Op/confirm'))"><a href="{:U('Op/confirm',array('opid'=>$op['op_id']))}" class="btn btn-info">成团确认</a></if>
                                <if condition="rolemenu(array('Finance/op'))"><a href="{:U('Finance/op',array('opid'=>$op['op_id']))}" class="btn btn-default">项目预算</a></if>
                                <if condition="rolemenu(array('Op/app_materials'))"><a href="{:U('Op/app_materials',array('opid'=>$op['op_id']))}" class="btn btn-default">申请物资</a></if>
                               
                                <!--
                                <if condition="rolemenu(array('Sale/goods'))"><a href="{:U('Sale/goods',array('opid'=>$op['op_id']))}" class="btn btn-default">项目销售</a></if>
                                -->
                                <if condition="rolemenu(array('Finance/settlement'))"><a href="{:U('Finance/settlement',array('opid'=>$op['op_id']))}" class="btn btn-default ">项目结算</a></if>

                                 <if condition="rolemenu(array('Finance/huikuan')) && (($op['create_time'] gt 1523980800) && $member) || ($op['create_time'] lt 1523980800)"><!--2018-04-15-->
                                     <a href="{:U('Finance/huikuan',array('opid'=>$op['op_id']))}" class="btn btn-default">项目回款</a>
                                     <else />
                                     <a href="javascript:;" onclick="alert('请先填写随团人员信息名单!');" class="btn btn-default">项目回款</a>
                                 </if>
                                <!--<if condition="rolemenu(array('Finance/huikuan'))"><a href="{:U('Finance/huikuan',array('opid'=>$op['op_id']))}" class="btn btn-default">项目回款</a></if>-->
                                <if condition="rolemenu(array('Op/evaluate'))"><a href="{:U('Op/evaluate',array('opid'=>$op['op_id']))}" class="btn btn-default">项目评价</a></if>
                            </div>
                            
                             
                             <div class="box box-warning" style="margin-top:15px;">
                                <div class="box-header" >
                                    <h3 class="box-title">
                                    <php> if($op['status']==1){ echo '<span class="green">项目已成团</span>&nbsp;&nbsp; <span style="font-weight:normal; color:#ff3300;"  id="print_1">（团号：'.$op['group_id'].'）</span>';}elseif($op['status']==2){ echo '<span class="red">项目不成团</span>&nbsp;&nbsp; <span style="font-weight:normal">（原因：'.$op['nogroup'].'）</span>';}else{ echo ' <span style=" color:#999999;">该项目暂未成团</span>';} </php>
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
                            
                            
                            <div class="box box-warning">
                                <div class="box-header">
                                    <h3 class="box-title">实际成团确认</h3>
                                </div><!-- /.box-header -->
                                <div class="box-body">
                                
									<?php if(!$confirm || !$upd_num || cookie('roleid')==10 || C('RBAC_SUPER_ADMIN')==cookie('username') ){ ?>
                                    <include file="confirm_edit" />
                                    <?php }else{ ?>
                                    <include file="confirm_read" />	
                                    <?php }?>
                                    
                                </div>
                            </div>


                            <div class="box box-warning">
                                <div class="box-header">
                                    <h3 class="box-title">随团人员名单</h3>
                                </div><!-- /.box-header -->
                                <div class="box-body">
                                    <?php if($stu_list){ ?>
                                        <include file="confirm_name_list" />
                                    <?php }else{ ?>
                                        <div class="content" ><span style="padding:20px 0; float:left; clear:both; text-align:center; text-align:center; width:100%;">暂无人员信息!</span></div>
                                    <?php } ?>

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
    laydate.render({
        elem: '.inputdate_a',theme: '#0099CC',type: 'datetime'
    });
</script>
     


