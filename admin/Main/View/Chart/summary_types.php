<include file="Index:header2" />

            <aside class="right-side">
                <!-- Content Header (Page header) -->
                <section class="content-header">
                    <h1>
                        项目分部门汇总
                    </h1>
                    <ol class="breadcrumb">
                        <li><a href="{:U('Index/index')}"><i class="fa fa-home"></i> 首页</a></li>
                        <li><a href="javascript:;"><i class="fa fa-gift"></i> 数据统计</a></li>
                        <li class="active">项目分部门汇总</li>
                    </ol>
                </section>

                <!-- Main content -->
                <section class="content">

                    <div class="row">
                        <div class="col-xs-12">
                            <div class="box box-warning">
                                <div class="box-header">
                                    <style>
                                        #chart_btn_group .btn-a{ background-color: #ddd;color: #666;}
                                    </style>
                                    <div class="box-tools btn-group" id = "chart_btn_group">
                                        <a href="{:U('Chart/summary_types',array('pin'=>0))}" class="btn btn-sm <?php if($pin==0){ echo 'btn-info';}else{ echo 'btn-a';} ?>">预算及结算分部门汇总</a>
                                        <a href="{:U('Chart/summary_types',array('pin'=>1))}" class="btn btn-sm <?php if($pin==1){ echo 'btn-info';}else{ echo 'btn-a';} ?>">已结算分部门汇总</a>
                                    </div>
                                </div><!-- /.box-header -->
                                <div class="box-body">

                                    <div class="btn-group" id="catfont" style="padding-bottom:5px;">
                                        <?php if($prveyear>2016){ ?>
                                            <a href="{:U('Chart/summary_types',array('year'=>$prveyear,'pin'=>$pin))}" class="btn btn-default" style="padding:8px 18px;">上一年</a>
                                        <?php } ?>
                                        <?php
                                        for($i=1;$i<13;$i++){
                                            if($year.$month==$year.str_pad($i,2,"0",STR_PAD_LEFT)){
                                                echo '<a href="'.U('Chart/summary_types',array('year'=>$year,'month'=>$i,'pin'=>$pin)).'" class="btn btn-info" style="padding:8px 18px;">'.$i.'月</a>';
                                            }else{
                                                echo '<a href="'.U('Chart/summary_types',array('year'=>$year,'month'=>$i,'pin'=>$pin)).'" class="btn btn-default" style="padding:8px 18px;">'.$i.'月</a>';
                                            }
                                        }
                                        ?>
                                        <?php if($year<date('Y')){ ?>
                                            <a href="{:U('Chart/summary_types',array('year'=>$nextyear,'month'=>'01','pin'=>$pin))}" class="btn btn-default" style="padding:8px 18px;">下一年</a>
                                        <?php } ?>
                                    </div>
                                
                                <table class="table table-bordered dataTable fontmini" id="tablelist" style="margin-top:10px;">
                                    <tr>
                                        <th class="sorting" style="text-align: center;" rowspan="2">部门</th>
                                        <th style="text-align: center;" rowspan="2">业务型态</th>
                                        <th colspan="5" style="text-align: center;">{$year}年累计</th>
                                        <th colspan="5" style="text-align: center;">{$month}月累计</th>
                                    </tr>

                                    <tr>
                                        <td class="taskOptions" data="" >项目数</td>
                                        <td class="taskOptions" data="">人数</td>
                                        <td class="taskOptions" data="">收入合计</td>
                                        <td class="taskOptions" data="">毛利合计</td>
                                        <td class="taskOptions" data="">毛利率(%)</td>
                                        <td class="taskOptions" data="">项目数</td>
                                        <td class="taskOptions" data="" width="">人数</td>
                                        <td class="taskOptions" data="">收入合计</td>
                                        <td class="taskOptions" data="">毛利合计</td>
                                        <td class="taskOptions" data="">毛利率(%)</td>
                                    </tr>


                                    <tr>
                                        <th class="taskOptions" rowspan="4">市场部</th>
                                    </tr>
                                    <tr>
                                        <td class="taskOptions">科学旅行</td>
                                        <td class="taskOptions">20.00</td>
                                        <td class="taskOptions">20.00</td>
                                        <td class="taskOptions">20.00</td>
                                        <td class="taskOptions">20.00</td>
                                        <td class="taskOptions">20.00</td>
                                        <td class="taskOptions">20.00</td>
                                        <td class="taskOptions">20.00</td>
                                        <td class="taskOptions">20.00</td>
                                        <td class="taskOptions">20.00</td>
                                         <td class="taskOptions">20.00</td>
                                    </tr>
                                    <tr>
                                        <td class="taskOptions">科学考察</td>
                                        <td class="taskOptions">20.00</td>
                                        <td class="taskOptions">20.00</td>
                                        <td class="taskOptions">20.00</td>
                                        <td class="taskOptions">20.00</td>
                                        <td class="taskOptions">20.00</td>
                                        <td class="taskOptions">20.00</td>
                                        <td class="taskOptions">20.00</td>
                                        <td class="taskOptions">20.00</td>
                                        <td class="taskOptions">20.00</td>
                                        <td class="taskOptions">20.00</td>
                                    </tr>
                                    <tr>
                                        <td class="taskOptions">课后一小时</td>
                                        <td class="taskOptions">20.00</td>
                                        <td class="taskOptions">20.00</td>
                                        <td class="taskOptions">20.00</td>
                                        <td class="taskOptions">20.00</td>
                                        <td class="taskOptions">20.00</td>
                                        <td class="taskOptions">20.00</td>
                                        <td class="taskOptions">20.00</td>
                                        <td class="taskOptions">20.00</td>
                                        <td class="taskOptions">20.00</td>
                                        <td class="taskOptions">20.00</td>
                                    </tr>

                                    <tr>
                                        <th class="taskOptions" rowspan='<?php echo count($count_sum); ?>'>合计</th>
                                    </tr>
<!--                                    <foreach name="count_sum"  item="c">-->
<!--                                        <tr>-->
<!--                                            <td class="taskOptions">--><?php //if($c['year_sum']==0 || $c['year_sum']==''){echo '0';}else{echo $c['year_sum'];?><!--</td>-->
<!--                                            <td class="taskOptions">--><?php //if($c['year_people_num']==0 || $c['year_people_num']==''){echo '0';}else{echo $c['year_people_num'];?><!--</td>-->
<!--                                            <td class="taskOptions">--><?php //if($c['year_income']==0 || $c['year_income']==''){echo '0';}else{echo $c['year_income'];?><!--</td>-->
<!--                                            <td class="taskOptions">--><?php //if($c['year_profit']==0 || $c['year_profit']==''){echo '0';}else{echo $c['year_profit'];?><!--</td>-->
<!--                                            <td class="taskOptions">--><?php //if($c['year_ratio']==0 || $c['year_ratio']==''){echo '0';}else{echo $c['year_ratio'];?><!--</td>-->
<!--                                            <td class="taskOptions">--><?php //if($c['month_sum']==0 || $c['month_sum']==''){echo '0';}else{echo $c['month_sum'];?><!--</td>-->
<!--                                            <td class="taskOptions">--><?php //if($c['month_people_num']==0 || $c['month_people_num']==''){echo '0';}else{echo $c['month_people_num'];?><!--</td>-->
<!--                                            <td class="taskOptions">--><?php //if($c['month_income']==0 || $c['month_income']==''){echo '0';}else{echo $c['month_income'];?><!--</td>-->
<!--                                            <td class="taskOptions">--><?php //if($c['month_profit']==0 || $c['month_profit']==''){echo '0';}else{echo $c['month_profit'];?><!--</td>-->
<!--                                            <td class="taskOptions">--><?php //if($c['month_ratio']==0 || $c['month_ratio']==''){echo '0';}else{echo $c['month_ratio'];?><!--</td>-->
<!--                                        </tr>-->
<!--                                    </foreach>-->
                                    <tr>
                                        <td class="taskOptions black" data="" rowspan="">合计</td>
                                        <td class="taskOptions black" data="">{$count_sum.yearxms}</td>
                                        <td class="taskOptions black" data="">{$count_sum.yearrenshu}</td>
                                        <td class="taskOptions black" data="">{$count_sum.yearzsr}</td>
                                        <td class="taskOptions black" data="">{$count_sum.yearzml}</td>
                                        <td class="taskOptions black" data="">{$count_sum.yearmll}</td>
                                        <td class="taskOptions black" data="">{$count_sum.monthxms}</td>
                                        <td class="taskOptions black" data="">{$count_sum.monthrenshu}</td>
                                        <td class="taskOptions black" data="">{$count_sum.monthzsr}</td>
                                        <td class="taskOptions black" data="">{$count_sum.monthzml}</td>
                                        <td class="taskOptions black" data="">{$count_sum.monthmll}</td>
                                    </tr>
                                </table>
                                </div><!-- /.box-body -->

                            </div><!-- /.box -->

                        </div><!-- /.col -->
                     </div>
                </section><!-- /.content -->
            </aside><!-- /.right-side -->
            


<include file="Index:footer2" />