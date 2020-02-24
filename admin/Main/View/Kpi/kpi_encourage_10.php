<!--激励机制--业务-->
<div class="box box-warning">
    <div class="box-header">
        <h3 class="box-title">激励机制 <span class="red">(开发中...)</span></h3>
        <div class="box-tools pull-right"></div>
    </div><!-- /.box-header -->
    <div class="box-body">
        <div class="content">

            <div class="box-body table-responsive no-padding">
                <table class="table table-bordered dataTable fontmini" id="tablelist" style="margin-top:10px;">
                    <tr role="row" class="orders" >
                        <th class="taskOptions">年度</th>
                        <th class="taskOptions">公司累计毛利</th>
                        <th class="taskOptions">增长比率</th>
                        <th class="taskOptions">机关累计发生人力成本</th>
                        <th class="taskOptions">当年度机关累计人力成本额度</th>
                        <th class="taskOptions">机关五险一金增量</th>
                        <th class="taskOptions">机关奖金包</th>
                        <th class="taskOptions">当年机关季度累计薪酬包</th>
                        <th class="taskOptions">当年机关季度累计薪酬包结余</th>
                        <th class="taskOptions">本部门经理内部满意度权重</th>
                        <th class="taskOptions">本部门核定权重人数</th>
                        <th class="taskOptions">本部门季度累计奖励</th>
                        <th class="taskOptions">本部门季度累计已发奖励</th>
                        <th class="taskOptions">本部门当季度应发奖励</th>
                        <th class="taskOptions">本人当季度应发奖励</th>

                    </tr>
                    <tr>
                        <td class="taskOptions">{$year - 1}年</td>
                        <td class="taskOptions">①{$encourage_data.}</td>
                        <td class="taskOptions" rowspan="2">③{$encourage_data.}</td>
                        <td class="taskOptions">④{$encourage_data.}</td>
                        <td class="taskOptions" rowspan="2">⑥{$encourage_data.}</td>
                        <td class="taskOptions" rowspan="2">⑦{$encourage_data.}</td>
                        <td class="taskOptions" rowspan="2">⑧{$encourage_data.}</td>
                        <td class="taskOptions" rowspan="2">⑨{$encourage_data.}</td>
                        <td class="taskOptions" rowspan="2">⑩{$encourage_data.}</td>
                        <td class="taskOptions" rowspan="2">⑪{$encourage_data.}</td>
                        <td class="taskOptions" rowspan="2">⑫{$encourage_data.}</td>
                        <td class="taskOptions" rowspan="2">⑬{$encourage_data.}</td>
                        <td class="taskOptions" rowspan="2">⑭{$encourage_data.}</td>
                        <td class="taskOptions" rowspan="2">⑮{$encourage_data.quarter_should_royalty}</td>
                        <td class="taskOptions" rowspan="2">⑯{$encourage_data.quarter_should_royalty}</td>
                    </tr>
                    <tr>
                        <td class="taskOptions">{$year}年</td>
                        <td class="taskOptions">②{$encourage_data.}</td>
                        <td class="taskOptions">⑤{$encourage_data.}</td>
                    </tr>
                </table>

            </div>
            <div class="form-group">&nbsp;</div>
        </div>

    </div><!-- /.box-body -->
</div>
