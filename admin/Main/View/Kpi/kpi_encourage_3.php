<!--激励机制--计调-->
<div class="box box-warning">
    <div class="box-header">
        <h3 class="box-title">激励机制</h3>
        <div class="box-tools pull-right"></div>
    </div><!-- /.box-header -->

    <div class="box-body">
        <div class="content">
            <div class="line-bottom-box-gray black">年度数据增长</div>
            <table class="table table-bordered dataTable fontmini" id="tablelist" style="margin-top:10px;">
                <tr role="row" class="orders" >
                    <th class="taskOptions">年度</th>
                    <th class="taskOptions">季度毛利</th>
                    <th class="taskOptions">季度毛利增长</th>
                    <th class="taskOptions">累计毛利</th>
                    <th class="taskOptions">累计毛利增长</th>
                    <th class="taskOptions">累计毛利增长奖金</th>
                    <th class="taskOptions">累计已发毛利增长奖金</th>
                    <th class="taskOptions">当季应发操作奖金</th>
                </tr>
                <tr>
                    <td class="taskOptions">{$year-1} 年</td>
                    <td class="taskOptions"></td>
                    <td class="taskOptions" rowspan="2">{$encourage_data.}</td>
                    <td class="taskOptions">{$encourage_data.}</td>
                    <td class="taskOptions" rowspan="2">{$encourage_data.}</td>
                    <td class="taskOptions" rowspan="2">{$encourage_data.}</td>
                    <td class="taskOptions" rowspan="2">{$encourage_data.}</td>
                    <td class="taskOptions" rowspan="2">{$encourage_data.}</td>
                </tr>
                <tr>
                    <td class="taskOptions">{$year} 年</td>
                    <td class="taskOptions"></td>
                    <td class="taskOptions"></td>
                </tr>
            </table>
        </div>

        <div class="content">
            <div class="line-bottom-box-gray black">操作提成</div>
            <table class="table table-bordered dataTable fontmini" id="tablelist" style="margin-top:10px;">
                <tr role="row" class="orders" >
                    <th class="taskOptions">当季度操作毛利</th>
                    <th class="taskOptions">当季应发操作奖金</th>
                    <th class="taskOptions">累计操作毛利</th>
                    <th class="taskOptions">累计应发操作奖金</th>
                    <th class="taskOptions">累计已发操作奖金</th>
                    <th class="taskOptions">当季应发奖金合计</th>
                </tr>
                <tr>
                    <td class="taskOptions">{$encourage_data.complete}</td>
                    <td class="taskOptions">{$encourage_data.quarter_should_royalty}</td>
                    <td class="taskOptions">{$encourage_data.sum_complete}</td>
                    <td class="taskOptions">{$encourage_data.sum_should_royalty}</td>
                    <td class="taskOptions">{$encourage_data.sum_royalty_payoff}</td>
                    <td class="taskOptions">{$encourage_data.}</td>
                </tr>
            </table>
        </div>

    </div><!-- /.box-body -->
</div>
