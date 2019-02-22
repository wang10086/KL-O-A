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
                    <a href="{:U('Manage/Manage_year',array('year'=>$year,'post'=>1))}" class="btn btn-default" id="<?php if($post==1){echo 'btn-default_1';}?>" style="padding:8px 18px;">上一年</a>
                    <a href="{:U('Manage/Manage_year',array('year'=>$year,'post'=>2))}" class="btn btn-default" id="<?php if($post==2){echo 'btn-default_1';}?>" style="padding:8px 18px;">下一年</a>
                </div>

                <div class="box box-warning">
                    <div class="box-header">
                        <h3 class="box-title">年度预算报表</h3>
                        <if condition="rolemenu(array('Manage/Manage_input'))" class="{:on('Manage/Manage_input')}">
                            <div class="box-header">
                                <a class="btn btn-info btn-sm" href="{:U('Manage/Manage_input')}" style="float:right;margin:1em 2em 0em 0em;background-color:#398439;"><b>+</b>预算录入</a>
                            </div>
                        </if>
                    </div><!-- /.box-header -->
                    <div class="box-body">

                        <table class="table table-bordered dataTable fontmini">
                            <tr role="row" class="orders" >
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
                                    <th>员工人数</th>
                                    <foreach name="yea_report" item="yea">
                                        <th><?php if($yea['sum']=="" || $yea['sum']==0){echo '0';}else{echo $yea['sum']; }?>（人)</th>
                                    </foreach>
                                </tr>

                                <tr role="row" class="orders" style="text-align:center;">
                                    <td>营业收入</td>
                                    <foreach name="profit" item="pro">
                                        <th>¥ <?php if($pro['yearzsr']=="" || $pro['yearzsr']==0){echo '0.00';}else{echo $pro['yearzsr']; }?></th>
                                    </foreach>
                                </tr>
                                <tr role="row" class="orders" style="text-align:center;">
                                    <td>营业毛利</td>
                                    <foreach name="profit" item="pr">
                                        <th>¥ <?php if($pr['yearzml']=="" || $pr['yearzml']==0){echo '0.00';}else{echo $pr['yearzml']; }?></th>
                                    </foreach>
                                </tr>
                                <tr role="row" class="orders" style="text-align:center;">
                                    <td>营业毛利率(%)</td>
                                    <foreach name="profit" item="p">
                                        <th><?php if($p['yearmll']=="" || $p['yearmll']==0){echo '0.00';}else{echo $p['yearmll']; }?> %</th>
                                    </foreach>
                                </tr>
                                <tr role="row" class="orders" style="text-align:center;">
                                    <td>人力资源成本</td>
                                    <foreach name="yea_report" item="ye">
                                        <th>¥ <?php if($ye['money']=="" || $ye['money']==0){echo '0.00';}else{echo $ye['money'];}?></th>
                                    </foreach>

                                </tr>
                                <tr role="row" class="orders" style="text-align:center;">
                                    <td>其他费用</td>
                                    <!--<foreach name="department" item="dep">
                                        <th>¥ <?php /*if($dep['money']=="" || $dep['money']==0){echo '0.00';}else{echo $dep['money'];}*/?></th>
                                    </foreach>-->
                                    <th>&yen; <?php echo $department['公司']['money']?$department['公司']['money']:'0.00'; ?></th>
                                    <th>&yen; <?php echo $department['京区业务中心']['money']?$department['京区业务中心']['money']:'0.00'; ?></th>
                                    <th>&yen; <?php echo $department['京外业务中心']['money']?$department['京外业务中心']['money']:'0.00'; ?></th>
                                    <th>&yen; <?php echo $department['南京项目部']['money']?$department['南京项目部']['money']:'0.00'; ?></th>
                                    <th>&yen; <?php echo $department['武汉项目部']['money']?$department['武汉项目部']['money']:'0.00'; ?></th>
                                    <th>&yen; <?php echo $department['沈阳项目部']['money']?$department['沈阳项目部']['money']:'0.00'; ?></th>
                                    <th>&yen; <?php echo $department['长春项目部']['money']?$department['长春项目部']['money']:'0.00'; ?></th>
                                    <th>&yen; <?php echo $department['市场部']['money']?$department['市场部']['money']:'0.00'; ?></th>
                                    <th>&yen; <?php echo $department['常规业务中心']['money']?$department['常规业务中心']['money']:'0.00'; ?></th>
                                    <th>&yen; <?php echo $department['机关部门']['money']?$department['机关部门']['money']:'0.00'; ?></th>

                                </tr>
                                <tr role="row" class="orders" style="text-align:center;">
                                    <td>利润总额</td>
                                    <foreach name="count_profit" item="count">
                                        <th>¥ <?php if($count['yearprofit']=="" || $count['yearprofit']==0){echo '0.00';}else{echo $count['yearprofit'];}?></th>
                                    </foreach>
                                </tr>
                                <tr role="row" class="orders" style="text-align:center;">
                                    <td>人事费用率(%)</td>
                                    <foreach name="count_profit" item="c">
                                        <th><?php if($c['personnel']=="" || $c['personnel']==0){echo '0.00';}else{echo $c['personnel'];}?> %</th>
                                    </foreach>
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