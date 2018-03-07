<include file="Index:header2" />

            <aside class="right-side">
                <!-- Content Header (Page header) -->
                <section class="content-header">
                    <h1>
                        工单管理
                    </h1>
                    <ol class="breadcrumb">
                        <li><a href="{:U('Index/index')}"><i class="fa fa-home"></i> 首页</a></li>
                        <li><a href="{:U('Rbac/index')}"><i class="fa fa-gift"></i> {$_pagetitle_}</a></li>
                        <li class="active">{$_action_}</li>
                    </ol>
                </section>

                <!-- Main content -->
                <section class="content">

                    <div class="row">
                        <div class="col-xs-12">
                            <div class="box">
                                <div class="box-header">
                                    <h3 class="box-title">工单计划列表</h3>
                                    <div class="box-tools pull-right">
                                    	 <a href="javascript:;" class="btn btn-info btn-sm" onclick="javascript:opensearch('searchtext',800,160);"><i class="fa fa-search"></i> 搜索</a>
                                         <a href="{:U('Worder/new_worder')}" class="btn btn-sm btn-danger"><i class="fa fa-plus"></i> 新建工单</a>
                                    </div>
                                </div><!-- /.box-header -->
                                <div class="box-body">
                                
                                <div class="btn-group" id="catfont">
                                    <a href="{:U('Worder/worder_list',array('pin'=>0))}" class="btn <?php if($pin==0){ echo 'btn-info';}else{ echo 'btn-default';} ?>">所有工单</a>
                                    <a href="{:U('Worder/my_worder',array('pin'=>1))}" class="btn <?php if($pin==1){ echo 'btn-info';}else{ echo 'btn-default';} ?>">我的已申请工单</a>
                                    <a href="{:U('Worder/my_worder',array('pin'=>2))}" class="btn <?php if($pin==2){ echo 'btn-info';}else{ echo 'btn-default';} ?>">我的待执行工单</a>
                                </div>
                                
                                <table class="table table-bordered dataTable fontmini" id="tablelist" style="margin-top:10px;">
                                    <tr role="row" class="orders" >
                                        <th class="sorting" width="80" data="id">id</th>
                                        <th class="sorting" data="worder_title">工单标题</th>
                                        <th class="sorting" width="160" data="worder_content">工单内容</th>
                                        <th class="sorting" data="worder_type">工单类型</th>
                                        <th class="sorting" data="init_user_name">发起人姓名</th>
                                        <!--<th class="sorting" data='init_dept_name'>发起人部门</th>-->
                                        <th class="sorting" width="80"  data="exe_user_name">执行人姓名</th>
                                        <!--<th class="sorting" width="80" data="exe_dept_name">执行人部门</th>-->
                                        <th class="sorting" width="80" data="status">工单状态</th>
                                        <th class="sorting" >工单创建时间</th>
                                        <th class="sorting" >工单完成时间</th>
                                        <!--<if condition="rolemenu(array('Worder/exe_worder'))">
                                        <th width="40" class="taskOptions">执行</th>
                                        </if>

                                        <if condition="rolemenu(array('Worder/del_worder'))">
                                        <th width="40" class="taskOptions">删除</th>
                                        </if> -->
                                        <if condition="rolemenu(array('Worder/exe_worder')) or rolemenu(array('Worder/del_worder'))">
                                            <th width="40" class="taskOptions">操作</th>
                                        </if>

                                    </tr>
                                    <foreach name="lists" item="row"> 
                                    <tr>
                                        <td>{$row.id}</td>
                                        <td>{$row.worder_title}</td>
                                        <td>{$row.worder_content}</td>
                                        <td>{$row.type}</td>
                                        <td>{$row.ini_user_name}</td>
                                        <td>{$row.exe_user_name}</td>
                                        <td>{$row.sta}</td>
                                        <td>{$row.create_time|date='Y-m-d H:i:s',###}</td>
                                        <if condition="$row.complete_time eq 0">
                                            <td>未完成</td>
                                            <else />
                                            <td>{$row.complete_time|date='Y-m-d H:i:s',###}</td>
                                        </if>
                                        <if condition="$pin eq 1">
                                            <td>

                                                <if condition="($row.sta neq '执行部门已确认完成') and ($row.sta neq '发起人已确认完成') and ($row.sta neq '拒绝或无效工单') and ($row.sta neq '已撤销')">
                                                    <if condition="rolemenu(array('Worder/revoke'))">
                                                    <a href="{:U('Worder/revoke',array('id'=>$row['id']))}" title="撤销" class="btn btn-info btn-smsm"><i class="fa fa-reply"></i></a>
                                                    </if>
                                                <else />
                                                    <if condition="($row.sta eq '执行部门已确认完成') and (rolemenu(array('Worder/new_worder')))">
                                                        <button onClick="javascript:{:open_resure($row['id'])}" title="确认执行完成" class="btn btn-success btn-sm"><i class="fa fa-check-circle-o"></i></button>
                                                    </if>
                                                </if>
                                            </td>
                                        <else />
                                            <td>
                                                <if condition="rolemenu(array('Worder/exe_worder'))">
                                                    <if condition="($row.sta neq '执行部门已确认完成') and ($row.sta neq '发起人已确认完成') and ($row.sta neq '拒绝或无效工单') and ($row.sta neq '已撤销')">
                                                        <a href="{:U('Worder/exe_worder',array('id'=>$row['id']))}" title="执行" class="btn btn-info btn-smsm"><i class="fa fa-pencil"></i></a>
                                                        <else />

                                                    </if>
                                                </if>
                                            </td>
                                        </if>

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
            
            
            <div id="searchtext">
                <form action="" method="get" id="searchform">
                <input type="hidden" name="m" value="Main">
                <input type="hidden" name="c" value="Worder">
                <input type="hidden" name="a" value="worder_list">

                <div class="form-group col-md-12">
                    <input type="text" class="form-control" name="worder_title" placeholder="工单名称">
                </div>

                <div class="form-group col-md-12">
                    <input type="text" class="form-control" name="worder_content" placeholder="工单内容">
                </div>
                
                </form>
            </div>

<include file="Index:footer2" />
