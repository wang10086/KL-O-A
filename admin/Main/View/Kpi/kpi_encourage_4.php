<!--激励机制--计调-->
<div class="box box-warning">
    <div class="box-header">
        <h3 class="box-title">激励机制</h3>
        <div class="box-tools pull-right"></div>
    </div><!-- /.box-header -->

    <div class="box-body">
        <div class="content">
            <!--<div class="line-bottom-box-gray black">年度数据增长</div>-->
            <table class="table table-bordered dataTable fontmini" id="tablelist" style="margin-top:10px;">
                <tr role="row" class="orders" >
                    <th class="taskOptions">年度</th>
                    <th class="taskOptions">累计毛利</th>
                    <th class="taskOptions">增长比率</th>
                    <th class="taskOptions">累计人力成本</th>
                    <!--<th class="taskOptions"></th>-->
                    <th class="taskOptions">部门业绩提成</th>
                    <th class="taskOptions">公司五险一金增量</th>
                    <th class="taskOptions">部门奖金包</th>
                    <th class="taskOptions">当年度累计薪酬包</th>
                    <th class="taskOptions">当年度累计实发薪酬包</th>
                    <th class="taskOptions">当年度累计薪酬包结余</th>
                </tr>
                <tr>
                    <td class="taskOptions">{$year-1} 年</td>
                    <td class="taskOptions">{$encourage_data.last_year_maoli}</td>
                    <td class="taskOptions" rowspan="2">{$encourage_data.maoli_up_rate}</td>
                    <td class="taskOptions">{$encourage_data.lastHrCostData}</td>
                    <!--<td class="taskOptions" rowspan="2">{$encourage_data.}</td>-->
                    <td class="taskOptions" rowspan="2">{$encourage_data.}</td>
                    <td class="taskOptions" rowspan="2">{$encourage_data.}</td>
                    <td class="taskOptions" rowspan="2">{$encourage_data.}</td>
                    <td class="taskOptions" rowspan="2">{$encourage_data.}</td>
                    <td class="taskOptions" rowspan="2">{$encourage_data.}</td>
                    <td class="taskOptions" rowspan="2">{$encourage_data.}</td>
                </tr>
                <tr>
                    <td class="taskOptions">{$year} 年</td>
                    <td class="taskOptions">{$encourage_data.this_year_maoli}</td>
                    <td class="taskOptions">{$encourage_data.thisHrCostData}</td>
                </tr>
            </table>
        </div>

        <div class="content">
            <!--<div class="line-bottom-box-gray black">操作提成</div>-->
            <table class="table table-bordered dataTable fontmini" id="tablelist" style="margin-top:10px;">
                <tr role="row" class="orders" >
                    <th class="taskOptions">本人季度累计奖励</th>
                    <th class="taskOptions">本人已发放奖励</th>
                    <th class="taskOptions">本人当季度应发奖励</th>
                    <th class="taskOptions">团队季度累计奖励</th>
                    <th class="taskOptions">团队已发放奖励</th>
                    <th class="taskOptions">团队当季度应发奖励</th>
                </tr>
                <tr>
                    <td class="taskOptions">{$encourage_data.}</td>
                    <td class="taskOptions">{$encourage_data.}</td>
                    <td class="taskOptions">{$encourage_data.}</td>
                    <td class="taskOptions">{$encourage_data.}</td>
                    <td class="taskOptions">{$encourage_data.}</td>
                    <td class="taskOptions">{$encourage_data.}</td>
                </tr>
            </table>
        </div>

    </div><!-- /.box-body -->
</div>
