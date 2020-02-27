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
                                        <th class="taskOptions" width="60">序号</th>
                                        <th class="taskOptions">姓名</th>
                                        <th class="taskOptions">所在部门</th>
                                        <th class="taskOptions">岗位</th>
                                        <th class="taskOptions">业务属性</th>
                                    </tr>
                                    <foreach name="lists" key="k" item="row">
                                        <tr>
                                            <td class="taskOptions">{$k+1}</td>
                                            <td class="taskOptions">{$row.nickname}</td>
                                            <td class="taskOptions">{$departments[$row['departmentid']]}</td>
                                            <td class="taskOptions">{$positions[$row['position_id']]}</td>
                                            <td class="taskOptions"><?php echo $row['is_yw']==1 ? '<span class="green">业务</span>' : '非业务'; ?></td>
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
