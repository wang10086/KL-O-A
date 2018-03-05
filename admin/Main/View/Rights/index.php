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
                                	<div class="btn-group" id="catfont">
                                        <button onClick="javascript:window.location.href='{:U('Rights/index',array('status'=>'-1'))}';" class="btn <?php if($status=='-1'){ echo 'btn-info';}else{ echo 'btn-default';} ?>">所有的</button>
                                        <button onClick="javascript:window.location.href='{:U('Rights/index',array('status'=>0))}';" class="btn <?php if($status==0){ echo 'btn-info';}else{ echo 'btn-default';} ?>">未审核</button>
                                        <button onClick="javascript:window.location.href='{:U('Rights/index',array('status'=>1))}';" class="btn <?php if($status==1){ echo 'btn-info';}else{ echo 'btn-default';} ?>">已通过审核</button>
                                        <button onClick="javascript:window.location.href='{:U('Rights/index',array('status'=>2))}';" class="btn <?php if($status==2){ echo 'btn-info';}else{ echo 'btn-default';} ?>">未通过审核</button>
                                       
                                    </div>
                                	<table class="table table-bordered dataTable fontmini" id="tablelist" style="margin-top:10px;">
                                        <tr role="row" class="orders" >
                                        	<th class="sorting" data="id">序号</th>
                                            <th class="sorting" data="req_type">申请类型</th>
                                            <th class="sorting" data="req_time">申请时间</th>
                                            <th>团号</th>
                                            <th width="220">资源名称</th>
                                            <th>计调人员</th>
                                            <th>回款金额</th>
                                        	<th >备注</th>
                                        	<th>申请人</th>
                                        	<th >申请原因</th>
                                        	<th>审批状态</th>
                                        	<th>审批意见</th>
                                            <th >审批</th>
                                        </tr>
                                        <foreach name="lists" item="row">                      
                                        <tr>
                                            <td>{$row.id}</a></td>
                                            <td>{$row.req_type_name}</td>
                                            <td>{$row.req_time|date='Y-m-d H:i:s',###}</td>
                                            <if condition="$row['group_id']"><td>{$row['group_id']}</td>
                                            <else />
                                                <td>未成团</td>
                                            </if>

                                            <td>
                                            <a href="<?php echo U($row['cfgdata']['view'], array('id'=>$row['req_id'])); ?>" target="_blank" title="{$row.resdata.name}">
                                            <div class="mores">{$row.resdata.name}</div>
                                            </a>
                                            </td>
                                            <td>{$row.jidiao}</td>
                                            <td>{$row.amount}</td>
                                            <td>{$row.other}</td>
                                            <td>{$row.req_uname}</td>
                                            <td>{$row.req_reason}</td>
                                            <td><?php echo $audit_status[$row['dst_status']]; ?></td>
                                            <td>{$row.audit_reason}</td>
                                            <td class="taskOptions">
                                            <?php if ($row['dst_status'] == P::AUDIT_STATUS_PASS) { ?>
                                                <button onClick="javascript:;" title="审批" class="btn btn-disable btn-sm"><i class="fa fa-check-circle-o"></i></button>
                                            <?php } else { ?>
                                                <button onClick="javascript:{:open_audit($row['id'])}" title="审批" class="btn btn-success btn-sm"><i class="fa fa-check-circle-o"></i></button>
                                            <?php } ?>
                                            </td>
                                          
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
