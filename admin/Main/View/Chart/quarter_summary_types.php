<include file="Index:header2" />

            <aside class="right-side">
                <!-- Content Header (Page header) -->
                <section class="content-header">
                    <h1>
                        项目分部门分类型汇总（季度）
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
                                        <a href="{:U('Chart/quarter_summary_types',array('type'=>800,'year'=>$year,'quarter'=>$quarter))}" class="btn btn-sm <?php if($type==800){ echo 'btn-info';}else{ echo 'btn-a';} ?>">预算及结算分部门汇总</a>
                                        <a href="{:U('Chart/quarter_summary_types',array('type'=>801,'year'=>$year,'quarter'=>$quarter))}" class="btn btn-sm <?php if($type==801){ echo 'btn-info';}else{ echo 'btn-a';} ?>">已结算分部门汇总</a>
                                    </div>
                                </div><!-- /.box-header -->
                                <div class="box-body">
                                    <div class="btn-group" id="catfont" style="padding-bottom:5px;">
                                            <a href="{:U('Chart/quarter_summary_types',array('year'=>$prveyear,'quarter'=>$quarter,'type'=>$type))}" class="btn btn-default" style="padding:8px 18px;">上一年</a>

                                        <?php
                                            for($i=1;$i<5;$i++){
                                                if($quarter==$i){
                                                    echo '<a href="'.U('Chart/quarter_summary_types',array('year'=>$year,'quarter'=>$i,'type'=>$type)).'" class="btn btn-info" style="padding:8px 18px;">'.$i.'季度</a>';
                                                }else{
                                                    echo '<a href="'.U('Chart/quarter_summary_types',array('year'=>$year,'quarter'=>$i,'type'=>$type)).'" class="btn btn-default" style="padding:8px 18px;">'.$i.'季度</a>';
                                                }
                                            }
                                        ?>
                                            <a href="{:U('Chart/quarter_summary_types',array('year'=>$nextyear,'quarter'=>$quarter,'type'=>$type))}" class="btn btn-default" style="padding:8px 18px;">下一年</a>
                                    </div>

                                <table class="table table-bordered dataTable fontmini" id="tablelist" style="margin-top:10px;">
                                    <tr>
                                        <th class="sorting" style="text-align: center;" rowspan="2">部门</th>
                                        <th style="text-align: center;" rowspan="2">业务型态</th>
                                        <th colspan="5" style="text-align: center;">{$year}年累计</th>
                                        <th colspan="5" style="text-align: center;">{$quarter}季度累计</th>
                                    </tr>

                                    <tr>
                                        <td class="taskOptions">项目数</td>
                                        <td class="taskOptions">人数</td>
                                        <td class="taskOptions">收入合计</td>
                                        <td class="taskOptions">毛利合计</td>
                                        <td class="taskOptions">毛利率(%)</td>
                                        <td class="taskOptions">项目数</td>
                                        <td class="taskOptions">人数</td>
                                        <td class="taskOptions">收入合计</td>
                                        <td class="taskOptions">毛利合计</td>
                                        <td class="taskOptions">毛利率(%)</td>
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
                                                <td class="taskOptions">{$row['quarter_data'][$k]['quarterxms']?$row['quarter_data'][$k]['quarterxms']:0}</td>
                                                <td class="taskOptions">{$row['quarter_data'][$k]['quarterrenshu']?$row['quarter_data'][$k]['quarterrenshu']:0}</td>
                                                <td class="taskOptions">{$row['quarter_data'][$k]['quarterzsr']?$row['quarter_data'][$k]['quarterzsr']:0}</td>
                                                <td class="taskOptions">{$row['quarter_data'][$k]['quarterzml']?$row['quarter_data'][$k]['quarterzml']:0}</td>
                                                <td class="taskOptions">{$row['quarter_data'][$k]['quartermll']?$row['quarter_data'][$k]['quartermll']:0}</td>
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
                                            <td class="taskOptions">{$dijie['dj_quarter_data'][$kk]['quarterxms']?$dijie['dj_quarter_data'][$kk]['quarterxms']:0}</td>
                                            <td class="taskOptions">{$dijie['dj_quarter_data'][$kk]['quarterrenshu']?$dijie['dj_quarter_data'][$kk]['quarterrenshu']:0}</td>
                                            <td class="taskOptions">{$dijie['dj_quarter_data'][$kk]['quarterzsr']?$dijie['dj_quarter_data'][$kk]['quarterzsr']:0}</td>
                                            <td class="taskOptions">{$dijie['dj_quarter_data'][$kk]['quarterzml']?$dijie['dj_quarter_data'][$kk]['quarterzml']:0}</td>
                                            <td class="taskOptions">{$dijie['dj_quarter_data'][$kk]['quartermll']?$dijie['dj_quarter_data'][$kk]['quartermll']:0}</td>
                                        </tr>
                                        <?php } ?>

                                    <tr>
                                        <th class="taskOptions black" rowspan='<?php echo count($heji['year_data'])+1; ?>'>合计</th>
                                    </tr>
                                    <?php foreach ($heji['year_data'] as $kk=>$vv){ ?>
                                        <tr>
                                            <td class="taskOptions">{$kk}</td>
                                            <td class="taskOptions">{$vv.yearxms}</td>
                                            <td class="taskOptions">{$vv.yearrenshu}</td>
                                            <td class="taskOptions">{$vv.yearzsr}</td>
                                            <td class="taskOptions">{$vv.yearzml}</td>
                                            <td class="taskOptions">{$vv.yearmll}</td>
                                            <td class="taskOptions">{$heji['quarter_data'][$kk]['quarterxms']?$heji['quarter_data'][$kk]['quarterxms']:0}</td>
                                            <td class="taskOptions">{$heji['quarter_data'][$kk]['quarterrenshu']?$heji['quarter_data'][$kk]['quarterrenshu']:0}</td>
                                            <td class="taskOptions">{$heji['quarter_data'][$kk]['quarterzsr']?$heji['quarter_data'][$kk]['quarterzsr']:0}</td>
                                            <td class="taskOptions">{$heji['quarter_data'][$kk]['quarterzml']?$heji['quarter_data'][$kk]['quarterzml']:0}</td>
                                            <td class="taskOptions">{$heji['quarter_data'][$kk]['quartermll']?$heji['quarter_data'][$kk]['quartermll']:0}</td>
                                        </tr>
                                    <?php } ?>

                                    <tr class="taskOptions black">
                                        <td colspan="2">总合计</td>
                                        <td>{$sum.yearxms}</td>
                                        <td>{$sum.yearrenshu}</td>
                                        <td>{$sum.yearzsr}</td>
                                        <td>{$sum.yearzml}</td>
                                        <td>{$sum.yearmll}</td>
                                        <td>{$sum.quarterxms}</td>
                                        <td>{$sum.quarterrenshu}</td>
                                        <td>{$sum.quarterzsr}</td>
                                        <td>{$sum.quarterzml}</td>
                                        <td>{$sum.quartermll}</td>
                                    </tr>

                                </table>
                                </div><!-- /.box-body -->

                            </div><!-- /.box -->

                        </div><!-- /.col -->
                     </div>
                </section><!-- /.content -->
            </aside><!-- /.right-side -->
            


<include file="Index:footer2" />