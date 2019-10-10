<include file="Index:header2" />

            <aside class="right-side">
                <!-- Content Header (Page header) -->
                <section class="content-header">
                    <h1>
                        {$pagetitle}
                        <small>{$_action_}</small>
                    </h1>
                    <ol class="breadcrumb">
                        <li><a href="{:U('Index/index')}"><i class="fa fa-home"></i> 首页</a></li>
                        <li><a href="javascript:;"><i class="fa fa-gift"></i> {$pagetitle}</a></li>
                        <li class="active">{$_action_}</li>
                    </ol>
                </section>

                <!-- Main content -->
                <section class="content">
                    <div class="row">
                        <div class="col-xs-12">
                            <div class="box box-warning">
                                <div class="box-header">
                                    <h3 class="box-title">{$year}年{$month}月{$_action_}</h3>
                                </div><!-- /.box-header -->
                                <div class="box-body">

								<table class="table table-bordered dataTable" id="tablelist">
                                    <tr role="row" class="orders" >
                                        <th class="taskOptions" width="100">姓名</th>
                                        <th class="taskOptions">合计</th>
                                        <th class="taskOptions">岗位薪酬</th>
                                        <th class="taskOptions">奖金</th>
                                        <th class="taskOptions">补助</th>
                                        <th class="taskOptions">五险一金</th>
                                    </tr>
                                    <tr>
                                        <td class="taskOptions">{$thisMonthSum['']}</td>
                                        <td class="taskOptions">{$thisMonthSum['']}</td>
                                        <td class="taskOptions">{$thisMonthSum['']}</td>
                                        <td class="taskOptions">{$thisMonthSum['']}</td>
                                        <td class="taskOptions">{$thisMonthSum['']}</td>
                                        <td class="taskOptions">{$thisMonthSum['']}</td>
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
