<!--激励机制--业务-->
<div class="box box-warning">
    <div class="box-header">
        <h3 class="box-title">激励机制</h3>
        <div class="box-tools pull-right"></div>
    </div><!-- /.box-header -->
    <div class="box-body">
        <div class="content">
            <!--<span class="rtxt" style="margin-top:-10px;">
            月份：{$kpi.month} &nbsp;&nbsp;&nbsp;&nbsp;
            被考评人：{:username($kpi['user_id'])} &nbsp;&nbsp;&nbsp;&nbsp;
            考评得分：{$kpi.score} &nbsp;&nbsp;&nbsp;&nbsp;
            </span>-->

            <div class="box-body table-responsive no-padding">
                <table class="table table-bordered dataTable fontmini" id="tablelist" style="margin-top:10px;">
                    <tr role="row" class="orders" >
                        <th class="taskOptions">当季度任务指标</th>
                        <th class="taskOptions">当季度业绩</th>
                        <th class="taskOptions">累计任务指标</th>
                        <th class="taskOptions">累计业绩</th>
                        <th class="taskOptions">0-100%提成</th>
                        <th class="taskOptions">100%-150%提成</th>
                        <th class="taskOptions">150%以上提成</th>
                        <th class="taskOptions">200%以上提成</th>
                        <th class="taskOptions">累计合计提成</th>
                        <th class="taskOptions">累计已发放提成</th>
                        <th class="taskOptions">当季度应发提成</th>
                    </tr>
                    <tr>
                        <td class="taskOptions">{$encourage_data.target}</td>
                        <td class="taskOptions"><?php echo $encourage_data['quarter_partner_money'] ? $encourage_data['complete'] .'+<span class="red">'. $encourage_data['quarter_partner_money'].'</span>' : $encourage_data['complete']; ?></td>
                        <td class="taskOptions">{$encourage_data.sum_target}</td>
                        <td class="taskOptions"><?php echo $encourage_data['sum_partner_money'] ? $encourage_data['sum_complete'] .'+<span class="red">'. $encourage_data['sum_partner_money'].'</span>' : $encourage_data['sum_complete']; ?></td>
                        <td class="taskOptions">{$encourage_data.royalty5}</td>
                        <td class="taskOptions">{$encourage_data.royalty20}</td>
                        <td class="taskOptions">{$encourage_data.royalty25}</td>
                        <td class="taskOptions">{$encourage_data.royalty40}</td>
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