<include file="Index:header2" />



            <aside class="right-side">
                <!-- Content Header (Page header) -->
                <section class="content-header">
                    <h1>
                        <span class="green">合格供方</span> - <span style="color:#333333">{$row.name}</span>
                    </h1>
                    <ol class="breadcrumb">
                        <li><a href="{:U('Index/index')}"><i class="fa fa-home"></i> 首页</a></li>
                        <li><a href="{:U('SupplierRes/res')}"><i class="fa fa-gift"></i> {$_pagetitle_}</a></li>
                        <li class="active">{$_action_}</li>
                    </ol>
                </section>

                <!-- Main content -->
                <section class="content">
                    <div class="row">
                         <!-- right column -->
                        <div class="col-md-12">
                            <!-- general form elements disabled -->
                            <div class="box">
                                <div class="box-header">
                                    <h3 class="box-title">供方属性</h3>
                                </div><!-- /.box-header -->
                                <div class="box-body">
                                	
                                    <div class="content">
                                		
                                        
                                        <div class="form-group col-md-12 viwe">
                                            <p>供方名称：{$row.name}</p>
                                        </div>
                                        <div class="form-group col-md-4 viwe">
                                            <p>供方类型：{$reskind[$row[kind]]}</p>
                                        </div>

                                        <div class="form-group col-md-4 viwe">
                                            <p>所在省市：<?php echo $row['country'].'-'.$row['prov'].'-'.$row['city'] ?></p>
                                        </div>
                                        <div class="form-group col-md-4 viwe">
                                            <p>供方级别：{$types[$row['type']]}</p>
                                        </div>
                                        
                                        <div class="form-group col-md-4 viwe">
                                            <p>发布时间：{$row.input_time|date='Y-m-d H:i:s',###}</p>
                                        </div>
                                        
                                        <div class="form-group col-md-4 viwe">
                                            <p>联系人：{$row.contact}</p>
                                        </div>
                                        
                                        <div class="form-group col-md-4 viwe">
                                            <p>联系电话：{$row.tel}</p>
                                        </div>

                                        <!--<div class="form-group col-md-4 viwe">
                                            <p>审批状态：{$row.showstatus}</p>
                                        </div>
                                        <div class="form-group col-md-4 viwe">
                                            <p>审批人：{$row.show_user}</p>
                                        </div>
                                        <div class="form-group col-md-4 viwe">
                                            <p>审批时间：{$row.show_time}</p>
                                        </div>-->
                                    </div>
                                    
                                </div><!-- /.box-body -->
                            </div><!-- /.box -->
                            
                            
                            <div class="box">
                                <div class="box-header">
                                    <h3 class="box-title">供方介绍</h3>
                                </div><!-- /.box-header -->
                                <div class="box-body">
                                    <div class="content" style="margin-top:10px;">
                                    	<div class="form-group col-md-12 viwe">{$row.desc}</div>
                                    </div>
                                </div><!-- /.box-body -->
                            </div><!-- /.box -->

                            <div class="box">
                                <div class="box-header">
                                    <h3 class="box-title">合作记录</h3>
                                    <div class="box-tools pull-right">
<!--                                        <a href="javascript:;" class="btn btn-info btn-sm" onclick="javascript:opensearch('searchtext',600,160);"><i class="fa fa-search"></i> 搜索</a>-->
                                    </div>
                                </div><!-- /.box-header -->
                                <div class="box-body">

                                    <table class="table table-bordered dataTable fontmini" id="tablelist">
                                        <tr role="row" class="orders" >
                                            <th class="sorting" data="op_id">项目编号</th>
                                            <th class="" data="group_id">团号</th>
                                            <th class="" data="project">项目名称</th>
                                            <th class="" data="sale_user">销售</th>
                                            <th class="" data="">结算状态</th>
                                            <th class="">结算金额</th>
                                        </tr>
                                        <foreach name="oplist" item="row">
                                            <tr>
                                                <td>{$row.op_id}</td>
                                                <td>{$row.group_id}</td>
                                                <td><a href="{:U('Finance/settlement', array('opid'=>$row['op_id']))}">{$row.project}</a></td>
                                                <td>{$row.sale_user}</td>
                                                <td>{$status[$row[saudit_status]]}</td>
                                                <td>{$row.settlement_total}</td>
                                            </tr>
                                        </foreach>

                                    </table>

                                </div><!-- /.box-body -->
                                <div class="box-footer clearfix">
                                    <div class="pagestyle">{$pages}</div>
                                </div>
                            </div><!-- /.box -->
                            
                            
                        </div><!--/.col (right) -->
                    </div>   <!-- /.row -->
                </section><!-- /.content -->
                
            </aside><!-- /.right-side -->

  </div>
</div>


            
<include file="Index:footer2" />