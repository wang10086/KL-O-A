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
                        <th class="taskOptions">本季度业绩目标</th>
                        <th class="taskOptions">本季度贡献业绩</th>
                        <th class="taskOptions">累计业绩目标</th>
                        <th class="taskOptions">累计贡献业绩</th>
                        <th class="taskOptions">累计业绩贡献奖金</th>
                        <th class="taskOptions">已发业绩贡献奖金</th>
                        <th class="taskOptions">本季度应发业绩贡献奖金</th>
                        <th class="taskOptions">本季度业务转交毛利</th>
                        <th class="taskOptions">本季度业务转交毛利奖金</th>
                        <th class="taskOptions">已发业务转交毛利奖金</th>
                        <th class="taskOptions">本季度应发业务转交毛利奖金</th>
                        <th class="taskOptions">本季度合计应发奖金</th>

                    </tr>
                    <tr>
                        <td class="taskOptions">{$encourage_data.quarter_target}</td>
                        <td class="taskOptions">{$encourage_data.quarter_profit}</td>
                        <td class="taskOptions">{$encourage_data.year_target}</td>
                        <td class="taskOptions">{$encourage_data.year_profit}</td>
                        <td class="taskOptions">{$encourage_data.sum_yj_royalty}</td>
                        <td class="taskOptions">{$encourage_data.paid_yj_royalty}</td>
                        <td class="taskOptions">{$encourage_data.quarter_should_yj_royalty}</td>
                        <td class="taskOptions">{$encourage_data.quarter_maoli}</td>
                        <td class="taskOptions">{$encourage_data.quarter_maoli_royalty}</td>
                        <td class="taskOptions">{$encourage_data.paid_maoli_royalty}</td>
                        <td class="taskOptions">{$encourage_data.quarter_should_maoli_royalty}</td>
                        <td class="taskOptions">{$encourage_data.quarter_should_royalty}</td>
                    </tr>
                </table>

            </div>
            <div class="form-group">&nbsp;</div>
        </div>

    </div><!-- /.box-body -->
</div>
