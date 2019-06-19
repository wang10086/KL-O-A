<include file="Index:header2" />

            <aside class="right-side">
                <!-- Content Header (Page header) -->
                <section class="content-header">
                    <h1>
                        {$_action_}<small>计调</small>
                    </h1>
                    <ol class="breadcrumb">
                        <li><a href="{:U('Index/index')}"><i class="fa fa-home"></i> 首页</a></li>
                        <li><a href="javascript:;"><i class="fa fa-gift"></i> {$_action_}</a></li>
                        <li class="active">计调满意度统计</li>
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
                                            <a href="{:U('Sale/satisfaction',array('year'=>$prveyear,'month'=>$month))}" class="btn btn-default" style="padding:8px 18px;">上一年</a>
                                        <?php } ?>
                                        <?php
                                        for($i=1;$i<13;$i++){
                                            if($year.$month==$year.str_pad($i,2,"0",STR_PAD_LEFT)){
                                                echo '<a href="'.U('Sale/satisfaction',array('year'=>$year,'month'=>$i)).'" class="btn btn-info" style="padding:8px 18px;">'.$i.'月</a>';
                                            }else{
                                                echo '<a href="'.U('Sale/satisfaction',array('year'=>$year,'month'=>$i)).'" class="btn btn-default" style="padding:8px 18px;">'.$i.'月</a>';
                                            }
                                        }
                                        ?>
                                        <?php if($year<date('Y')){ ?>
                                            <a href="{:U('Sale/satisfaction',array('year'=>$nextyear,'month'=>'01'))}" class="btn btn-default" style="padding:8px 18px;">下一年</a>
                                        <?php } ?>
                                    </div>

                                <table class="table table-bordered dataTable fontmini" id="tablelist" style="margin-top:10px;">
                                    <tr>
                                        <th class="sorting" style="text-align: center;">姓名</th>
                                        <td class="taskOptions" data="">项目数</td>
                                        <td class="taskOptions" data="">已调查项目数</td>
                                        <td class="taskOptions" data="">已调查满意度</td>
                                        <td class="taskOptions" data="">总满意度</td>
                                    </tr>
                                    <foreach name="lists" item="row"> 
                                    <tr>
                                        <td class="taskOptions"></td>
                                        <td class="taskOptions">{$row.month_op_num}</td>
                                        <td class="taskOptions">{$row.month_score_num}</td>
                                        <td class="taskOptions">{$row.month_score_average}</td>
                                        <td class="taskOptions">{$row.month_average}</td>
                                    </tr>
                                    </foreach>
                                    <tr class="black">
                                        <td class="taskOptions" data="">合计</td>
                                        <td class="taskOptions">{$company.month_op_num}</td>
                                        <td class="taskOptions">{$company.month_score_num}</td>
                                        <td class="taskOptions">{$company.month_score_average}</td>
                                        <td class="taskOptions">{$company.month_average}</td>
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
