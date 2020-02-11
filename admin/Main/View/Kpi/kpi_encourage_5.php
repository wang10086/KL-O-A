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
                        <th class="taskOptions">上年季度毛利</th>
                        <th class="taskOptions">当季度任务指标</th>
                        <th class="taskOptions">当季度毛利额</th>
                        <th class="taskOptions">累计任务指标</th>
                        <th class="taskOptions">累计毛利额</th>
                        <th class="taskOptions">100%-200%提成</th>
                        <th class="taskOptions">200%以上提成</th>
                        <th class="taskOptions">累计合计提成</th>
                        <th class="taskOptions">累计已发放提成</th>
                        <th class="taskOptions">当季度应发提成</th>
                    </tr>
                    <tr>
                        <td class="taskOptions">{$encourage_data.lastYearProfit}</td>
                        <td class="taskOptions">{$encourage_data.target}</td>
                        <td class="taskOptions">{$encourage_data.thisYearProfit}</td>
                        <td class="taskOptions">{$encourage_data.sum_target}</td>
                        <td class="taskOptions">{$encourage_data.thisYearSumProfit}</td>
                        <td class="taskOptions">{$encourage_data.royalty5}</td>
                        <td class="taskOptions">{$encourage_data.royalty10}</td>
                        <td class="taskOptions">{$encourage_data.royaltySum}</td>
                        <td class="taskOptions">{$encourage_data.sum_royalty_payoff}</td>
                        <td class="taskOptions">{$encourage_data.quarter_should_royalty}</td>
                    </tr>
                </table>

            </div>
            <div class="form-group">&nbsp;</div>
        </div>

    </div><!-- /.box-body -->
</div>
