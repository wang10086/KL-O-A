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
                                        <th class="taskOptions">预算费用</th>
                                        <th class="taskOptions">实际发生费用</th>
                                        <th class="taskOptions">季度费用控制率</th>
                                        <th class="taskOptions">本指标得分</th>
                                        <th class="taskOptions" width="60">详情</th>
                                    </tr>
                                    <tr>
                                        <td class="taskOptions">{$ys}</td>
                                        <td class="taskOptions">{$sett}</td>
                                        <td class="taskOptions">{$rate}</td>
                                        <td class="taskOptions">{$complete}</td>
                                        <td class="taskOptions"><a href="{:U('Manage/Manage_quarter', array('year'=>$year,'quart'=>$quart))}" class="btn btn-smsm btn-info" title="详情"><i class="fa fa-bars"></i></a></td>
                                    </tr>
                                    <tr>
                                        <td colspan="5">注：预算费用按上季度末月26日0时前在”财务管理-经营管理-季度经营”页面中录入的《季度预算报表》中公司“其他费用”取值。上季度末月26日0时前未录入数值时，系统取值“1”。</td>
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
