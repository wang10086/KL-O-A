<!--激励机制--计调-->
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
                        <th class="taskOptions">转交客户当季度毛利</th>
                        <th class="taskOptions">当季转交客户应发奖金</th>
                        <th class="taskOptions">累计转交客户毛利</th>
                        <th class="taskOptions">累计应发转交客户奖金</th>
                        <th class="taskOptions">累计已发转交客户奖金</th>
                    </tr>
                    <tr>
                        <td class="taskOptions">{$encourage_data.complete}</td>
                        <td class="taskOptions">{$encourage_data.quarter_should_royalty}</td>
                        <td class="taskOptions">{$encourage_data.sum_complete}</td>
                        <td class="taskOptions">{$encourage_data.sum_should_royalty}</td>
                        <td class="taskOptions">{$encourage_data.sum_royalty_payoff}</td>
                    </tr>
                </table>
            </div>
            <div class="form-group">&nbsp;</div>
        </div>

    </div><!-- /.box-body -->
</div>
