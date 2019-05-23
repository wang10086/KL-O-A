<include file="Index:header2" />

            <aside class="right-side">
                <!-- Content Header (Page header) -->
                <section class="content-header">
                    <h1>
                        项目分部门分类型汇总
                    </h1>
                    <ol class="breadcrumb">
                        <li><a href="{:U('Index/index')}"><i class="fa fa-home"></i> 首页</a></li>
                        <li><a href="javascript:;"><i class="fa fa-gift"></i> 数据统计</a></li>
                        <li class="active">项目分部门分类型汇总</li>
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
                                        <a href="{:U('Chart/summary_types',array('type'=>800,'year'=>$year,'month'=>$month))}" class="btn btn-sm <?php if($type==800){ echo 'btn-info';}else{ echo 'btn-a';} ?>">预算及结算分部门汇总</a>
                                        <a href="{:U('Chart/summary_types',array('type'=>801,'year'=>$year,'month'=>$month))}" class="btn btn-sm <?php if($type==801){ echo 'btn-info';}else{ echo 'btn-a';} ?>">已结算分部门汇总</a>
                                    </div>
                                </div><!-- /.box-header -->
                                <div class="box-body">
                                    <div class="btn-group" id="catfont" style="padding-bottom:5px;">
                                            <a href="{:U('Chart/summary_types',array('year'=>$prveyear,'month'=>$month,'type'=>$type))}" class="btn btn-default" style="padding:8px 18px;">上一年</a>

                                        <?php
                                        for($i=1;$i<13;$i++){
                                            if (strlen($i)<2){ $i = str_pad($i,2,'0',STR_PAD_LEFT); }
                                            if($month ==$i){

                                                echo '<a href="'.U('Chart/summary_types',array('year'=>$year,'month'=>$i,'type'=>$type)).'" class="btn btn-info" style="padding:8px 18px;">'.$i.'月</a>';
                                            }else{
                                                echo '<a href="'.U('Chart/summary_types',array('year'=>$year,'month'=>$i,'type'=>$type)).'" class="btn btn-default" style="padding:8px 18px;">'.$i.'月</a>';
                                            }
                                        }
                                        ?>
                                            <a href="{:U('Chart/summary_types',array('year'=>$nextyear,'month'=>$month,'type'=>$type))}" class="btn btn-default" style="padding:8px 18px;">下一年</a>
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

                                    <foreach name="lists"  item="row">
                                        <tr>
                                            <td class="taskOptions" rowspan="<?php echo count($row['year_data'])+1; ?>">{$row.depname}</td>
                                        </tr>
                                        <?php foreach ($row['year_data'] as $k=>$v){ ?>
                                            <tr>
                                                <td class="taskOptions">{$k}</td>
                                                <td class="taskOptions">{$v.yearxms}</td>
                                                <td class="taskOptions">{$v.yearrenshu}</td>
                                                <td class="taskOptions">{$v.yearzsr}</td>
                                                <td class="taskOptions">{$v.yearzml}</td>
                                                <td class="taskOptions">{$v.yearmll}</td>
                                                <td class="taskOptions">{$row['month_data'][$k]['monthxms']?$row['month_data'][$k]['monthxms']:0}</td>
                                                <td class="taskOptions">{$row['month_data'][$k]['monthrenshu']?$row['month_data'][$k]['monthrenshu']:0}</td>
                                                <td class="taskOptions">{$row['month_data'][$k]['monthzsr']?$row['month_data'][$k]['monthzsr']:0}</td>
                                                <td class="taskOptions">{$row['month_data'][$k]['monthzml']?$row['month_data'][$k]['monthzml']:0}</td>
                                                <td class="taskOptions">{$row['month_data'][$k]['monthmll']?$row['month_data'][$k]['monthmll']:'0%'}</td>
                                            </tr>
                                        <?php } ?>
                                    </foreach>

                                        <tr>
                                            <th class="taskOptions black" rowspan='<?php echo count($dijie['dj_year_data'])+1; ?>'>地接合计</th>
                                        </tr>
                                        <?php foreach ($dijie['dj_year_data'] as $kk=>$vv){ ?>
                                        <tr>
                                            <td class="taskOptions">{$kk}</td>
                                            <td class="taskOptions">{$vv.yearxms}</td>
                                            <td class="taskOptions">{$vv.yearrenshu}</td>
                                            <td class="taskOptions">{$vv.yearzsr}</td>
                                            <td class="taskOptions">{$vv.yearzml}</td>
                                            <td class="taskOptions">{$vv.yearmll}</td>
                                            <td class="taskOptions">{$dijie['dj_month_data'][$kk]['monthxms']?$dijie['dj_month_data'][$kk]['monthxms']:0}</td>
                                            <td class="taskOptions">{$dijie['dj_month_data'][$kk]['monthrenshu']?$dijie['dj_month_data'][$kk]['monthrenshu']:0}</td>
                                            <td class="taskOptions">{$dijie['dj_month_data'][$kk]['monthzsr']?$dijie['dj_month_data'][$kk]['monthzsr']:0}</td>
                                            <td class="taskOptions">{$dijie['dj_month_data'][$kk]['monthzml']?$dijie['dj_month_data'][$kk]['monthzml']:0}</td>
                                            <td class="taskOptions">{$dijie['dj_month_data'][$kk]['monthmll']?$dijie['dj_month_data'][$kk]['monthmll']:'0%'}</td>
                                        </tr>
                                        <?php } ?>

                                </table>
                                </div><!-- /.box-body -->

                            </div><!-- /.box -->

                        </div><!-- /.col -->
                     </div>
                </section><!-- /.content -->
            </aside><!-- /.right-side -->
            


<include file="Index:footer2" />