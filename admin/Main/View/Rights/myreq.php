<include file="Index:header2" />

            <aside class="right-side">
                <!-- Content Header (Page header) -->
                <section class="content-header">
                    <h1>
                        {$_pagetitle_}
                        <small>{$_pagedesc_}</small>
                    </h1>
                    <ol class="breadcrumb">
                        <li><a href="{:U('Index/index')}"><i class="fa fa-home"></i> 首页</a></li>
                        <li><a href="{:U('Rights/res')}"><i class="fa fa-gift"></i> {$_pagetitle_}</a></li>
                        <li class="active">{$_action_}</li>
                    </ol>
                </section>

                <!-- Main content -->
                <section class="content">

                    <div class="row">
                        <div class="col-xs-12">
                            <div class="box">
                                <div class="box-header">
                                    <h3 class="box-title">{$_action_}</h3>
                                    <div class="box-tools pull-right">
                                         
                                    </div>
                                </div><!-- /.box-header -->
                                <div class="box-body">
                                	<table class="table table-bordered dataTable fontmini" id="tablelist">
                                        <tr role="row" class="orders" >
                                        	<th class="sorting" data="id">序号</th>
                                            <th class="sorting" data="req_type">申请类型</th>
                                            <th class="sorting" data="req_time">申请时间</th>
                                            <th >资源名称</th>
                                        	<th >备注</th>
                                        	<th>申请人</th>
                                        	<th >申请原因</th>
                                        	<th>审批状态</th>
                                        	<th>审批意见</th>
                                            <th >审批人</th>
                                           
                                        </tr>
                                        <foreach name="lists" item="row">                      
                                        <tr>
                                            <td>{$row.id}</a></td>
                                            <td>{$row['req_type_name']}</td>
                                            <td>{$row.req_time|date='Y-m-d H:i:s',###}</td>
                                            <td>
                                            <a href="<?php echo U($row['cfgdata']['view'], array('id'=>$row['req_id'])); ?>">
                                            {$row.resdata.name}
                                            </a>
                                            </td>
                                            <td>{$row.other}</td>
                                            <td>{$row.req_uname}</td>
                                            <td>{$row.req_reason}</td>
                                            <td><?php echo $audit_status[$row['dst_status']]; ?></td>
                                            <td>{$row.audit_reason}</td>
                                            <td>{$row.audit_uname}</td>
                                        </tr>
                                        </foreach>		
                                        
                                    </table>
                                
                                </div><!-- /.box-body -->
                                <div class="box-footer clearfix">
                                	<div class="pagestyle">{$pages}</div>
                                </div>
                            </div><!-- /.box -->

                        </div><!-- /.col -->
                     </div>

                </section><!-- /.content -->
            </aside><!-- /.right-side -->

        <include file="Index:footer2" />
