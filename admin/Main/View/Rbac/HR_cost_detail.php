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
                                    <h3 class="box-title">{$year}年<?php echo $pin==1 ? '01月-'.$month : $month; ?>月{$_action_}</h3>
                                    <h3 class="box-title pull-right mr20"><span class="green">{$department}</span></h3>
                                </div><!-- /.box-header -->
                                <div class="box-body">

								<table class="table table-bordered dataTable" id="tablelist">
                                    <tr role="row" class="orders" >
                                        <th class="taskOptions" width="100">姓名</th>
                                        <th class="taskOptions">合计</th>
                                        <th class="taskOptions">岗位薪酬</th>
                                        <th class="taskOptions">奖金</th>
                                        <th class="taskOptions">补助</th>
                                        <th class="taskOptions">公司五险一金</th>
                                        <?php if ($pin==1){ ?>
                                            <th class="taskOptions">累计月数</th>
                                            <th class="taskOptions">月均人力成本</th>
                                        <?php } ?>
                                    </tr>
                                    <!--<tr class="black">
                                        <td class="taskOptions" colspan="2"><?php /*echo $pin==1 ? '01月 - '.$month.'月' : $month.'月' */?>总合计</td>
                                        <td class="taskOptions" colspan="<?php /*echo $pin==1 ? 6 : 4; */?>">{$sum}</td>
                                    </tr>-->
                                    <foreach name="lists" item="v">
                                        <tr>
                                            <td class="taskOptions"><a href="<?php echo $pin==1 ? U('Salary/salaryindex',array('id'=>$v['account_id'],'months'=>$months)) : U('Salary/salarydetails',array('id'=>$v['salary_id'])); ?>">{$v['user_name']}</a></td>
                                            <td class="taskOptions">{$v['sum']}</td>
                                            <td class="taskOptions">{$v['sum_salary']}</td>
                                            <td class="taskOptions">{$v['sum_bonus']}</td>
                                            <td class="taskOptions">{$v['sum_subsidy']}</td>
                                            <td class="taskOptions">{$v['sum_insurance']}</td>
                                            <?php if ($pin==1){ ?>
                                            <td class="taskOptions">{$v['num']}</td>
                                            <td class="taskOptions">{$v['avg']}</td>
                                            <?php } ?>
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

<include file="Index:footer2" />
