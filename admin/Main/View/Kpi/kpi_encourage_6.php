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
                        <th class="taskOptions">季度累计快车毛利</th>
                        <!--<th class="taskOptions">上年同周期科学快车毛利</th>-->
                        <th class="taskOptions">本季度科学快车毛利增量</th>
                        <th class="taskOptions">科学快车毛利增量奖金</th>
                        <th class="taskOptions">季度累计合伙人创毛利</th>
                        <!--<th class="taskOptions">上年同周期合伙人合计毛利</th>-->
                        <th class="taskOptions">本季度合伙人创毛利增量</th>
                        <th class="taskOptions">合伙人创毛利增量奖金</th>
                        <th class="taskOptions">本季度奖金合计</th>
                        <th class="taskOptions">累计已发奖金</th>
                        <th class="taskOptions">当季度应发奖金</th>

                    </tr>
                    <tr>
                        <td class="taskOptions">{$year-1}年</td>
                        <td class="taskOptions">{$encourage_data.lastYearKxkcSum}</td>
                        <td class="taskOptions" rowspan="2">{$encourage_data.kxkcUpData}</td>
                        <td class="taskOptions" rowspan="2">{$encourage_data.kxkc_bonus}</td>
                        <td class="taskOptions">{$encourage_data.lastYearPartnerSum}</td>
                        <td class="taskOptions" rowspan="2">{$encourage_data.partnerUpData}</td>
                        <td class="taskOptions" rowspan="2">{$encourage_data.partner_bonus}</td>
                        <td class="taskOptions" rowspan="2">{$encourage_data.sum_should_royalty}</td>
                        <td class="taskOptions" rowspan="2">{$encourage_data.sum_royalty_payoff}</td>
                        <td class="taskOptions" rowspan="2">{$encourage_data.quarter_should_royalty}</td>
                    </tr>
                    <tr>
                        <td class="taskOptions">{$year}年</td>
                        <td class="taskOptions">{$encourage_data.thisYearKxkcSum}</td>
                        <td class="taskOptions">{$encourage_data.thisYearPartnerSum}</td>
                    </tr>
                </table>

            </div>
            <div class="form-group">&nbsp;</div>
        </div>

    </div><!-- /.box-body -->
</div>
