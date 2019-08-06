<include file="Index:header2" />

            <aside class="right-side">
                <!-- Content Header (Page header) -->
                <section class="content-header">
                    <h1>
                        季度顾客满意度
                    </h1>
                    <ol class="breadcrumb">
                        <li><a href="{:U('Index/index')}"><i class="fa fa-home"></i> 首页</a></li>
                        <li><a href="javascript:;"><i class="fa fa-gift"></i> 顾客满意度</a></li>
                        <li class="active">顾客满意度统计</li>
                    </ol>
                </section>

                <!-- Main content -->
                <section class="content">

                    <div class="row">
                        <div class="col-xs-12">
                            <div class="box box-warning">
                                <div class="box-header">
                                    <h3 class="box-title">季度顾客满意度统计</h3>
                                    <!--<h3 class="box-title pull-right green">部门名称：{$department.department}</h3>-->
                                </div><!-- /.box-header -->
                                <div class="box-body">

                                    <!--<div class="btn-group" id="catfont" style="padding-bottom:5px;">
                                        <?php /*if($prveyear>2018){ */?>
                                            <a href="{:U('Inspect/public_score_statis_detail',array('year'=>$prveyear,'month'=>$month,'did'=>$department['id']))}" class="btn btn-default" style="padding:8px 18px;">上一年</a>
                                        <?php /*} */?>
                                        <?php
/*                                        for($i=1;$i<13;$i++){
                                            if($year.$month==$year.str_pad($i,2,"0",STR_PAD_LEFT)){
                                                echo '<a href="'.U('Inspect/public_score_statis_detail',array('year'=>$year,'month'=>$i,'did'=>$department['id'])).'" class="btn btn-info" style="padding:8px 18px;">'.$i.'月</a>';
                                            }else{
                                                echo '<a href="'.U('Inspect/public_score_statis_detail',array('year'=>$year,'month'=>$i,'did'=>$department['id'])).'" class="btn btn-default" style="padding:8px 18px;">'.$i.'月</a>';
                                            }
                                        }
                                        */?>
                                        <?php /*if($year<date('Y')){ */?>
                                            <a href="{:U('Inspect/public_score_statis_detail',array('year'=>$nextyear,'month'=>'01','did'=>$department['id']))}" class="btn btn-default" style="padding:8px 18px;">下一年</a>
                                        <?php /*} */?>
                                    </div>-->

                                <table class="table table-bordered dataTable fontmini" id="tablelist" style="margin-top:10px;">
                                    <tr>
                                        <th class="taskOptions">部门</th>
                                        <th class="taskOptions">姓名</th>
                                        <td class="taskOptions">项目数</td>
                                        <td class="taskOptions">已调查项目数</td>
                                        <td class="taskOptions">已调查满意度</td>
                                        <td class="taskOptions">总满意度</td>
                                    </tr>
                                    <foreach name="lists" item="row">
                                        <tr>
                                            <td class="taskOptions" rowspan="<?php echo $row['row_span_num']+1; ?>">{$row.department}</td>
                                            <td class="taskOptions"><a href="<?php echo U('Inspect/public_satisfied',array('year'=>$year,'month'=>date('m'),'uid'=>$row['info'][0]['userid'],'st'=>$startTime,'et'=>$endTime)) ?>">{$row['info'][0]['username']}</a></td>
                                            <td class="taskOptions">{$row['info'][0]['op_num']}</td>
                                            <td class="taskOptions">{$row['info'][0]['score_num']}</td>
                                            <td class="taskOptions">{$row['info'][0]['score_average']}</td>
                                            <td class="taskOptions">{$row['info'][0]['average']}</td>
                                        </tr>
                                        <?php for ($i=1;$i<=$row['row_span_num'];$i++){ ?>
                                            <?php if ($i==$row['row_span_num']){ ?>
                                            <tr class='black'>
                                                <td class="taskOptions"><a href="{:U('Inspect/score_statis',array('year'=>$year,'month'=>date('m')))}">{$row['info'][$i]['username']}</a></td>
                                            <?php }else{ ?>
                                            <tr>
                                                <td class="taskOptions"><a href="{:U('Inspect/public_satisfied',array('year'=>$year,'month'=>date('m'),'uid'=>$row['info'][$i]['userid'],'st'=>$startTime,'et'=>$endTime))}">{$row['info'][$i]['username']}</a></td>
                                            <?php }?>
                                            <td class="taskOptions">{$row['info'][$i]['op_num']}</td>
                                            <td class="taskOptions">{$row['info'][$i]['score_num']}</td>
                                            <td class="taskOptions">{$row['info'][$i]['score_average']}</td>
                                            <td class="taskOptions">{$row['info'][$i]['average']}</td>
                                        </tr>
                                        <?php } ?>
                                    </foreach>
                                    <tr class="black">
                                        <td class="taskOptions" colspan="2">总合计</td>
                                        <td class="taskOptions">{$sum['op_num']}</td>
                                        <td class="taskOptions">{$sum['score_num']}</td>
                                        <td class="taskOptions">{$sum['score_average']}</td>
                                        <td class="taskOptions">{$sum['average']}</td>
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
