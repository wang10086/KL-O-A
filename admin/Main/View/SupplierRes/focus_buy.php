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

                            <div class="btn-group" id="catfont" style="padding-bottom:20px;">
                                <?php if($prveyear>2017){ ?>
                                    <a href="{:U('SupplierRes/public_focus_buy',array('year'=>$prveyear,'quarter'=>$quarter))}" class="btn btn-default" style="padding:8px 18px;">上一年</a>
                                <?php } ?>
                                <?php
                                    for($i=1;$i<5;$i++){
                                        $par            = array();
                                        $par['year']    = $year;
                                        $par['quarter'] = $i;
                                        if($quarter==$i){
                                            echo '<a href="'.U('SupplierRes/public_focus_buy',$par).'" class="btn btn-info" style="padding:8px 18px;">'.$i.'季度</a>';
                                        }else{
                                            echo '<a href="'.U('SupplierRes/public_focus_buy',$par).'" class="btn btn-default" style="padding:8px 18px;">'.$i.'季度</a>';
                                        }
                                    }
                                ?>
                                <?php if($year<date('Y')){ ?>
                                    <a href="{:U('SupplierRes/public_focus_buy',array('year'=>$nextyear,'quarter'=>$quarter))}" class="btn btn-default" style="padding:8px 18px;">下一年</a>
                                <?php } ?>
                            </div>

                            <div class="box box-warning">
                                <div class="box-header">
                                    <h3 class="box-title">{$_action_}</h3>
                                    <div class="box-tools pull-right">
                                        <if condition="rolemenu(array('SupplierRes/focus_buy_list'))">
                                            <a href="{:U('SupplierRes/focus_buy_list')}" class="btn btn-info btn-sm">考核指标管理</a>
                                        </if>
                                    </div>
                                </div><!-- /.box-header -->
                                <div class="box-body">

                                    <!--<include file="timely_nave" />-->

                                    <table class="table table-bordered dataTable fontmini" id="tablelist" style="margin-top:10px;">
                                        <tr role="row" class="orders" >
                                            <th class="taskOptions" width="60">序号</th>
                                            <th class="taskOptions">集中采购事项</th>
                                            <th class="taskOptions">项目数</th>
                                            <th class="taskOptions">集中采购项目数</th>
                                            <th class="taskOptions">结算金额</th>
                                            <th class="taskOptions">集中采购结算金额</th>
                                            <th width="80" class="taskOptions">采购比率</th>
                                            <!--<th width="100" class="taskOptions">备注</th>-->
                                            <th width="100" class="taskOptions">详情</th>
                                        </tr>
                                        <foreach name="lists" key="k" item="v">
                                            <tr>
                                                <td class="taskOptions">{$k+1}</td>
                                                <td class="taskOptions"><a href="javascript:;" onclick="detail({$v.quota_id})">{$v.title}</a></td>
                                                <td class="taskOptions" style="max-width: 150px;">{$v.num}</td>
                                                <td class="taskOptions">{$v.focus_buy_num}</td>
                                                <td class="taskOptions">{$v.sum}</td>
                                                <td class="taskOptions">{$v.focus_buy_sum}</td>
                                                <td class="taskOptions">{$v.focus_buy_average}</td>
                                                <td class="taskOptions">
                                                    <a href="{:U('SupplierRes/public_focus_buy_detail',array('year'=>$year,'quarter'=>$quarter,'pin'=>$k))}" title="详情" class="btn btn-info btn-smsm"><i class="fa fa-bars"></i></a>
                                                </td>
                                            </tr>
                                        </foreach>
                                        <tr class="black">
                                            <td class="taskOptions" colspan="2">合计</td>
                                            <td class="taskOptions">{$sum_data.num}</td>
                                            <td class="taskOptions">{$sum_data.focus_buy_num}</td>
                                            <td class="taskOptions">{$sum_data.sum}</td>
                                            <td class="taskOptions">{$sum_data.focus_buy_sum}</td>
                                            <td class="taskOptions">{$sum_data.focus_buy_average}</td>
                                            <td class="taskOptions">
                                                <a href="{:U('SupplierRes/public_focus_buy_detail',array('year'=>$year,'quarter'=>$quarter,'pin'=>0))}" title="详情" class="btn btn-info btn-smsm"><i class="fa fa-bars"></i></a>
                                            </td>
                                        </tr>
                                    </table>
                                </div><!-- /.box-body -->
                            </div><!-- /.box -->

                        </div><!-- /.col -->
                    </div>

                </section><!-- /.content -->
            </aside><!-- /.right-side -->

<script type="text/javascript">
    //查看考核指标详情
    function detail(id) {
        art.dialog.open('index.php?m=Main&c=SupplierRes&a=public_focus_buy_info&id='+id,{
            lock:true,
            title: '集中采购执行率',
            width:800,
            height:400,
            fixed: true,

        });
    }
</script>

<include file="Index:footer2" />
