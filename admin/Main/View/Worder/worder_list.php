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
                            <div class="box box-success">
                                <div class="box-header">
                                    <h3 class="box-title">工单计划列表</h3>
                                    <div class="box-tools pull-right">
                                    	 <a href="javascript:;" class="btn btn-info btn-sm" onclick="javascript:opensearch('searchtext',800,160);"><i class="fa fa-search"></i> 搜索</a>
                                         <a href="{:U('Worder/new_worder')}" class="btn btn-sm btn-success"><i class="fa fa-plus"></i> 新建工单</a>
                                    </div>
                                </div><!-- /.box-header -->
                                <div class="box-body">
                                
                                <div class="btn-group" id="catfont">
                                    <a href="{:U('Worder/worder_list',array('pin'=>0))}" class="btn <?php if($pin==0){ echo 'btn-info';}else{ echo 'btn-default';} ?>">所有工单</a>
                                    <a href="{:U('Worder/worder_list',array('pin'=>3))}" class="btn <?php if($pin==3){ echo 'btn-info';}else{ echo 'btn-default';} ?>">我的待指派工单</a>
                                    <a href="{:U('Worder/worder_list',array('pin'=>1))}" class="btn <?php if($pin==1){ echo 'btn-info';}else{ echo 'btn-default';} ?>">我的已申请工单</a>
                                    <a href="{:U('Worder/worder_list',array('pin'=>2))}" class="btn <?php if($pin==2){ echo 'btn-info';}else{ echo 'btn-default';} ?>">我的待执行工单</a>
                                </div>
                                
                                <table class="table table-bordered dataTable fontmini" id="tablelist" style="margin-top:10px;">
                                    <tr role="row" class="orders" >
                                        <th class="sorting" width="60" data="id">id</th>
                                        <th class="sorting" width="120" data="worder_title">工单标题</th>
                                        <th class="sorting" width="80" data="worder_type">工单类型</th>
                                        <th class="sorting" width="80" data="ini_user_name">发起人姓名</th>
                                        <th class="sorting" width="80"  data="exe_user_name">接收人姓名</th>
                                        <th class="sorting" width="80"  data="assign_name">执行人姓名</th>
                                        <th class="sorting" width="80" data="status">工单状态</th>
                                        <th class="sorting" width="125">工单创建时间</th>
                                        <th class="taskOptions" width="80">工时</th>
                                        <th class="taskOptions" width="125">完成状态</th>
                                        <th class="taskOptions" width="40">详情</th>
                                        <th class="taskOptions" width="40">修改</th>
                                        <if condition="rolemenu(array('Worder/del_worder'))">
                                        <th width="40" class="taskOptions">删除</th>
                                        </if> 
                                    </tr>
                                    <foreach name="lists" item="row"> 
                                    <tr>
                                        <td>{$row.id}<if condition="($row.urgent eq 2) and (in_array($row.status,array(0,1,2)))"><small class="badge pull-right bg-red" style="margin-right:4px;">加急</small></if></td>
                                        <td><a href="{:U('Worder/worder_info',array('id'=>$row['id']))}">{$row.worder_title}</a></td>
                                        <td>{$worder_type[$row[worder_type]]}</td>
                                        <td>{$row.ini_user_name}</td>
                                        <td>{$row.exe_user_name}</td>
                                        <td><?php echo $row['assign_name']?$row['assign_name']:"<span class=\"yellow\">未指派</span>"; ?></td>
                                        <td>{$row.sta}</td>
                                        <td>{$row.create_time|date='Y-m-d H:i:s',###}</td>
                                        <td class="taskOptions">{$row.hour}</td>
                                        <td class="taskOptions">{$row.com_stu}</td>
                                        <td class="taskOptions">
                                            <button onClick="javascript:window.location.href='{:U('Worder/worder_info',array('id'=>$row['id']))}';" title="详情" class="btn btn-success  btn-smsm"><i class="fa  fa-building-o"></i></button>
                                        </td>
                                        <td class="taskOptions">
                                            <if condition="cookie('userid') eq $row['ini_user_id'] and $row['status'] eq 0">
                                                <button onClick="javascript:window.location.href='{:U('Worder/worder_edit',array('id'=>$row['id']))}';" title="修改" class="btn btn-info  btn-smsm"><i class="fa  fa-pencil"></i></button>
                                            </if>
                                        </td>
                                        <if condition="rolemenu(array('Worder/del_worder'))">
                                        <td class="taskOptions">
                                        <button onClick="javascript:ConfirmDel('{:U('Worder/del_worder',array('id'=>$row['id']))}')" title="删除" class="btn btn-warning btn-smsm"><i class="fa fa-times"></i></button>
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

                <div class="form-group col-md-6">
                    <input type="text" class="form-control" name="worder_title" placeholder="工单名称">
                </div>

                <div class="form-group col-md-6">
                    <input type="text" class="form-control" name="worder_content" placeholder="工单内容">
                </div>

                <div class="form-group col-md-6">
                    <select name="worder_type" class="form-control">
                        <option value="">==请选择==</option>
                        <foreach name="worder_type" key="k" item="v">
                            <option value="{$k}">{$v}</option>
                        </foreach>
                    </select>
                </div>

                <div class="form-group col-md-6">
                    <input type="text" class="form-control" name="ini" placeholder="发起人">
                </div>
                
                </form>
            </div>

<include file="Index:footer2" />
