<!--激励机制--人资综合部PHP程序员-->
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
                        <th class="taskOptions">本季度已完成的指派工时之和</th>
                        <th class="taskOptions">本季度标准工时之和</th>
                        <th class="taskOptions">当季度已发奖金</th>
                        <th class="taskOptions">当季度未发奖金</th>
                        <th class="taskOptions">当季度应发奖金</th>
                    </tr>
                    <tr>
                        <td class="taskOptions">{$encourage_data.workLoadHourNum}</td>
                        <td class="taskOptions">{$encourage_data.workHourNum}</td>
                        <td class="taskOptions">{$encourage_data.quarter_paid_royalty}</td>
                        <td class="taskOptions">{$encourage_data.quarter_no_pay_royalty}</td>
                        <td class="taskOptions">{$encourage_data.quarter_should_royalty}</td>
                    </tr>
                </table>

            </div>
            <div class="form-group">&nbsp;</div>
        </div>

    </div><!-- /.box-body -->
</div>
