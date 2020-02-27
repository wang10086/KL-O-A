<include file="Index:header2" />

            <aside class="right-side">
                <!-- Content Header (Page header) -->
                <section class="content-header">
                    <h1>{$_action_}</h1>
                    <ol class="breadcrumb">
                        <li><a href="{:U('Index/index')}"><i class="fa fa-home"></i> 首页</a></li>
                        <li class="active">{$_action_}</li>
                    </ol>
                </section>

                <!-- Main content -->
                <section class="content">

                    <div class="row">
                        <div class="col-xs-12">
                            <div class="box box-warning">
                                <div class="box-header">
                                    <h3 class="box-title">{$_action_}</h3>
                                    <h3 class="box-title pull-right" style="font-weight:normal; color:#333333;">{$year}年{$quarter}季度</h3>&emsp;&emsp;
                                </div><!-- /.box-header -->
                                <div class="box-body">
								<table class="table table-bordered dataTable fontmini">
                                    <tr role="row">
                                        <th class="taskOptions" width="80">年份</th>
                                        <th class="taskOptions">公司员工(正式员工)</th>
                                        <th class="taskOptions">业务岗员工</th>
                                        <th class="taskOptions">业务岗人员占比</th>
                                        <th class="taskOptions">业务岗人员占比增长比率</th>
                                        <th class="taskOptions" width="60">详情</th>
                                    </tr>
                                    <tr>
                                        <td class="taskOptions">{$year - 1}年</td>
                                        <td class="taskOptions">{$lastYearData.sum_num}</td>
                                        <td class="taskOptions">{$lastYearData.sale_num}</td>
                                        <td class="taskOptions">{$lastYearData.yw_rate_str}</td>
                                        <td class="taskOptions" rowspan="2">{$complete}</td>
                                        <td class="taskOptions"><a href="{:U('Kpi/public_sales_ratio_detail', array('year'=>$year,'quarter'=>$quarter,'pin'=>2))}" class="btn btn-smsm btn-info" title="详情"><i class="fa fa-bars"></i></a></td>
                                    </tr>
                                    <tr>
                                        <td class="taskOptions">{$year}年</td>
                                        <td class="taskOptions">{$thisYearData.sum_num}</td>
                                        <td class="taskOptions">{$thisYearData.sale_num}</td>
                                        <td class="taskOptions">{$thisYearData.yw_rate_str}</td>
                                        <td class="taskOptions" width="60"><a href="{:U('Kpi/public_sales_ratio_detail', array('year'=>$year,'quarter'=>$quarter,'pin'=>1))}" class="btn btn-smsm btn-info" title="详情"><i class="fa fa-bars"></i></a></td>
                                    </tr>
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
        <input type="hidden" name="c" value="Rbac">
        <input type="hidden" name="a" value="kpi_quota">

        <div class="form-group col-md-12"></div>
        <div class="form-group col-md-12">
            <input type="text" class="form-control" name="tit" placeholder="请输入指标名称关键字">
        </div>
        <div class="form-group col-md-12">
            <input type="text" class="form-control" name="con" placeholder="请输入指标内容关键字">
        </div>
    </form>
</div>

<include file="Index:footer2" />
