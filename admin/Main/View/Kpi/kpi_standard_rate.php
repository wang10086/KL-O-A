<include file="Index:header2" />

            <aside class="right-side">
                <!-- Content Header (Page header) -->
                <section class="content-header">
                    <h1>
                        {$_action_}
                        <small>{$year}年{$quarter}季度</small>
                    </h1>
                    <ol class="breadcrumb">
                        <li><a href="{:U('Index/index')}"><i class="fa fa-home"></i> 首页</a></li>
                        <li class="active">{$_action_}</li>
                    </ol>
                </section>

                <!-- Main content -->
                <section class="content">
                    <div class="row">
                        <div class="col-xs-12">
                            <div class="box box-success">
                                <div class="box-header">
                                    <h3 class="box-title">{$_action_}</h3>
                                    <div class="box-tools pull-right"></div>
                                </div><!-- /.box-header -->
                                <div class="box-body">
                                <table class="table table-bordered dataTable fontmini" id="tablelist" style="margin-top:10px;">
                                    <tr role="row" class="orders" >
                                        <th class="taskOptions" width="100">项目编号</th>
                                        <th class="taskOptions">团号</th>
                                        <th class="taskOptions">项目名称</th>
                                        <th class="taskOptions">项目成本</th>
                                        <th class="taskOptions">项目类型</th>
                                        <th class="taskOptions">是否标准化</th>
                                    </tr>
                                    <foreach name="lists" item="row">
                                        <tr>
                                            <td class="taskOptions">{$row.op_id}</td>
                                            <td class="taskOptions">{$row.group_id}</td>
                                            <td class="taskOptions"><a href="{:U('Op/plans_follow',array('opid'=>$row['op_id']))}">{$row.project}</a></td>
                                            <td class="taskOptions">{$row.budget}</td>
                                            <td class="taskOptions">{$kinds[$row['kind']]}</td>
                                            <td class="taskOptions"><?php echo $row['standard']==1 ? "<span class='green'>标准化</span>" : '非标准化'; ?></td>
                                        </tr>
                                    </foreach>
                                    <tr>
                                        <td class="black" colspan="6">
                                            <span style="display: inline-block; width: 33%">总成本：{$data.sum_budget}</span>
                                            <span style="display: inline-block; width: 33%">标准化成本：{$data.standard_budget}</span>
                                            <span style="display: inline-block; width: 33%">标准化率：{$data.standard_budget_rate}</span>
                                        </td>
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

<include file="Index:footer2" />
