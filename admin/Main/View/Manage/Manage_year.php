<include file="Index:header2" />
<style>
    #btn-default_1{
        background-color:#00acd6;
    }

    th{
        text-align:center;
    }
    td input{
        text-align:center;
    }
</style>
<aside class="right-side">

    <section class="content-header">
        <h1><?php echo $year;?>年度经营报表</h1>
        <ol class="breadcrumb">
            <li><a href="{:U('Index/index')}"><i class="fa fa-home"></i> 首页</a></li>
            <li><a href="{:U('Manage/Manage_year')}"><i class="fa fa-gift"></i> 年度经营报表</a></li>
        </ol>
    </section>

    <!-- Main content -->
    <section class="content">

        <div class="row">
            <!-- right column -->
            <div class="col-md-12">
                <div class="btn-group" id="catfont" style="padding-bottom:20px;">
                    <a href="{:U('Manage/Manage_year',array('year'=>$year-1,'post'=>1))}" class="btn btn-default" id="<?php if($post==1){echo 'btn-default_1';}?>" style="padding:8px 18px;">上一年</a>
                    <a href="{:U('Manage/Manage_year',array('year'=>$year+1,'post'=>2))}" class="btn btn-default" id="<?php if($post==2){echo 'btn-default_1';}?>" style="padding:8px 18px;">下一年</a>
                </div>

                <div class="box box-warning">
                    <div class="box-header">
                        <h3 class="box-title">年度预算报表</h3>
                        <!--<if condition="rolemenu(array('Manage/Manage_input'))" class="{:on('Manage/Manage_input')}">
                            <div class="box-header">
                                <a class="btn btn-info btn-sm" href="{:U('Manage/Manage_input')}" style="float:right;margin:1em 2em 0em 0em;background-color:#398439;"><b>+</b>预算录入</a>
                            </div>
                        </if>-->
                        <if condition="rolemenu(array('Manage/Manage_quarter_w'))">
                            <div class="box-header">
                                <a class="btn btn-info btn-sm" href="{:U('Manage/Manage_quarter_w',array('year'=>$year,'type'=>5))}" style="float:right;margin:1em 2em 0em 0em;background-color:#398439;"><b>+</b>预算录入</a>
                            </div>
                        </if>
                    </div><!-- /.box-header -->
                    <div class="box-body">
                        <table class="table table-bordered dataTable fontmini">
                            <tr>
                                <th class="black taskOptions">项目</th>
                                <foreach name="departments" item="v">
                                    <th class="black taskOptions">{$v}</th>
                                </foreach>
                            </tr>
                            <tr>
                                <td class="taskOptions">员工人数</td>
                                <foreach name="departments" item="v">
                                    <td class="taskOptions">
                                        <?php foreach ($manage as $value){
                                            if ($value['logged_department'] == $v){
                                                echo $value['employees_number'].' 人';
                                            }
                                        } ?>
                                    </td>
                                </foreach>
                            </tr>
                            <tr>
                                <td class="taskOptions">营业收入</td>
                                <foreach name="departments" item="v">
                                    <td class="taskOptions">
                                        <?php foreach ($manage as $value){
                                            if ($value['logged_department'] == $v){
                                                echo '&yen;'.$value['logged_income'];
                                            }
                                        } ?>
                                    </td>
                                </foreach>
                            </tr>
                            <tr>
                                <td class="taskOptions">营业毛利</td>
                                <foreach name="departments" item="v">
                                    <td class="taskOptions">
                                        <?php foreach ($manage as $value){
                                            if ($value['logged_department'] == $v){
                                                echo '&yen;'.$value['logged_profit'];
                                            }
                                        } ?>
                                    </td>
                                </foreach>
                            </tr>
                            <tr>
                                <td class="taskOptions">营业毛利率(%)</td>
                                <foreach name="departments" item="v">
                                    <td class="taskOptions">
                                        <?php foreach ($manage as $value){
                                            if ($value['logged_department'] == $v){
                                                echo $value['logged_rate'].'%';
                                            }
                                        } ?>
                                    </td>
                                </foreach>
                            </tr>
                            <tr>
                                <td class="taskOptions">人力资源成本</td>
                                <foreach name="departments" item="v">
                                    <td class="taskOptions">
                                        <?php foreach ($manage as $value){
                                            if ($value['logged_department'] == $v){
                                                echo '&yen;'.$value['manpower_cost'];
                                            }
                                        } ?>
                                    </td>
                                </foreach>
                            <tr>
                                <td class="taskOptions">其他费用</td>
                                <foreach name="departments" item="v">
                                    <td class="taskOptions">
                                        <?php foreach ($manage as $value){
                                            if ($value['logged_department'] == $v){
                                                echo '&yen;'.$value['other_expenses'];
                                            }
                                        } ?>
                                    </td>
                                </foreach>
                            </tr>
                            <tr>
                                <td class="taskOptions">利润总额</td>
                                <foreach name="departments" item="v">
                                    <td class="taskOptions">
                                        <?php foreach ($manage as $value){
                                            if ($value['logged_department'] == $v){
                                                echo '&yen;'.$value['total_profit'];
                                            }
                                        } ?>
                                    </td>
                                </foreach>
                            </tr>
                            <tr>
                                <td class="taskOptions">目标利润</td>
                                <foreach name="departments" item="v">
                                    <td class="taskOptions">
                                        <?php foreach ($manage as $value){
                                            if ($value['logged_department'] == $v){
                                                echo '&yen;'.$value['target_profit'];
                                            }
                                        } ?>
                                    </td>
                                </foreach>
                            </tr>
                            <tr>
                                <td class="taskOptions">人事费用率(%)</td>
                                <foreach name="departments" item="v">
                                    <td class="taskOptions">
                                        <?php foreach ($manage as $value){
                                            if ($value['logged_department'] == $v){
                                                echo $value['personnel_cost_rate'].'%';
                                            }
                                        } ?>
                                    </td>
                                </foreach>
                            </tr>
                            <tr>
                                <td class="taskOptions">状态</td>
                                <foreach name="departments" item="v">
                                    <td class="taskOptions">
                                        <?php foreach ($manage as $value){
                                            if ($value['logged_department'] == $v){
                                                if ($value['statu']==4) echo "审批通过";
                                            }
                                        } ?>
                                    </td>
                                </foreach>
                            </tr>
                        </table><br><br>

                    </div><!-- /.box-body -->
                </div>

                    <div class="box box-warning">
                        <div class="box-header">
                            <h3 class="box-title">年度经营报表</h3>
                        </div><!-- /.box-header -->
                        <div class="box-body">

                            <table class="table table-bordered dataTable fontmini" id="tablecenter">
                                <tr role="row" class="orders" style="text-align:center;" >
                                    <th style="width:10em;" ><b>项目</b></th>
                                    <th style="width:10em;" ><b>公司</b></th>
                                    <th style="width:10em;" ><b>京区业务中心</b></th>
                                    <th style="width:10em;" ><b>京外业务中心</b></th>
                                    <th style="width:10em;" ><b>南京项目部</b></th>
                                    <th style="width:10em;" ><b>武汉项目部</b></th>
                                    <th style="width:10em;" ><b>沈阳项目部</b></th>
                                    <th style="width:10em;" ><b>长春项目部</b></th>
                                    <th style="width:10em;" ><b>市场部(业务)</b></th>
                                    <th style="width:10em;" ><b>常规业务中心</b></th>
                                    <th style="width:10em;" ><b>机关部门</b></th>
                                </tr>
                                <tr role="row" class="orders" style="text-align:center;">
                                    <td>员工人数</td>
                                    <td><?php echo $number['公司']?$number['公司']:0; ?>（人)</td>
                                    <td><?php echo $number['京区业务中心']?$number['京区业务中心']:0; ?>（人)</td>
                                    <td><?php echo $number['京外业务中心']?$number['京外业务中心']:0; ?>（人)</td>
                                    <td><?php echo $number['南京项目部']?$number['南京项目部']:0; ?>（人)</td>
                                    <td><?php echo $number['武汉项目部']?$number['武汉项目部']:0; ?>（人)</td>
                                    <td><?php echo $number['沈阳项目部']?$number['沈阳项目部']:0; ?>（人)</td>
                                    <td><?php echo $number['长春项目部']?$number['长春项目部']:0; ?>（人)</td>
                                    <td><?php echo $number['市场部']?$number['市场部']:0; ?>（人)</td>
                                    <td><?php echo $number['常规业务中心']?$number['常规业务中心']:0; ?>（人)</td>
                                    <td><?php echo $number['机关部门']?$number['机关部门']:0; ?>（人)</td>
                                </tr>
                                <tr role="row" class="orders" style="text-align:center;">
                                    <td>营业收入</td>
                                    <td>&yen; <?php echo $profit['公司']['monthzsr']?$profit['公司']['monthzsr']:'0.00'; ?></td>
                                    <td>&yen; <?php echo $profit['京区业务中心']['monthzsr']?$profit['京区业务中心']['monthzsr']:'0.00'; ?></td>
                                    <td>&yen; <?php echo $profit['京外业务中心']['monthzsr']?$profit['京外业务中心']['monthzsr']:'0.00'; ?></td>
                                    <td>&yen; <?php echo $profit['南京项目部']['monthzsr']?$profit['南京项目部']['monthzsr']:'0.00'; ?></td>
                                    <td>&yen; <?php echo $profit['武汉项目部']['monthzsr']?$profit['武汉项目部']['monthzsr']:'0.00'; ?></td>
                                    <td>&yen; <?php echo $profit['沈阳项目部']['monthzsr']?$profit['沈阳项目部']['monthzsr']:'0.00'; ?></td>
                                    <td>&yen; <?php echo $profit['长春项目部']['monthzsr']?$profit['长春项目部']['monthzsr']:'0.00'; ?></td>
                                    <td>&yen; <?php echo $profit['市场部']['monthzsr']?$profit['市场部']['monthzsr']:'0.00'; ?></td>
                                    <td>&yen; <?php echo $profit['常规业务中心']['monthzsr']?$profit['常规业务中心']['monthzsr']:'0.00'; ?></td>
                                    <td>&yen; <?php echo $profit['机关部门']['monthzsr']?$profit['机关部门']['monthzsr']:'0.00'; ?></td>
                                </tr>
                                <tr role="row" class="orders" style="text-align:center;">
                                    <td>营业毛利</td>
                                    <td>&yen; <?php echo $profit['公司']['monthzml']?$profit['公司']['monthzml']:'0.00'; ?></td>
                                    <td>&yen; <?php echo $profit['京区业务中心']['monthzml']?$profit['京区业务中心']['monthzml']:'0.00'; ?></td>
                                    <td>&yen; <?php echo $profit['京外业务中心']['monthzml']?$profit['京外业务中心']['monthzml']:'0.00'; ?></td>
                                    <td>&yen; <?php echo $profit['南京项目部']['monthzml']?$profit['南京项目部']['monthzml']:'0.00'; ?></td>
                                    <td>&yen; <?php echo $profit['武汉项目部']['monthzml']?$profit['武汉项目部']['monthzml']:'0.00'; ?></td>
                                    <td>&yen; <?php echo $profit['沈阳项目部']['monthzml']?$profit['沈阳项目部']['monthzml']:'0.00'; ?></td>
                                    <td>&yen; <?php echo $profit['长春项目部']['monthzml']?$profit['长春项目部']['monthzml']:'0.00'; ?></td>
                                    <td>&yen; <?php echo $profit['市场部']['monthzml']?$profit['市场部']['monthzml']:'0.00'; ?></td>
                                    <td>&yen; <?php echo $profit['常规业务中心']['monthzml']?$profit['常规业务中心']['monthzml']:'0.00'; ?></td>
                                    <td>&yen; <?php echo $profit['机关部门']['monthzml']?$profit['机关部门']['monthzml']:'0.00'; ?></td>
                                </tr>
                                <tr role="row" class="orders" style="text-align:center;">
                                    <td>营业毛利率(%)</td>
                                    <td><?php echo $profit['公司']['monthmll']?$profit['公司']['monthmll']:'0.00'; ?> %</td>
                                    <td><?php echo $profit['京区业务中心']['monthmll']?$profit['京区业务中心']['monthmll']:'0.00'; ?> %</td>
                                    <td><?php echo $profit['京外业务中心']['monthmll']?$profit['京外业务中心']['monthmll']:'0.00'; ?> %</td>
                                    <td><?php echo $profit['南京项目部']['monthmll']?$profit['南京项目部']['monthmll']:'0.00'; ?> %</td>
                                    <td><?php echo $profit['武汉项目部']['monthmll']?$profit['武汉项目部']['monthmll']:'0.00'; ?> %</td>
                                    <td><?php echo $profit['沈阳项目部']['monthmll']?$profit['沈阳项目部']['monthmll']:'0.00'; ?> %</td>
                                    <td><?php echo $profit['长春项目部']['monthmll']?$profit['长春项目部']['monthmll']:'0.00'; ?> %</td>
                                    <td><?php echo $profit['市场部']['monthmll']?$profit['市场部']['monthmll']:'0.00'; ?> %</td>
                                    <td><?php echo $profit['常规业务中心']['monthmll']?$profit['常规业务中心']['monthmll']:'0.00'; ?> %</td>
                                    <td><?php echo $profit['机关部门']['monthmll']?$profit['机关部门']['monthmll']:'0.00'; ?> %</td>
                                </tr>
                                <tr role="row" class="orders" style="text-align:center;">
                                    <td>人力资源成本</td>
                                    <td>&yen; <a href="{:U('Manage/HR_cost',array('year'=>$year,'month'=>$month,'tm'=>'y'))}"> <?php echo $hr_cost['公司']?$hr_cost['公司']:'0.00'; ?> </a></td>
                                    <td>&yen; <a href="{:U('Manage/HR_cost',array('year'=>$year,'month'=>$month,'tm'=>'y'))}"> <?php echo $hr_cost['京区业务中心']?$hr_cost['京区业务中心']:'0.00'; ?> </a></td>
                                    <td>&yen; <a href="{:U('Manage/HR_cost',array('year'=>$year,'month'=>$month,'tm'=>'y'))}"> <?php echo $hr_cost['京外业务中心']?$hr_cost['京外业务中心']:'0.00'; ?> </a></td>
                                    <td>&yen; <a href="{:U('Manage/HR_cost',array('year'=>$year,'month'=>$month,'tm'=>'y'))}"> <?php echo $hr_cost['南京项目部']?$hr_cost['南京项目部']:'0.00'; ?> </a></td>
                                    <td>&yen; <a href="{:U('Manage/HR_cost',array('year'=>$year,'month'=>$month,'tm'=>'y'))}"> <?php echo $hr_cost['武汉项目部']?$hr_cost['武汉项目部']:'0.00'; ?> </a></td>
                                    <td>&yen; <a href="{:U('Manage/HR_cost',array('year'=>$year,'month'=>$month,'tm'=>'y'))}"> <?php echo $hr_cost['沈阳项目部']?$hr_cost['沈阳项目部']:'0.00'; ?> </a></td>
                                    <td>&yen; <a href="{:U('Manage/HR_cost',array('year'=>$year,'month'=>$month,'tm'=>'y'))}"> <?php echo $hr_cost['长春项目部']?$hr_cost['长春项目部']:'0.00'; ?> </a></td>
                                    <td>&yen; <a href="{:U('Manage/HR_cost',array('year'=>$year,'month'=>$month,'tm'=>'y'))}"> <?php echo $hr_cost['市场部']?$hr_cost['市场部']:'0.00'; ?> </a></td>
                                    <td>&yen; <a href="{:U('Manage/HR_cost',array('year'=>$year,'month'=>$month,'tm'=>'y'))}"> <?php echo $hr_cost['常规业务中心']?$hr_cost['常规业务中心']:'0.00'; ?> </a></td>
                                    <td>&yen; <a href="{:U('Manage/HR_cost',array('year'=>$year,'month'=>$month,'tm'=>'y'))}"> <?php echo $hr_cost['机关部门']?$hr_cost['机关部门']:'0.00'; ?> </a></td>
                                </tr>
                                <tr role="row" class="orders" style="text-align:center;">
                                    <td>其他费用</td>
                                    <td>&yen; <a href="{:U('Manage/otherExpenses',array('year'=>$year,'month'=>$month,'tm'=>'y'))}"> <?php echo $department['公司']['money']?$department['公司']['money']:'0.00'; ?> </a></td>
                                    <td>&yen; <a href="{:U('Manage/otherExpenses',array('year'=>$year,'month'=>$month,'tm'=>'y'))}"> <?php echo $department['京区业务中心']['money']?$department['京区业务中心']['money']:'0.00'; ?> </a></td>
                                    <td>&yen; <a href="{:U('Manage/otherExpenses',array('year'=>$year,'month'=>$month,'tm'=>'y'))}"> <?php echo $department['京外业务中心']['money']?$department['京外业务中心']['money']:'0.00'; ?> </a></td>
                                    <td>&yen; <a href="{:U('Manage/otherExpenses',array('year'=>$year,'month'=>$month,'tm'=>'y'))}"> <?php echo $department['南京项目部']['money']?$department['南京项目部']['money']:'0.00'; ?> </a></td>
                                    <td>&yen; <a href="{:U('Manage/otherExpenses',array('year'=>$year,'month'=>$month,'tm'=>'y'))}"> <?php echo $department['武汉项目部']['money']?$department['武汉项目部']['money']:'0.00'; ?> </a></td>
                                    <td>&yen; <a href="{:U('Manage/otherExpenses',array('year'=>$year,'month'=>$month,'tm'=>'y'))}"> <?php echo $department['沈阳项目部']['money']?$department['沈阳项目部']['money']:'0.00'; ?> </a></td>
                                    <td>&yen; <a href="{:U('Manage/otherExpenses',array('year'=>$year,'month'=>$month,'tm'=>'y'))}"> <?php echo $department['长春项目部']['money']?$department['长春项目部']['money']:'0.00'; ?> </a></td>
                                    <td>&yen; <a href="{:U('Manage/otherExpenses',array('year'=>$year,'month'=>$month,'tm'=>'y'))}"> <?php echo $department['市场部']['money']?$department['市场部']['money']:'0.00'; ?> </a></td>
                                    <td>&yen; <a href="{:U('Manage/otherExpenses',array('year'=>$year,'month'=>$month,'tm'=>'y'))}"> <?php echo $department['常规业务中心']['money']?$department['常规业务中心']['money']:'0.00'; ?> </a></td>
                                    <td>&yen; <a href="{:U('Manage/otherExpenses',array('year'=>$year,'month'=>$month,'tm'=>'y'))}"> <?php echo $department['机关部门']['money']?$department['机关部门']['money']:'0.00'; ?> </a></td>
                                </tr>
                                <tr role="row" class="orders" style="text-align:center;">
                                    <td>利润总额</td>
                                    <td>&yen; <?php echo $total_profit['公司']?$total_profit['公司']:'0.00'; ?></td>
                                    <td>&yen; <?php echo $total_profit['京区业务中心']?$total_profit['京区业务中心']:'0.00'; ?></td>
                                    <td>&yen; <?php echo $total_profit['京外业务中心']?$total_profit['京外业务中心']:'0.00'; ?></td>
                                    <td>&yen; <?php echo $total_profit['南京项目部']?$total_profit['南京项目部']:'0.00'; ?></td>
                                    <td>&yen; <?php echo $total_profit['武汉项目部']?$total_profit['武汉项目部']:'0.00'; ?></td>
                                    <td>&yen; <?php echo $total_profit['沈阳项目部']?$total_profit['沈阳项目部']:'0.00'; ?></td>
                                    <td>&yen; <?php echo $total_profit['长春项目部']?$total_profit['长春项目部']:'0.00'; ?></td>
                                    <td>&yen; <?php echo $total_profit['市场部']?$total_profit['市场部']:'0.00'; ?></td>
                                    <td>&yen; <?php echo $total_profit['常规业务中心']?$total_profit['常规业务中心']:'0.00'; ?></td>
                                    <td>&yen; <?php echo $total_profit['机关部门']?$total_profit['机关部门']:'0.00'; ?></td>
                                </tr>
                                <tr role="row" class="orders" style="text-align:center;">
                                    <td>人事费用率(%)</td>
                                    <td><?php echo $human_affairs['公司']?$human_affairs['公司']:'0.00'; ?> %</td>
                                    <td><?php echo $human_affairs['京区业务中心']?$human_affairs['京区业务中心']:'0.00'; ?> %</td>
                                    <td><?php echo $human_affairs['京外业务中心']?$human_affairs['京外业务中心']:'0.00'; ?> %</td>
                                    <td><?php echo $human_affairs['南京项目部']?$human_affairs['南京项目部']:'0.00'; ?> %</td>
                                    <td><?php echo $human_affairs['武汉项目部']?$human_affairs['武汉项目部']:'0.00'; ?> %</td>
                                    <td><?php echo $human_affairs['沈阳项目部']?$human_affairs['沈阳项目部']:'0.00'; ?> %</td>
                                    <td><?php echo $human_affairs['长春项目部']?$human_affairs['长春项目部']:'0.00'; ?> %</td>
                                    <td><?php echo $human_affairs['市场部']?$human_affairs['市场部']:'0.00'; ?> %</td>
                                    <td><?php echo $human_affairs['常规业务中心']?$human_affairs['常规业务中心']:'0.00'; ?> %</td>
                                    <td><?php echo $human_affairs['机关部门']?$human_affairs['机关部门']:'0.00'; ?> %</td>
                                </tr>
                                <tr>
                                    <td colspan="11" style="text-align: left;padding-left: 20px;">说明：其中内部地接营业收入 &yen;{$profit['地接合计']['monthzsr']}；内部地接营业毛利：&yen;{$profit['地接合计']['monthzml']}。公司总收入中不包含地接收入，部门收入中包含地接收入。</td>
                                </tr>
                            </table><br><br>

                        </div><!-- /.box-body -->
                    </div><!-- /.box -->


                </div><!-- /.box -->

            </div><!--/.col (right) -->

        </div>   <!-- /.row -->

    </section><!-- /.content -->

</aside><!-- /.right-side -->


<include file="Index:footer2" />

<script>

</script>