<include file="Index:header2" />

    <aside class="right-side">
        <!-- Content Header (Page header) -->
        <section class="content-header">
            <h1>合同详情</h1>
            <ol class="breadcrumb">
                <li><a href="{:U('Index/index')}"><i class="fa fa-home"></i> 首页</a></li>
                <li><a href="{:U('Contract/index')}"><i class="fa fa-gift"></i> 合同管理</a></li>
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
                            {$row.pro_name}合同信息
                            </h3>
                            <h3 class="box-title pull-right" style="font-weight:normal; color:#333333;"><span class="green">合同编号：{$row.contract_id}</span></h3>
                        </div><!-- /.box-header -->
                        <div class="box-body">
                            <div class="content">
                                <table width="100%" id="font-14" rules="none" border="0" cellpadding="0" cellspacing="0">
                                    <tr>
                                        <td colspan="3">项目名称：{$row.pro_name}</td>
                                    </tr>
                                    <tr>
                                        <td width="33.33%">项目团号：{$row.group_id}</td>
                                        <td width="33.33%">项目编号：{$row.op_id}</td>
                                        <td width="33.33%">出团人数：{$row.number}人</td>
                                        
                                    </tr>
                                    <tr>
                                        <td width="33.33%">合同金额：&yen;{$row.contract_amount}</td>
                                        <td width="33.33%">出团时间：{$row.dep_time}</td>
                                        <td width="33.33%">结束时间：{$row.end_time}</td>
                                    </tr>
                                    <tr>
                                        <td width="33.33%">创建时间：{$row.create_time|date='Y-m-d H:i:s',###}</td>
                                        <td width="33.33%">创建者：{$row.create_user_name}</td>
                                        <td width="33.33%">确认状态：{$row.strstatus}</td>
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
                            <php> if($audit['dst_status']!=1){ </php>
                            <include file="op_edit" />
                            <php> }else{ </php>
                            <include file="op_read" />
                            <php> } </php>
                        </div>
                    </div>
                    
                                    
                    <div id="formsbtn" style="padding-bottom:10px;">
                        <div class="content">
                            <?php if($audit['dst_status']!=1){ ?>
                                <form method="post" action="{:U('Finance/appcost')}" name="myform" id="appsubmint">
                                <input type="hidden" name="dosubmit" value="1">
                                <input type="hidden" name="opid" value="{$op.op_id}">
                                </form>
                                
                                <div id="formsbtn" style="padding-bottom:20px; margin-top:10px;color:#ff3300;">当审核未被通过时，请调整预算后可能会被通过哦</div>
                                
                                
                                <button type="button" onClick="$('#save_appcost').submit()" class="btn btn-info btn-lg" style=" padding-left:40px; padding-right:40px; margin-right:10px;">保存预算</button>
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

