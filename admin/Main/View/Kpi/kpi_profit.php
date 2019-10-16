<include file="Index:header2" />

            <aside class="right-side">
                <!-- Content Header (Page header) -->
                <section class="content-header">
                    <h1>{$_action_}</h1>
                    <ol class="breadcrumb">
                        <li><a href="{:U('Index/index')}"><i class="fa fa-home"></i> 首页</a></li>
                        <li><a href="javascript:;"><i class="fa fa-gift"></i> {$_pagetitle_}</a></li>
                        <li class="active">{$_action_}</li>
                    </ol>
                </section>

                <!-- Main content -->
                <section class="content">

                    <div class="row">
                        <div class="col-xs-12">
                            <div class="box box-warning">
                                <div class="box-header">
                                    <h3 class="box-title">{$year}年{$kinds[$kind]}</h3>
                                    <div class="box-tools pull-right"></div>
                                </div><!-- /.box-header -->

                                <div class="box-body">
                                <div class="form-group black col-md-12">
                                    <div class="col-lg-4">目标金额: {$target}</div>
                                    <div class="col-lg-4">累计毛利: {$profit}</div>
                                    <div class="col-lg-4">完成率: {$complete}</div>
                                </div>
                                <table class="table table-bordered dataTable fontmini" id="tablelist" style="margin-top:10px;">
                                    <tr role="row" class="orders" >
                                        <th class="taskOptions" width="80">编号</th>
                                        <th class="taskOptions">团号</th>
                                        <th>项目名称</th>
                                        <th class="taskOptions">销售</th>
                                        <th class="taskOptions">毛利</th>
                                    </tr>
                                    <foreach name="lists" item="row"> 
                                    <tr>
                                        <td class="taskOptions">{$row.op_id}</td>
                                        <td class="taskOptions">{$row.group_id}</td>
                                        <td>{$row.project}</td>
                                        <td class="taskOptions">{$row.sale_user}</td>
                                        <td class="taskOptions">{$row.maoli}</td>
                                    </tr>
                                    </foreach>
                                </table>
                                </div><!-- /.box-body -->
                            </div><!-- /.box -->

                        </div><!-- /.col -->
                     </div>

                </section><!-- /.content -->
            </aside><!-- /.right-side -->

<include file="Index:footer2" />
