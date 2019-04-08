<include file="Index:header2" />
<style>
    #btn-default_1{
        background-color:#00acd6;
    }
</style>
<aside class="right-side">

    <section class="content-header">
        <h1><?php echo $year;?>季度经营报表</h1>
        <ol class="breadcrumb">
            <li><a href="{:U('Index/index')}"><i class="fa fa-home"></i> 首页</a></li>
            <li><a href="{:U('Manage/Manage_quarter')}"><i class="fa fa-gift"></i> 季度经营报表</a></li>
        </ol>
    </section>

    <!-- Main content -->
    <section class="content">

        <div class="row">
            <!-- right column -->
            <div class="col-md-12">
                <div class="btn-group" id="catfont" style="padding-bottom:20px;">
                    <a href="{:U('Manage/Manage_quarter',array('year'=>$year-1))}" class="btn btn-default" style="padding:8px 18px;">上一年</a>
                    <a href="{:U('Manage/Manage_quarter',array('year'=>$year,'quart'=>3))}" class="btn btn-default <?php if($quart==3){echo 'btn-info';}?>">第一季度</a>
                    <a href="{:U('Manage/Manage_quarter',array('year'=>$year,'quart'=>6))}" class="btn btn-default <?php if($quart==6){echo 'btn-info';}?>">第二季度</a>
                    <a href="{:U('Manage/Manage_quarter',array('year'=>$year,'quart'=>9))}" class="btn btn-default <?php if($quart==9){echo 'btn-info';}?>">第三季度</a>
                    <a href="{:U('Manage/Manage_quarter',array('year'=>$year,'quart'=>12))}" class="btn btn-default <?php if($quart==12){echo 'btn-info';}?>">第四季度</a>
                    <a href="{:U('Manage/Manage_quarter',array('year'=>$year+1))}" class="btn btn-default">下一年</a>
                </div>

                <div class="box box-warning">
                    <div class="box-header">
                        <h3 class="box-title">季度预算报表</h3>
                        <if condition="rolemenu(array('Manage/Manage_quarter_w'))" class="{:on('Manage/Manage_quarter_w')}">
                            <div class="box-header">
                                <a class="btn btn-info btn-sm" href="{:U('Manage/Manage_quarter_w')}" style="float:right;margin:1em 2em 0em 0em;background-color:#398439;"><b>+</b>预算录入</a>
                            </div>
                        </if>
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
                                    <th style="width:10em;" ><b>市场部</b></th>
                                    <th style="width:10em;" ><b>常规业务中心</b></th>
                                    <th style="width:10em;" ><b>机关部门</b></th>
                                </tr>
                                <tr role="row" class="orders">
                                    <th>员工人数</th>
                                    <foreach name="manage" item="m">
                                        <th><?php if($m['employees_number']=="" || $m['employees_number']==0){echo '';}else{echo $m['employees_number'].'（人）'; }?></th>
                                    </foreach>
                                </tr>
                                <tr role="row" class="orders">
                                    <th>营业收入</th>
                                    <foreach name="manage" item="m">
                                        <th><?php if($m['logged_income']=="" || $m['logged_income']==0){echo '';}else{echo '¥ '.$m['logged_income']; }?></th>
                                    </foreach>
                                </tr>
                                <tr role="row" class="orders">
                                    <th>营业毛利</th>
                                    <foreach name="manage" item="m">
                                        <th><?php if($m['logged_profit']=="" || $m['logged_profit']==0){echo '';}else{echo '¥ '.$m['logged_profit']; }?></th>
                                    </foreach>
                                </tr>
                                <tr role="row" class="orders">
                                    <th>营业毛利率(%)</th>
                                    <foreach name="manage" item="m">
                                        <th><?php if($m['logged_rate']=="" || $m['logged_rate']==0){echo '';}else{echo $m['logged_rate'].' %'; }?></th>
                                    </foreach>
                                </tr>
                                <tr role="row" class="orders">
                                    <th>人力资源成本</th>
                                    <foreach name="manage" item="m">
                                        <th><?php if($m['manpower_cost']=="" || $m['manpower_cost']==0){echo '';}else{echo '¥ '.$m['manpower_cost']; }?></th>
                                    </foreach>
                                </tr>
                                <tr role="row" class="orders">
                                    <th>其他费用</th>
                                    <foreach name="manage" item="m">
                                        <th><?php if($m['other_expenses']=="" || $m['other_expenses']==0){echo '';}else{echo '¥ '.$m['other_expenses']; }?></th>
                                    </foreach>
                                </tr>
                                <tr role="row" class="orders">
                                    <th>利润总额</th>
                                    <foreach name="manage" item="m">
                                        <th><?php if($m['total_profit']=="" || $m['total_profit']==0){echo '';}else{echo '¥ '.$m['total_profit']; }?></th>
                                    </foreach>
                                </tr>
                                <tr role="row" class="orders">
                                    <th>人事费用率(%)</th>
                                    <foreach name="manage" item="m">
                                        <th><?php if($m['personnel_cost_rate']=="" || $m['personnel_cost_rate']==0){echo '';}else{echo $m['personnel_cost_rate'].' %'; }?></th>
                                    </foreach>
                                </tr>
                                <tr role="row" class="orders">
                                    <th>状态</th>
                                    <foreach name="manage" item="m">
                                        <th><a><?php if($m['statu']=="" || $m['statu']==0){echo '';}elseif($m['statu']==1){echo '待提交审核';}elseif($m['statu']==2){echo '待提交批准';}elseif($m['statu']==3){echo '待批准';}elseif($m['statu']==4){echo '已批准'; }?></a></th>
                                    </foreach>
                                </tr>
                            </table><br><br>
                        </div><!-- /.box-body -->
                    </div>

                    <div class="box box-warning" >
                        <div class="box-header">
                            <h3 class="box-title">季度经营报表</h3>
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
                                    <th style="width:10em;" ><b>市场部</b></th>
                                    <th style="width:10em;" ><b>常规业务中心</b></th>
                                    <th style="width:10em;" ><b>机关部门</b></th>
                                </tr>
                                <tr role="row" class="orders" style="text-align:center;">
                                    <th>员工人数</th>
                                    <th><?php echo $number['公司']?$number['公司']:0; ?>（人)</th>
                                    <th><?php echo $number['京区业务中心']?$number['京区业务中心']:0; ?>（人)</th>
                                    <th><?php echo $number['京外业务中心']?$number['京外业务中心']:0; ?>（人)</th>
                                    <th><?php echo $number['南京项目部']?$number['南京项目部']:0; ?>（人)</th>
                                    <th><?php echo $number['武汉项目部']?$number['武汉项目部']:0; ?>（人)</th>
                                    <th><?php echo $number['沈阳项目部']?$number['沈阳项目部']:0; ?>（人)</th>
                                    <th><?php echo $number['长春项目部']?$number['长春项目部']:0; ?>（人)</th>
                                    <th><?php echo $number['市场部']?$number['市场部']:0; ?>（人)</th>
                                    <th><?php echo $number['常规业务中心']?$number['常规业务中心']:0; ?>（人)</th>
                                    <th><?php echo $number['机关部门']?$number['机关部门']:0; ?>（人)</th>
                                </tr>
                                <tr role="row" class="orders" style="text-align:center;">
                                    <th>营业收入</th>
                                    <th>&yen; <a href="{:U('Chart/quarter_department',array('year'=>$year,'pin'=>$pin,'quarter'=>$quarter))}"><?php echo $profit['公司']['monthzsr']?$profit['公司']['monthzsr']:'0.00'; ?></a></th>
                                    <th>&yen; <a href="{:U('Chart/quarter_department',array('year'=>$year,'pin'=>$pin,'quarter'=>$quarter))}"><?php echo $profit['京区业务中心']['monthzsr']?$profit['京区业务中心']['monthzsr']:'0.00'; ?></a></th>
                                    <th>&yen; <a href="{:U('Chart/quarter_department',array('year'=>$year,'pin'=>$pin,'quarter'=>$quarter))}"><?php echo $profit['京外业务中心']['monthzsr']?$profit['京外业务中心']['monthzsr']:'0.00'; ?></a></th>
                                    <th>&yen; <a href="{:U('Chart/quarter_department',array('year'=>$year,'pin'=>$pin,'quarter'=>$quarter))}"><?php echo $profit['南京项目部']['monthzsr']?$profit['南京项目部']['monthzsr']:'0.00'; ?></a></th>
                                    <th>&yen; <a href="{:U('Chart/quarter_department',array('year'=>$year,'pin'=>$pin,'quarter'=>$quarter))}"><?php echo $profit['武汉项目部']['monthzsr']?$profit['武汉项目部']['monthzsr']:'0.00'; ?></a></th>
                                    <th>&yen; <a href="{:U('Chart/quarter_department',array('year'=>$year,'pin'=>$pin,'quarter'=>$quarter))}"><?php echo $profit['沈阳项目部']['monthzsr']?$profit['沈阳项目部']['monthzsr']:'0.00'; ?></a></th>
                                    <th>&yen; <a href="{:U('Chart/quarter_department',array('year'=>$year,'pin'=>$pin,'quarter'=>$quarter))}"><?php echo $profit['长春项目部']['monthzsr']?$profit['长春项目部']['monthzsr']:'0.00'; ?></a></th>
                                    <th>&yen; <a href="{:U('Chart/quarter_department',array('year'=>$year,'pin'=>$pin,'quarter'=>$quarter))}"><?php echo $profit['市场部']['monthzsr']?$profit['市场部']['monthzsr']:'0.00'; ?></a></th>
                                    <th>&yen; <a href="{:U('Chart/quarter_department',array('year'=>$year,'pin'=>$pin,'quarter'=>$quarter))}"><?php echo $profit['常规业务中心']['monthzsr']?$profit['常规业务中心']['monthzsr']:'0.00'; ?></a></th>
                                    <th>&yen; <a href="{:U('Chart/quarter_department',array('year'=>$year,'pin'=>$pin,'quarter'=>$quarter))}"><?php echo $profit['机关部门']['monthzsr']?$profit['机关部门']['monthzsr']:'0.00'; ?></a></th>
                                </tr>
                                <tr role="row" class="orders" style="text-align:center;">
                                    <td>营业毛利</td>
                                    <th>&yen; <?php echo $profit['公司']['monthzml']?$profit['公司']['monthzml']:'0.00'; ?></th>
                                    <th>&yen; <?php echo $profit['京区业务中心']['monthzml']?$profit['京区业务中心']['monthzml']:'0.00'; ?></th>
                                    <th>&yen; <?php echo $profit['京外业务中心']['monthzml']?$profit['京外业务中心']['monthzml']:'0.00'; ?></th>
                                    <th>&yen; <?php echo $profit['南京项目部']['monthzml']?$profit['南京项目部']['monthzml']:'0.00'; ?></th>
                                    <th>&yen; <?php echo $profit['武汉项目部']['monthzml']?$profit['武汉项目部']['monthzml']:'0.00'; ?></th>
                                    <th>&yen; <?php echo $profit['沈阳项目部']['monthzml']?$profit['沈阳项目部']['monthzml']:'0.00'; ?></th>
                                    <th>&yen; <?php echo $profit['长春项目部']['monthzml']?$profit['长春项目部']['monthzml']:'0.00'; ?></th>
                                    <th>&yen; <?php echo $profit['市场部']['monthzml']?$profit['市场部']['monthzml']:'0.00'; ?></th>
                                    <th>&yen; <?php echo $profit['常规业务中心']['monthzml']?$profit['常规业务中心']['monthzml']:'0.00'; ?></th>
                                    <th>&yen; <?php echo $profit['机关部门']['monthzml']?$profit['机关部门']['monthzml']:'0.00'; ?></th>
                                </tr>
                                <tr role="row" class="orders" style="text-align:center;">
                                    <td>营业毛利率(%)</td>
                                    <th><?php echo $profit['公司']['monthmll']?$profit['公司']['monthmll']:'0.00'; ?> %</th>
                                    <th><?php echo $profit['京区业务中心']['monthmll']?$profit['京区业务中心']['monthmll']:'0.00'; ?> %</th>
                                    <th><?php echo $profit['京外业务中心']['monthmll']?$profit['京外业务中心']['monthmll']:'0.00'; ?> %</th>
                                    <th><?php echo $profit['南京项目部']['monthmll']?$profit['南京项目部']['monthmll']:'0.00'; ?> %</th>
                                    <th><?php echo $profit['武汉项目部']['monthmll']?$profit['武汉项目部']['monthmll']:'0.00'; ?> %</th>
                                    <th><?php echo $profit['沈阳项目部']['monthmll']?$profit['沈阳项目部']['monthmll']:'0.00'; ?> %</th>
                                    <th><?php echo $profit['长春项目部']['monthmll']?$profit['长春项目部']['monthmll']:'0.00'; ?> %</th>
                                    <th><?php echo $profit['市场部']['monthmll']?$profit['市场部']['monthmll']:'0.00'; ?> %</th>
                                    <th><?php echo $profit['常规业务中心']['monthmll']?$profit['常规业务中心']['monthmll']:'0.00'; ?> %</th>
                                    <th><?php echo $profit['机关部门']['monthmll']?$profit['机关部门']['monthmll']:'0.00'; ?> %</th>
                                </tr>
                                <tr role="row" class="orders" style="text-align:center;">
                                    <td>人力资源成本</td>
                                    <th>&yen; <a href="{:U('Manage/HR_cost',array('year'=>$year,'month'=>$quart,'tm'=>'q','quarter'=>$quarter))}"><?php echo $hr_cost['公司']?$hr_cost['公司']:'0.00'; ?></a></th>
                                    <th>&yen; <a href="{:U('Manage/HR_cost',array('year'=>$year,'month'=>$quart,'tm'=>'q','quarter'=>$quarter))}"><?php echo $hr_cost['京区业务中心']?$hr_cost['京区业务中心']:'0.00'; ?></a></th>
                                    <th>&yen; <a href="{:U('Manage/HR_cost',array('year'=>$year,'month'=>$quart,'tm'=>'q','quarter'=>$quarter))}"><?php echo $hr_cost['京外业务中心']?$hr_cost['京外业务中心']:'0.00'; ?></a></th>
                                    <th>&yen; <a href="{:U('Manage/HR_cost',array('year'=>$year,'month'=>$quart,'tm'=>'q','quarter'=>$quarter))}"><?php echo $hr_cost['南京项目部']?$hr_cost['南京项目部']:'0.00'; ?></a></th>
                                    <th>&yen; <a href="{:U('Manage/HR_cost',array('year'=>$year,'month'=>$quart,'tm'=>'q','quarter'=>$quarter))}"><?php echo $hr_cost['武汉项目部']?$hr_cost['武汉项目部']:'0.00'; ?></a></th>
                                    <th>&yen; <a href="{:U('Manage/HR_cost',array('year'=>$year,'month'=>$quart,'tm'=>'q','quarter'=>$quarter))}"><?php echo $hr_cost['沈阳项目部']?$hr_cost['沈阳项目部']:'0.00'; ?></a></th>
                                    <th>&yen; <a href="{:U('Manage/HR_cost',array('year'=>$year,'month'=>$quart,'tm'=>'q','quarter'=>$quarter))}"><?php echo $hr_cost['长春项目部']?$hr_cost['长春项目部']:'0.00'; ?></a></th>
                                    <th>&yen; <a href="{:U('Manage/HR_cost',array('year'=>$year,'month'=>$quart,'tm'=>'q','quarter'=>$quarter))}"><?php echo $hr_cost['市场部']?$hr_cost['市场部']:'0.00'; ?></a></th>
                                    <th>&yen; <a href="{:U('Manage/HR_cost',array('year'=>$year,'month'=>$quart,'tm'=>'q','quarter'=>$quarter))}"><?php echo $hr_cost['常规业务中心']?$hr_cost['常规业务中心']:'0.00'; ?></a></th>
                                    <th>&yen; <a href="{:U('Manage/HR_cost',array('year'=>$year,'month'=>$quart,'tm'=>'q','quarter'=>$quarter))}"><?php echo $hr_cost['机关部门']?$hr_cost['机关部门']:'0.00'; ?></a></th>
                                </tr>
                                <tr role="row" class="orders" style="text-align:center;">
                                    <td>其他费用</a></td>
                                    <th>&yen; <a href="{:U('Manage/otherExpenses',array('year'=>$year,'month'=>$quart,'tm'=>'q','quarter'=>$quarter))}"><?php echo $department['公司']['money']?$department['公司']['money']:'0.00'; ?></a></th>
                                    <th>&yen; <a href="{:U('Manage/otherExpenses',array('year'=>$year,'month'=>$quart,'tm'=>'q','quarter'=>$quarter))}"><?php echo $department['京区业务中心']['money']?$department['京区业务中心']['money']:'0.00'; ?></a></th>
                                    <th>&yen; <a href="{:U('Manage/otherExpenses',array('year'=>$year,'month'=>$quart,'tm'=>'q','quarter'=>$quarter))}"><?php echo $department['京外业务中心']['money']?$department['京外业务中心']['money']:'0.00'; ?></a></th>
                                    <th>&yen; <a href="{:U('Manage/otherExpenses',array('year'=>$year,'month'=>$quart,'tm'=>'q','quarter'=>$quarter))}"><?php echo $department['南京项目部']['money']?$department['南京项目部']['money']:'0.00'; ?></a></th>
                                    <th>&yen; <a href="{:U('Manage/otherExpenses',array('year'=>$year,'month'=>$quart,'tm'=>'q','quarter'=>$quarter))}"><?php echo $department['武汉项目部']['money']?$department['武汉项目部']['money']:'0.00'; ?></a></th>
                                    <th>&yen; <a href="{:U('Manage/otherExpenses',array('year'=>$year,'month'=>$quart,'tm'=>'q','quarter'=>$quarter))}"><?php echo $department['沈阳项目部']['money']?$department['沈阳项目部']['money']:'0.00'; ?></a></th>
                                    <th>&yen; <a href="{:U('Manage/otherExpenses',array('year'=>$year,'month'=>$quart,'tm'=>'q','quarter'=>$quarter))}"><?php echo $department['长春项目部']['money']?$department['长春项目部']['money']:'0.00'; ?></a></th>
                                    <th>&yen; <a href="{:U('Manage/otherExpenses',array('year'=>$year,'month'=>$quart,'tm'=>'q','quarter'=>$quarter))}"><?php echo $department['市场部']['money']?$department['市场部']['money']:'0.00'; ?></a></th>
                                    <th>&yen; <a href="{:U('Manage/otherExpenses',array('year'=>$year,'month'=>$quart,'tm'=>'q','quarter'=>$quarter))}"><?php echo $department['常规业务中心']['money']?$department['常规业务中心']['money']:'0.00'; ?></a></th>
                                    <th>&yen; <a href="{:U('Manage/otherExpenses',array('year'=>$year,'month'=>$quart,'tm'=>'q','quarter'=>$quarter))}"><?php echo $department['机关部门']['money']?$department['机关部门']['money']:'0.00'; ?></a></th>
                                </tr>
                                <tr role="row" class="orders" style="text-align:center;">
                                    <td>利润总额</td>
                                    <th>&yen; <?php echo $total_profit['公司']?$total_profit['公司']:'0.00'; ?></th>
                                    <th>&yen; <?php echo $total_profit['京区业务中心']?$total_profit['京区业务中心']:'0.00'; ?></th>
                                    <th>&yen; <?php echo $total_profit['京外业务中心']?$total_profit['京外业务中心']:'0.00'; ?></th>
                                    <th>&yen; <?php echo $total_profit['南京项目部']?$total_profit['南京项目部']:'0.00'; ?></th>
                                    <th>&yen; <?php echo $total_profit['武汉项目部']?$total_profit['武汉项目部']:'0.00'; ?></th>
                                    <th>&yen; <?php echo $total_profit['沈阳项目部']?$total_profit['沈阳项目部']:'0.00'; ?></th>
                                    <th>&yen; <?php echo $total_profit['长春项目部']?$total_profit['长春项目部']:'0.00'; ?></th>
                                    <th>&yen; <?php echo $total_profit['市场部']?$total_profit['市场部']:'0.00'; ?></th>
                                    <th>&yen; <?php echo $total_profit['常规业务中心']?$total_profit['常规业务中心']:'0.00'; ?></th>
                                    <th>&yen; <?php echo $total_profit['机关部门']?$total_profit['机关部门']:'0.00'; ?></th>
                                </tr>
                                <tr role="row" class="orders" style="text-align:center;">
                                    <th>人事费用率(%)</th>
                                    <th><?php echo $human_affairs['公司']?$human_affairs['公司']:'0.00'; ?> %</th>
                                    <th><?php echo $human_affairs['京区业务中心']?$human_affairs['京区业务中心']:'0.00'; ?> %</th>
                                    <th><?php echo $human_affairs['京外业务中心']?$human_affairs['京外业务中心']:'0.00'; ?> %</th>
                                    <th><?php echo $human_affairs['南京项目部']?$human_affairs['南京项目部']:'0.00'; ?> %</th>
                                    <th><?php echo $human_affairs['武汉项目部']?$human_affairs['武汉项目部']:'0.00'; ?> %</th>
                                    <th><?php echo $human_affairs['沈阳项目部']?$human_affairs['沈阳项目部']:'0.00'; ?> %</th>
                                    <th><?php echo $human_affairs['长春项目部']?$human_affairs['长春项目部']:'0.00'; ?> %</th>
                                    <th><?php echo $human_affairs['市场部']?$human_affairs['市场部']:'0.00'; ?> %</th>
                                    <th><?php echo $human_affairs['常规业务中心']?$human_affairs['常规业务中心']:'0.00'; ?> %</th>
                                    <th><?php echo $human_affairs['机关部门']?$human_affairs['机关部门']:'0.00'; ?> %</th>
                                </tr>
                                <tr>
                                    <th colspan="11" style="text-align: left;padding-left: 20px;">说明：其中内部地接营业收入 &yen;{$profit['地接合计']['monthzsr']}；内部地接营业毛利：&yen;{$profit['地接合计']['monthzml']}。公司总收入中不包含地接收入，部门收入中包含地接收入。</th>
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

