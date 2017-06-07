<include file="Index:header2" />



            <aside class="right-side">
                <!-- Content Header (Page header) -->
                <section class="content-header">
                    <h1>
                        物资出库申请单
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

                                        <div class="form-group col-md-4 viwe">
                                            <p>申请团号：{$row.order_id}</p>
                                        </div>
                                        
                                        <div class="form-group col-md-4 viwe">
                                            <p>领取人：{$row.receive_liable}</p>
                                        </div>
                                        
                                        <div class="form-group col-md-4 viwe">
                                            <p>库房负责人：{$row.storehouse_liable} </p>
                                        </div>
                                        
                                        <div class="form-group col-md-4 viwe">
                                            <p>出库类型：{$ontype[$row[type]]}</p>
                                        </div>
                                        
                                        <div class="form-group col-md-4 viwe">
                                            <p>申请时间：<?php echo date('Y-m-d H:i:s',$row['out_time']) ?></p>
                                        </div>
                                        
                                        <div class="form-group col-md-4 viwe">
                                            <p>处理状态：<?php if($row['audit_status']==0){ echo '未处理';}else{ echo'已处理';}?></p>
                                        </div>
                                        
                                    </div>
                                    
                                </div><!-- /.box-body -->
                            </div><!-- /.box -->
                           
                            <div class="box">
                                <div class="box-header">
                                    <h3 class="box-title">物资清单</h3>
                                </div>
                                <div class="box-body">
                                	<?php if($material){ ?>
                                	<table class="table table-bordered dataTable fontmini" id="tablelist">
                                    	<tr role="row" class="orders" >
                                            <th style="width: 50px">编号</th>
                                            <th>物资名称</th>
                                            <th>当前库存</th>
                                            <th>申请数量</th>
                                            <th>申请单价</th>
                                            <th>最近入库价</th>
                                            <th>申请合计金额</th>
                                            <th width="25%">备注</th>
                                        </tr>
                                        <foreach name="material" key="k" item="row">
                                        <tr>
                                            <td><?php echo $k+1; ?></td>
                                            <td><a href="{:U('Material/stock',array('keywords'=>$row['material']))}" target="_blank">{$row.material}</a></td>
                                            <td>{$row.stock}{$row.unit}</td>
                                            <td>{$row.amount}{$row.unit}</td>
                                            <td>&yen;{$row.unit_price}</td>
                                            <td>&yen;{$row.price}</td>
                                            <td>{$row.total}</td>
                                            <td>{$row.remarks}</td>
                                        </tr>
                                        </foreach>
                                    </table>
                                    <?php }else{ echo '<div style="padding:25px;">暂未添加任何物资</div>'; } ?>
                                </div>
                            </div>
                            
                           

                        </div><!--/.col (right) -->
                    </div>   <!-- /.row -->
                </section><!-- /.content -->
                
            </aside><!-- /.right-side -->

  </div>
</div>


            
<include file="Index:footer2" />