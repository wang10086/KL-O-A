<!--激励机制--业务-->
<div class="box box-warning">
    <div class="box-header">
        <h3 class="box-title">激励机制</h3>
        <div class="box-tools pull-right"></div>
    </div><!-- /.box-header -->
    <div class="box-body">
        <div class="content">

            <div class="box-body table-responsive no-padding">
                <table class="table table-bordered dataTable fontmini" id="tablelist" style="margin-top:10px;">
                    <tr role="row" class="orders" >
                        <th class="taskOptions">年度</th>
                        <th class="taskOptions">公司累计毛利</th>
                        <th class="taskOptions">增长比率</th>
                        <th class="taskOptions">机关累计发生人力成本</th>
                        <th class="taskOptions">当年度机关累计人力成本额度</th>
                        <th class="taskOptions">机关五险一金增量</th>
                        <th class="taskOptions">机关奖金包</th>
                        <th class="taskOptions">当年机关季度累计薪酬包</th>
                        <th class="taskOptions">当年机关季度累计薪酬包结余</th>
                        <th class="taskOptions">本部门经理内部满意度权重</th>
                        <th class="taskOptions">本部门核定权重人数</th>
                        <th class="taskOptions">本部门季度累计奖励</th>
                        <th class="taskOptions">本部门季度累计已发奖励</th>
                        <th class="taskOptions">本部门当季度应发奖励</th>
                        <th class="taskOptions">本人当季度应发奖励</th>

                    </tr>
                    <tr>
                        <td class="taskOptions">{$year - 1}年</td>
                        <td class="taskOptions">{$encourage_data.lastYearProfit}</td>
                        <td class="taskOptions" rowspan="2">{$encourage_data.profit_up_rate}</td>
                        <td class="taskOptions">{$encourage_data.lastYearHrCost}</td>
                        <td class="taskOptions" rowspan="2">{$encourage_data.shouldHrCost}</td>
                        <td class="taskOptions" rowspan="2">{$encourage_data.Insurance_up_data}</td>
                        <td class="taskOptions" rowspan="2">{$encourage_data.jiguan_bonus}</td>
                        <td class="taskOptions" rowspan="2">{$encourage_data.jiguan_sum_salary_bag}</td>
                        <td class="taskOptions" rowspan="2">{$encourage_data.totalSalaryBagLeftOver}</td>
                        <td class="taskOptions" rowspan="2">{$encourage_data.satisfaction_weight}</td>
                        <td class="taskOptions" rowspan="2">{$encourage_data.member_weight}</td>
                        <td class="taskOptions" rowspan="2">{$encourage_data.departmentSumEncourage}</td>
                        <td class="taskOptions" rowspan="2">{$encourage_data.department_sum_royalty_payoff}</td>
                        <td class="taskOptions" rowspan="2">{$encourage_data.department_should_royalty}</td>
                        <td class="taskOptions" rowspan="2">{$encourage_data.quarter_should_royalty}</td>
                    </tr>
                    <tr>
                        <td class="taskOptions">{$year}年</td>
                        <td class="taskOptions">{$encourage_data.thisYearProfit}</td>
                        <td class="taskOptions">{$encourage_data.thisYearHrCost}</td>
                    </tr>
                </table>

            </div>
            <div class="form-group">&nbsp;</div>
        </div>

    </div><!-- /.box-body -->
</div>
