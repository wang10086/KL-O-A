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
                    <!--<tr role="row" class="orders" >
                        <th class="taskOptions">本季度科学快车毛利①</th>
                        <th class="taskOptions">上年同周期科学快车毛利②</th>
                        <th class="taskOptions">本季度科学快车毛利增量③</th>
                        <th class="taskOptions">科学快车毛利增量奖金④</th>
                        <th class="taskOptions">本季度合伙人合计毛利⑤</th>
                        <th class="taskOptions">上年同周期合伙人合计毛利⑥</th>
                        <th class="taskOptions">本季度合伙人合计毛利增量⑦</th>
                        <th class="taskOptions">合伙人合计毛利增量奖金⑧</th>
                        <th class="taskOptions">本季度奖金合计⑨</th>
                    </tr>-->
                    <tr role="row" class="orders" >
                        <th class="taskOptions">本季度科学快车毛利</th>
                        <th class="taskOptions">上年同周期科学快车毛利</th>
                        <th class="taskOptions">本季度科学快车毛利增量</th>
                        <th class="taskOptions">科学快车毛利增量奖金</th>
                        <th class="taskOptions">本季度合伙人合计毛利</th>
                        <th class="taskOptions">上年同周期合伙人合计毛利</th>
                        <th class="taskOptions">本季度合伙人合计毛利增量</th>
                        <th class="taskOptions">合伙人合计毛利增量奖金</th>
                        <th class="taskOptions">本季度奖金合计</th>
                    </tr>
                    <tr>
                        <td class="taskOptions">{$encourage_data.lastYearProfit}</td>
                        <td class="taskOptions">{$encourage_data.target}</td>
                        <td class="taskOptions">{$encourage_data.thisYearProfit}</td>
                        <td class="taskOptions">{$encourage_data.sum_target}</td>
                        <td class="taskOptions">{$encourage_data.thisYearSumProfit}</td>
                        <td class="taskOptions">{$encourage_data.royalty5}</td>
                        <td class="taskOptions">{$encourage_data.royalty10}</td>
                        <td class="taskOptions">{$encourage_data.sum_should_royalty}</td>
                        <td class="taskOptions">{$encourage_data.quarter_should_royalty}</td>
                    </tr>
                </table>

            </div>
            <div class="form-group">&nbsp;</div>
        </div>

    </div><!-- /.box-body -->
</div>
