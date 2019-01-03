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
                                        <a href="{:U('Chart/summary_types',array('type'=>$type))}" class="btn btn-sm <?php if($type==800){ echo 'btn-info';}else{ echo 'btn-a';} ?>">预算及结算分部门汇总</a>
                                        <a href="{:U('Chart/summary_types',array('type'=>$type))}" class="btn btn-sm <?php if($type==801){ echo 'btn-info';}else{ echo 'btn-a';} ?>">已结算分部门汇总</a>
                                    </div>
                                </div><!-- /.box-header -->
                                <div class="box-body">
                                    <div class="btn-group" id="catfont" style="padding-bottom:5px;">
                                            <a href="{:U('Chart/summary_types',array('year'=>$year,'month'=>$month,'statu'=>2,'type'=>$type))}" class="btn btn-default" style="padding:8px 18px;">上一年</a>

                                        <?php
                                        for($i=1;$i<13;$i++){
                                            if($month ==$i){

                                                echo '<a href="'.U('Chart/summary_types',array('year'=>$year,'month'=>$i,'type'=>$type)).'" class="btn btn-info" style="padding:8px 18px;">'.$i.'月</a>';
                                            }else{
                                                echo '<a href="'.U('Chart/summary_types',array('year'=>$year,'month'=>$i,'type'=>$type)).'" class="btn btn-default" style="padding:8px 18px;">'.$i.'月</a>';
                                            }
                                        }
                                        ?>
                                            <a href="{:U('Chart/summary_types',array('year'=>$year,'month'=>$month,'statu'=>1,'type'=>$type))}" class="btn btn-default" style="padding:8px 18px;">下一年</a>
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

                                    <foreach name="department"  item="dep">
                                        <tr>
                                            <th class="taskOptions" rowspan="<?php echo count($dep['name'])+1;?>">{$dep['department']}</th>
                                        </tr>
                                        <foreach name="dep['name']"  item="d">
                                        <tr>
                                            <td class="taskOptions"><?php if($d['type_name']==''){echo '';}else{echo $d['type_name'];}?></td>
                                            <td class="taskOptions"><?php if($d['year_sum']==''){echo '0';}else{echo $d['year_sum'];}?></td>
                                            <td class="taskOptions"><?php if($d['year_people_num']==''){echo '0';}else{echo $d['year_people_num'];}?></td>
                                            <td class="taskOptions">&yen; <?php if($d['year_income']==''){echo '0.00';}else{echo $d['year_income'];}?></td>
                                            <td class="taskOptions">&yen; <?php if($d['year_profit']==''){echo '0.00';}else{echo $d['year_profit'];}?></td>
                                            <td class="taskOptions"><?PHP echo sprintf("%.2f",($d['year_profit']/$d['year_income'])*100);?> %</td>

                                            <td class="taskOptions"><?php if($d['month_sum']==''){echo '0';}else{echo $d['month_sum'];}?></td>
                                            <td class="taskOptions"><?php if($d['month_people_num']==''){echo '0';}else{echo $d['month_people_num'];}?></td>
                                            <td class="taskOptions">&yen; <?php if($d['month_income']==''){echo '0.00';}else{echo $d['month_income'];}?></td>
                                            <td class="taskOptions">&yen; <?php if($d['month_profit']==''){echo '0.00';}else{echo $d['month_profit'];}?></td>
                                            <td class="taskOptions"><?PHP echo sprintf("%.2f",($d['month_profit']/$d['month_income'])*100);?> %</td>

                                        </tr>
                                        </foreach>

                                    </foreach>

                                        <tr>
                                            <th class="taskOptions" rowspan='<?php echo count($count_sum['name'])+1; ?>'>{$count_sum['nickname']}</th>
                                        </tr>
                                        <foreach name="count_sum['name']"  item="c">
                                        <tr>
                                            <td class="taskOptions"><?php if($c['type_name']==''){echo '';}else{echo $c['type_name'];}?></td>
                                            <td class="taskOptions"><?php if($c['year_sum']==''){echo '0';}else{echo $c['year_sum'];}?></td>
                                            <td class="taskOptions"><?php if($c['year_people_num']==''){echo '0';}else{echo $c['year_people_num'];}?></td>
                                            <td class="taskOptions">&yen; <?php if($c['year_income']==''){echo '0.00';}else{echo $c['year_income'];}?></td>
                                            <td class="taskOptions">&yen; <?php if($c['year_profit']==''){echo '0.00';}else{echo $c['year_profit'];}?></td>
                                            <td class="taskOptions"><?PHP echo sprintf("%.2f",($c['year_profit']/$c['year_income'])*100);?> %</td>


                                            <td class="taskOptions"><?php if($c['month_sum']==''){echo '0';}else{echo $c['month_sum'];}?></td>
                                            <td class="taskOptions"><?php if($c['month_people_num']==''){echo '0';}else{echo $c['month_people_num'];}?></td>
                                            <td class="taskOptions">&yen; <?php if($c['month_income']==''){echo '0.00';}else{echo $c['month_income'];}?></td>
                                            <td class="taskOptions">&yen; <?php if($c['month_profit']==''){echo '0.00';}else{echo $c['month_profit'];}?></td>
                                            <td class="taskOptions"><?PHP echo sprintf("%.2f",($c['month_profit']/$c['month_income'])*100);?> %</td>
                                        </tr>
                                        </foreach>

                                </table>
                                </div><!-- /.box-body -->

                            </div><!-- /.box -->

                        </div><!-- /.col -->
                     </div>
                </section><!-- /.content -->
            </aside><!-- /.right-side -->
            


<include file="Index:footer2" />