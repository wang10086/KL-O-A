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
                                    <h3 class="box-title pull-right" style="font-weight:normal; color:#333333;"></h3>&emsp;&emsp;
                                </div><!-- /.box-header -->
                                <div class="box-body">
								<table class="table table-bordered dataTable fontmini">
                                    <tr role="row">
                                        <th class="taskOptions" width="60">序号</th>
                                        <th class="taskOptions">记录标题</th>
                                        <th class="taskOptions">记录月份</th>
                                        <th class="taskOptions">记录类型</th>
                                        <th class="taskOptions">记录类型详情</th>
                                    </tr>
                                    <foreach name="lists" key="k" item="row">
                                        <tr>
                                            <td class="taskOptions">{$k+1}</td>
                                            <td class="taskOptions"><a href="{:U('Work/work_detail',array('id'=>$row['id']))}">{$row.title}</a></td>
                                            <td class="taskOptions">{$row['month']}</td>
                                            <td class="taskOptions">{$type[$row['type']]}</td>
                                            <td class="taskOptions">{$type_info[$row['type']][$row['typeinfo']]}</td>
                                        </tr>
                                    </foreach>
                                    <tr class="black">
                                        <td class="taskOptions">合计</td>
                                        <td class="taskOptions">目标值个数：{$target}</td>
                                        <td class="taskOptions">完成率：{$rate}</td>
                                        <td class="taskOptions">权重：{$weight}</td>
                                        <td class="taskOptions">得分：{$score}</td>
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
