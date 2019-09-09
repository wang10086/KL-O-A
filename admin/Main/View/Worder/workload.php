<include file="Index:header2" />

            <aside class="right-side">
                <!-- Content Header (Page header) -->
                <section class="content-header">
                    <h1>
                        工作负荷率
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
                                    <h3 class="box-title pull-right mt10">工单执行人: {$data.username}</h3>
                                </div><!-- /.box-header -->
                                <div class="box-body">

                                <table class="table table-bordered dataTable fontmini" id="tablelist" style="margin-top:10px;">
                                    <tr role="row" class="orders" >
                                        <th class="taskOptions" width="60" data="id">ID</th>
                                        <th class="" width="120" data="worder_title">工单标题</th>
                                        <th class="" width="80" data="init_user_name">发起人姓名</th>
                                        <th class="" width="80" data="status">工单状态</th>
                                        <th class="" width="125">工单响应时间</th>
                                        <th class="" width="125">工单计划时间</th>
                                        <th class="" width="80">所需工时(小时)</th>
                                        <!--<th class="" width="80">本周期需工作工时(小时)</th>-->
                                    </tr>
                                    <foreach name="lists" item="row"> 
                                    <tr>
                                        <td class="taskOptions">{$row.id}</td>
                                        <td><a href="{:U('Worder/worder_info',array('id'=>$row['id']))}">{$row.worder_title}</a></td>
                                        <td>{$row.ini_user_name}</td>
                                        <td>{$row.sta}</td>
                                        <td>{$row.response_time|date='Y-m-d H:i:s',###}</td>
                                        <td>{$row.plan_complete_time|date='Y-m-d H:i:s',###}</td>
                                        <td class="taskOptions">{$row.hour}</td>
                                        <!--<td class="taskOptions">{$row.worderHourNum}</td>-->
                                    </tr>
                                    </foreach>
                                    <tr class="black">
                                        <td colspan="2">本周期工时: {$data.workHourNum} 小时</td>
                                        <td colspan="2">工单工时: {$data.workLoadHourNum} 小时</td>
                                        <td colspan="3">工作负荷度:{$data.complete}</td>
                                    </tr>
                                </table>
                                </div><!-- /.box-body -->
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

                <div class="form-group col-md-6">
                    <select name="worder_type" class="form-control">
                        <foreach name="worder_type" key="k" item="v">
                            <option value="{$k}">{$v}</option>
                        </foreach>
                    </select>
                </div>

                <div class="form-group col-md-6">
                    <input type="text" class="form-control" name="worder_content" placeholder="工单内容">
                </div>
                
                </form>
            </div>

<include file="Index:footer2" />
