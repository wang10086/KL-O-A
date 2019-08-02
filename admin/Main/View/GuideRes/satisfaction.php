<include file="Index:header2" />

            <aside class="right-side">
                <!-- Content Header (Page header) -->
                <section class="content-header">
                    <h1>
                        {$_action_}<small>教务</small>
                    </h1>
                    <ol class="breadcrumb">
                        <li><a href="{:U('Index/index')}"><i class="fa fa-home"></i> 首页</a></li>
                        <li><a href="javascript:;"><i class="fa fa-gift"></i> {$_action_}</a></li>
                        <li class="active">教务满意度统计</li>
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
                                            <a href="{:U('GuideRes/satisfaction',array('year'=>$prveyear,'month'=>$month))}" class="btn btn-default" style="padding:8px 18px;">上一年</a>
                                        <?php } ?>
                                        <?php
                                        for($i=1;$i<13;$i++){
                                            if($year.$month==$year.str_pad($i,2,"0",STR_PAD_LEFT)){
                                                echo '<a href="'.U('GuideRes/satisfaction',array('year'=>$year,'month'=>$i)).'" class="btn btn-info" style="padding:8px 18px;">'.$i.'月</a>';
                                            }else{
                                                echo '<a href="'.U('GuideRes/satisfaction',array('year'=>$year,'month'=>$i)).'" class="btn btn-default" style="padding:8px 18px;">'.$i.'月</a>';
                                            }
                                        }
                                        ?>
                                        <?php if($year<date('Y')){ ?>
                                            <a href="{:U('GuideRes/satisfaction',array('year'=>$nextyear,'month'=>'01'))}" class="btn btn-default" style="padding:8px 18px;">下一年</a>
                                        <?php } ?>
                                    </div>

                                <table class="table table-bordered dataTable fontmini" id="tablelist" style="margin-top:10px;">
                                    <tr role="row">
                                        <th class="sorting" style="text-align: center;">姓名</th>
                                        <th class="taskOptions" data="">项目数</th>
                                        <th class="taskOptions" data="">已评分项目数</th>
                                        <th class="taskOptions" data="">已评分满意度</th>
                                        <th class="taskOptions" data="">总满意度</th>
                                    </tr>
                                    <foreach name="lists" item="row"> 
                                    <tr <?php if ($row['jd_name']=='合计') echo "class='black'"; ?>>
                                        <td class="taskOptions"><a href="{:U('GuideRes/public_jd_satisfaction_detail',array('year'=>$year,'month'=>$month,'jd_uid'=>$row['jd_uid'],'jd_name'=>$row['jd_name']))}">{$row.jd_name}</a></td>
                                        <td class="taskOptions">{$row.num}</td>
                                        <td class="taskOptions">{$row.score_num}</td>
                                        <td class="taskOptions">{$row.score_average}</td>
                                        <td class="taskOptions">{$row.sum_average}</td>
                                    </tr>
                                    </foreach>
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
