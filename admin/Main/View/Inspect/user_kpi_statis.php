<include file="Index:header2" />

            <aside class="right-side">
                <!-- Content Header (Page header) -->
                <section class="content-header">
                    <h1>
                        顾客满意度分项统计
                    </h1>
                    <ol class="breadcrumb">
                        <li><a href="{:U('Index/index')}"><i class="fa fa-home"></i> 首页</a></li>
                        <li><a href="javascript:;"><i class="fa fa-gift"></i> 顾客满意度</a></li>
                        <li class="active">顾客满意度分项统计</li>
                    </ol>
                </section>

                <!-- Main content -->
                <section class="content">

                    <div class="row">
                        <div class="col-xs-12">
                            <div class="box box-warning">
                                <div class="box-header">
                                    <!--<h3 class="box-title">顾客满意度分项统计</h3>-->
                                    <div class="box-tools btn-group" id = "chart_btn_group">
                                        <a href="{:U('Inspect/user_kpi_statis',array('year'=>$year,'month'=>$month,'ut'=>'jd'))}" class="btn btn-sm <?php if($usertype=='jd'){ echo 'btn-info';}else{ echo 'btn-group-header';} ?>">计调满意度汇总</a>
                                        <a href="{:U('Inspect/user_kpi_statis',array('year'=>$year,'month'=>$month,'ut'=>'yf'))}" class="btn btn-sm <?php if($usertype=='yf'){ echo 'btn-info';}else{ echo 'btn-group-header';} ?>">研发满意度汇总</a>
                                        <a href="{:U('Inspect/user_kpi_statis',array('year'=>$year,'month'=>$month,'ut'=>'zy'))}" class="btn btn-sm <?php if($usertype=='zy'){ echo 'btn-info';}else{ echo 'btn-group-header';} ?>">资源满意度汇总</a>
                                    </div>
                                </div><!-- /.box-header -->
                                <div class="box-body">

                                    <div class="btn-group" id="catfont" style="padding-bottom:5px;">
                                        <?php if($prveyear>2018){ ?>
                                            <a href="{:U('Inspect/user_kpi_statis',array('year'=>$prveyear,'month'=>$month,'ut'=>$usertype))}" class="btn btn-default" style="padding:8px 18px;">上一年</a>
                                        <?php } ?>
                                        <?php
                                        for($i=1;$i<13;$i++){
                                            if($year.$month==$year.str_pad($i,2,"0",STR_PAD_LEFT)){
                                                echo '<a href="'.U('Inspect/user_kpi_statis',array('year'=>$year,'month'=>$i,'ut'=>$usertype)).'" class="btn btn-info" style="padding:8px 18px;">'.$i.'月</a>';
                                            }else{
                                                echo '<a href="'.U('Inspect/user_kpi_statis',array('year'=>$year,'month'=>$i,'ut'=>$usertype)).'" class="btn btn-default" style="padding:8px 18px;">'.$i.'月</a>';
                                            }
                                        }
                                        ?>
                                        <?php if($year<date('Y')){ ?>
                                            <a href="{:U('Inspect/user_kpi_statis',array('year'=>$nextyear,'month'=>'01','ut'=>$usertype))}" class="btn btn-default" style="padding:8px 18px;">下一年</a>
                                        <?php } ?>
                                    </div>

                                <table class="table table-bordered dataTable fontmini" id="tablelist" style="margin-top:10px;">
                                    <tr>
                                        <th class="sorting" style="text-align: center;" rowspan="2">部门</th>
                                        <th colspan="4" style="text-align: center;">{$year}年累计</th>
                                        <th colspan="4" style="text-align: center;">{$month}月累计</th>
                                    </tr>
                                    <tr>
                                        <td class="taskOptions" data="">项目数</td>
                                        <td class="taskOptions" data="">已调查项目数</td>
                                        <td class="taskOptions" data="">已调查满意度</td>
                                        <td class="taskOptions" data="">总满意度</td>
                                        <td class="taskOptions" data="">项目数</td>
                                        <td class="taskOptions" data="">已调查项目数</td>
                                        <td class="taskOptions" data="">已调查满意度</td>
                                        <td class="taskOptions" data="">总满意度</td>
                                    </tr>
                                    <foreach name="lists" item="row"> 
                                    <tr>
                                        <td class="taskOptions"><a href="{:U('Inspect/public_user_kpi_statis_detail',array('year'=>$year,'month'=>$month,'did'=>$row['department_id'],'ut'=>$usertype))}" title="查看部门详情">{$row.department}</a></td>
                                        <td class="taskOptions">{$row.year_op_num}</td>
                                        <td class="taskOptions">{$row.year_score_num}</td>
                                        <td class="taskOptions">{$row.year_score_average}</td>
                                        <td class="taskOptions">{$row.year_average}</td>
                                        <td class="taskOptions">{$row.month_op_num}</td>
                                        <td class="taskOptions">{$row.month_score_num}</td>
                                        <td class="taskOptions">{$row.month_score_average}</td>
                                        <td class="taskOptions">{$row.month_average}</td>
                                    </tr>
                                    </foreach>
                                    <tr class="black">
                                        <td class="taskOptions" data="">公司</td>
                                        <td class="taskOptions">{$company.year_op_num}</td>
                                        <td class="taskOptions">{$company.year_score_num}</td>
                                        <td class="taskOptions">{$company.year_score_average}</td>
                                        <td class="taskOptions">{$company.year_average}</td>
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
