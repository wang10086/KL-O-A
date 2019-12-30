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
                                    <h3 class="box-title">{$year}年{$month}月前累计毛利额总和</h3>
                                    <div class="box-tools pull-right"></div>
                                </div><!-- /.box-header -->

                                <div class="box-body">
                                <!--<div class="form-group black col-md-12">
                                    <div class="col-lg-4">目标金额: {$target}</div>
                                    <div class="col-lg-4">累计毛利: {$profit}</div>
                                    <div class="col-lg-4">完成率: {$complete}</div>
                                </div>-->
                                    <table class="table table-bordered dataTable fontmini" id="tablelist" style="margin-top:10px;">
                                        <tr role="row" class="orders" >
                                            <th class="taskOptions" width="60">编号</th>
                                            <th class="taskOptions">产品经理</th>
                                            <th class="taskOptions">目标金额</th>
                                            <th class="taskOptions">累计毛利</th>
                                            <th class="taskOptions">完成率</th>
                                            <th class="taskOptions" width="80">详情</th>
                                        </tr>
                                        <foreach name="lists" key="k" item="row">
                                            <tr>
                                                <td class="taskOptions">{$k+1}</td>
                                                <td class="taskOptions">{$row.username}</td>
                                                <td class="taskOptions">{$row.target}</td>
                                                <td class="taskOptions">{$row.sum_profit}</td>
                                                <td class="taskOptions">{$row.average}</td>
                                                <td class="taskOptions"><a href="{:U('Kpi/public_kpi_profit',array('year'=>$year,'uid'=>$row['userid'],'st'=>$st,'et'=>$et,'tg'=>$row['target']))}" class="btn btn-info btn-smsm"><i class="fa fa-bars"></i></a></td>
                                            </tr>
                                        </foreach>
                                        <tr class="black">
                                            <td colspan="2"  class="taskOptions">合计</td>
                                            <td class="taskOptions">{$data.sum_target}</td>
                                            <td class="taskOptions">{$data.sum_profit}</td>
                                            <td class="taskOptions">{$data.sum_average}</td>
                                            <td></td>
                                        </tr>
                                    </table>
                                </div><!-- /.box-body -->
                            </div><!-- /.box -->

                        </div><!-- /.col -->
                     </div>

                </section><!-- /.content -->
            </aside><!-- /.right-side -->

<include file="Index:footer2" />
