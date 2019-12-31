<include file="Index:header2" />

            <aside class="right-side">
                <!-- Content Header (Page header) -->
                <section class="content-header">
                    <h1>
                        {$_action_}<small>计调</small>
                    </h1>
                    <ol class="breadcrumb">
                        <li><a href="{:U('Index/index')}"><i class="fa fa-home"></i> 首页</a></li>
                        <li><a href="javascript:;"><i class="fa fa-gift"></i> 计调操作</a></li>
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
                                </div><!-- /.box-header -->
                                <div class="box-body">

                                    <div class="btn-group" id="catfont" style="padding-bottom:5px;">
                                        <?php if($prveyear>2018){ ?>
                                            <a href="{:U('Sale/public_kpi_profit_set',array('year'=>$prveyear,'quarter'=>$quarter))}" class="btn btn-default" style="padding:8px 18px;">上一年</a>
                                        <?php } ?>
                                        <?php
                                        for($i=1;$i<5;$i++){
                                            if($quarter == $i){
                                                echo '<a href="'.U('Sale/public_kpi_profit_set',array('year'=>$year,'quarter'=>$i)).'" class="btn btn-info" style="padding:8px 18px;">'.$i.'季度</a>';
                                            }else{
                                                echo '<a href="'.U('Sale/public_kpi_profit_set',array('year'=>$year,'quarter'=>$i)).'" class="btn btn-default" style="padding:8px 18px;">'.$i.'季度</a>';
                                            }
                                        }
                                        ?>
                                        <?php if($year<date('Y')){ ?>
                                            <a href="{:U('Sale/public_kpi_profit_set',array('year'=>$nextyear,'quarter'=>$quarter))}" class="btn btn-default" style="padding:8px 18px;">下一年</a>
                                        <?php } ?>
                                    </div>
                                    <P>说明：该数据从{$year-1}年12月26日-{$year}年{:date('m',$endTime)}月{:date('d',$endTime)}日累计结算数据。</P>
                                <table class="table table-bordered dataTable fontmini" id="tablelist" style="margin-top:10px;">
                                    <tr role="row">
                                        <th class="taskOptions">业务类型</th>
                                        <th class="taskOptions">设置毛利率</th>
                                        <th class="taskOptions">实际毛利率</th>
                                        <th class="taskOptions">偏差</th>
                                        <th class="taskOptions">合格范围</th>
                                        <th class="taskOptions">得分</th>
                                        <th class="taskOptions">权重</th>
                                        <th class="taskOptions">权重得分</th>
                                    </tr>
                                    <foreach name="lists" key="k" item="row">
                                    <tr >
                                        <td class="taskOptions">{$row.kind_name}</td>
                                        <td class="taskOptions">{$row['gross'] ? $row['gross'] : '<font color="#999">无数据</font>'}</td>
                                        <td class="taskOptions">{$row.maolilv}</td>
                                        <td class="taskOptions">{$row.deviation}</td>
                                        <?php if ($k == 0){ ?>
                                        <td class="taskOptions" rowspan="{:count($lists)+1}">±10%</td>
                                        <?php } ?>
                                        <td class="taskOptions">{$row.dev_score}</td>
                                        <td class="taskOptions">{$row.weight}</td>
                                        <td class="taskOptions">{$row.weight_score}</td>
                                    </tr>
                                    </foreach>
                                    <tr class="black">
                                        <td class="taskOptions">合计</td>
                                        <td class="taskOptions"></td>
                                        <td class="taskOptions"></td>
                                        <td class="taskOptions"></td>
                                        <td class="taskOptions"></td>
                                        <td class="taskOptions"></td>
                                        <td class="taskOptions"></td>
                                        <td class="taskOptions"></td>
                                    </tr>
                                </table>
                                </div><!-- /.box-body -->
                                 <div class="box-footer clearfix">
                                	<div class="pagestyle">{$pages}</div>
                                </div>
                            </div><!-- /.box -->

                        </div><!-- /.col -->
                     </div>
                </section><!-- /.content -->
            </aside><!-- /.right-side -->


<include file="Index:footer2" />
