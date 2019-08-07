<include file="Index:header2" />



            <aside class="right-side">
                <!-- Content Header (Page header) -->
                <section class="content-header">
                    <h1>
                        物资采购申请单
                    </h1>
                    <ol class="breadcrumb">
                        <li><a href="{:U('Index/index')}"><i class="fa fa-home"></i> 首页</a></li>
                        <li><a href="{:U('Project/index')}"><i class="fa fa-gift"></i> {$_pagetitle_}</a></li>
                        <li class="active">{$_action_}</li>
                    </ol>
                </section>

                <!-- Main content -->
                <section class="content">
                    <div class="row">
                         <!-- right column -->
                        <div class="col-md-12">
                           
                            <div class="box">
                                <div class="box-header">
                                    <h3 class="box-title">申请描述</h3>
                                </div><!-- /.box-header -->
                                <div class="box-body">
                                	
                                    <div class="content">
										<table width="100%" id="font-14" rules="none" border="0" cellpadding="0" cellspacing="0">       
                                            <tr>
                                                <td width="33.33%">申请团号：{$row.order_id}</td>
                                                <td width="33.33%">采购部门：<?php echo $bumen[$row['department']];  ?></td>
                                                <td width="33.33%">采购申请人：{$row.app_user} </td>
                                            </tr>
                                            <tr>
                                                <td width="33.33%">申请时间：<?php echo date('Y-m-d H:i:s',$row['create_time']) ?></td>
                                                <td width="33.33%">处理状态：<?php if($row['audit_status']==0){ echo '未处理';}else{ echo'已处理';}?></td>
                                                <td width="33.33%"></td>
                                            </tr>
                                        </table>
    
                                        
                                    </div>
                                    
                                </div><!-- /.box-body -->
                            </div><!-- /.box -->
                           
                            <div class="box">
                                <div class="box-header">
                                    <h3 class="box-title">物资清单</h3>
                                </div>
                                <div class="box-body">
                                	<?php if($material){ ?>
                                    <div class="content">
                                	<table class="table table-striped" id="font-14-p">
                                    	<tr role="row">
                                            <th style="width: 50px">编号</th>
                                            <th>物资名称</th>
                                            <th>申请数量</th>
                                            <th>参考单价</th>
                                            <th>申请合计金额</th>
                                            <th width="25%">备注</th>
                                        </tr>
                                        <foreach name="material" key="k" item="row">
                                        <tr>
                                            <td><?php echo $k+1; ?></td>
                                            <td>{$row.material}</td>
                                            <td>{$row.amount}</td>
                                            <td>&yen;{$row.unit_price}</td>
                                            <td>{$row.total}</td>
                                            <td>{$row.remarks}</td>
                                        </tr>
                                        </foreach>
                                    </table>
                                    <div  class="no-print" style=" margin-top:15px;">
                                        <button class="btn btn-default" onclick="window.print();"><i class="fa fa-print"></i> 打印</button>
                                    </div>
                                    </div>
                                    <?php }else{ echo '<div style="padding:25px;">暂未申请任何物资</div>'; } ?>
                                </div>
                            </div>
                            
                           

                        </div><!--/.col (right) -->
                    </div>   <!-- /.row -->
                </section><!-- /.content -->
                
            </aside><!-- /.right-side -->

  </div>
</div>


            
<include file="Index:footer2" />