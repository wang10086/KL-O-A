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
                        <th class="taskOptions">上年季度累计产品经理项目毛利</th>
                        <th class="taskOptions">本年季度累计产品经理项目毛利</th>
                        <th class="taskOptions">季度累计产品经理项目毛利增量</th>
                        <th class="taskOptions">累计奖励</th>
                        <th class="taskOptions">累计已发奖励</th>
                        <th class="taskOptions">当季度应发奖励</th>

                    </tr>
                    <tr>
                        <td class="taskOptions">{$encourage_data.lastYearProfit}</td>
                        <td class="taskOptions">{$encourage_data.thisYearProfit}</td>
                        <td class="taskOptions">{$encourage_data.profitUpData}</td>
                        <td class="taskOptions">{$encourage_data.sum_should_royalty}</td>
                        <td class="taskOptions">{$encourage_data.sum_royalty_payoff}</td>
                        <td class="taskOptions">{$encourage_data.quarter_should_royalty}</td>
                    </tr>
                </table>

            </div>
            <div class="form-group">&nbsp;</div>
        </div>

    </div><!-- /.box-body -->
</div>
