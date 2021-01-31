<include file="Index:header2" />

            <aside class="right-side">
                <!-- Content Header (Page header) -->
                <section class="content-header">
                    <h1>{$_action_}</h1>
                    <ol class="breadcrumb">
                        <li><a href="{:U('Index/index')}"><i class="fa fa-home"></i> 首页</a></li>
                        <li><a href="javascript:;"><i class="fa fa-gift"></i> 数据统计</a></li>
                        <li class="active">{$_action_}</li>
                    </ol>
                </section>

                <!-- Main content -->
                <section class="content">

                    <div class="row">
                        <div class="col-xs-12">
                            <div class="box box-warning">
                                <div class="box-header">
                                    <h3 class="box-title">{$_action_}</h3>
                                    <h3 class="box-title pull-right mr-20">周期：{$quarter}季度</h3>
                                </div><!-- /.box-header -->
                                <div class="box-body">

                                    <table class="table table-bordered dataTable fontmini" id="tablelist" style="margin-top:10px;">
                                        <tr role="row" class="orders" >
                                            <th class="taskOptions" width="60">序号</th>
                                            <th class="taskOptions">事项</th>
                                            <th class="taskOptions">目标值</th>
                                            <th class="taskOptions">完成值</th>
                                            <th class="taskOptions">完成率</th>
                                            <th width="100" class="taskOptions">详情</th>
                                        </tr>
                                        <foreach name="lists" key="k" item="v">
                                            <tr>
                                                <td class="taskOptions">{$k+1}</td>
                                                <td class="taskOptions"><a href="javascript:;" onclick="kpi({$v.quota_id})">{$v.quota_title}</a></td>
                                                <td class="taskOptions" style="max-width: 150px;">{$v.target}</td>
                                                <td class="taskOptions">{$v.complete}</td>
                                                <td class="taskOptions">{$v.finish_avg}</td>
                                                <td class="taskOptions">
                                                    <a href="{$v.url}" title="详情" class="btn btn-info btn-smsm"><i class="fa fa-bars"></i></a>
                                                </td>
                                            </tr>
                                        </foreach>
                                        <tr class="black">
                                            <td class="taskOptions" colspan="2">合计</td>
                                            <td class="taskOptions"></td>
                                            <td class="taskOptions"></td>
                                            <td class="taskOptions">{$sum_data}</td>
                                            <td class="taskOptions"></td>
                                        </tr>
                                    </table>
                                </div><!-- /.box-body -->
                            </div><!-- /.box -->

                        </div><!-- /.col -->
                    </div>

                </section><!-- /.content -->
            </aside><!-- /.right-side -->

<script type="text/javascript">
    //查看KPI指标
    function kpi(id) {
        art.dialog.open('index.php?m=Main&c=Kpi&a=kpidetail&id='+id,{
            lock:true,
            title: 'KPI指标详情',
            width:800,
            height:400,
            fixed: true,

        });
    }
</script>

<include file="Index:footer2" />
