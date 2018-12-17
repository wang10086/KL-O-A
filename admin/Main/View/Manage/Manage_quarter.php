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
                    <a href="{:U('Manage/Manage_quarter',array('year'=>$year,'post'=>1))}" class="btn btn-default" id ="<?php if($post==1){echo 'btn-default_1';}?>" style="padding:8px 18px;">上一年</a>
                    <a href="{:U('Manage/Manage_quarter',array('year'=>$year,'quart'=>3))}" class="btn btn-default" style="padding:8px 18px;" id="<?php if($quart==3 && $post==''){echo 'btn-default_1';}?>">第一季度</a>
                    <a href="{:U('Manage/Manage_quarter',array('year'=>$year,'quart'=>6))}" class="btn btn-default" style="padding:8px 18px;" id="<?php if($quart==6  && $post==''){echo 'btn-default_1';}?>">第二季度</a>
                    <a href="{:U('Manage/Manage_quarter',array('year'=>$year,'quart'=>9))}" class="btn btn-default" style="padding:8px 18px;" id="<?php if($quart==9  && $post==''){echo 'btn-default_1';}?>">第三季度</a>
                    <a href="{:U('Manage/Manage_quarter',array('year'=>$year,'quart'=>12))}" class="btn btn-default" style="padding:8px 18px;" id="<?php if($quart==12  && $post==''){echo 'btn-default_1';}?>">第四季度</a>
                    <a href="{:U('Manage/Manage_quarter',array('year'=>$year,'post'=>2))}" class="btn btn-default" id ="<?php if($post==2){echo 'btn-default_1';}?>" style="padding:8px 18px;">下一年</a>
                </div>

                <div class="box box-warning">
                    <div class="box-header">
                        <h3 class="box-title">季度预算报表</h3>
                        <div class="box-header">
                            <a class="btn btn-info btn-sm" href="{:U('Manage/Manage_quarter_w')}" style="float:right;margin:1em 2em 0em 0em;background-color:#398439;"><b>+</b>预算录入</a>
                        </div>
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
                                        <th><?php if($m['statu']=="" || $m['statu']==0){echo '';}else{echo $m['statu']; }?></th>
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
                                    <td>员工人数</td>
                                    <foreach name="quarter" item="q">
                                        <th><?php if($q['sum']=="" || $q['sum']==0 || count($quarter)==0){echo '0';}else{echo round($q['sum']);}?> (人)</th>
                                    </foreach>
                                </tr>

                                <tr role="row" class="orders" style="text-align:center;">
                                    <td>营业收入</td>
                                    <foreach name="profit" item="pro">
                                        <th>¥ <?php if($pro['monthzsr']=="" || $pro['monthzsr']==0 || count($quarter)==0){echo '0.00';}else{echo round($pro['monthzsr'],2);}?></th>
                                    </foreach>
                                </tr>
                                <tr role="row" class="orders" style="text-align:center;">
                                    <th>营业毛利</th>
                                    <foreach name="profit" item="pr">
                                        <th>¥ <?php if($pr['monthzml']=="" || $pr['monthzml']==0 || count($quarter)==0){echo '0.00';}else{echo round($pr['monthzml'],2);}?></th>
                                    </foreach>
                                </tr>
                                <tr role="row" class="orders" style="text-align:center;">
                                    <td>营业毛利率(%)</td>
                                    <foreach name="profit" item="p">
                                        <th><?php if($p['monthmll']=="" || $p['monthmll']==0 || count($quarter)==0){echo '0.00';}else{echo round($p['monthmll'],2);}?> %</th>
                                    </foreach>
                                </tr>
                                <tr role="row" class="orders" style="text-align:center;">
                                    <th>人力资源成本</th>
                                    <foreach name="quarter" item="qu">
                                        <th>¥ <?php if($qu['money']=="" || $qu['money']==0 || count($quarter)==0){echo '0.00';}else{echo round($qu['money'],2);}?></th>
                                    </foreach>

                                </tr>
                                <tr role="row" class="orders" style="text-align:center;">
                                    <td>其他费用</td>
                                    <td><?php echo $n['employees_sum'];?></td>
                                    <td></td>
                                    <td></td>
                                    <td></td>
                                    <td></td>
                                    <td></td>
                                    <td></td>
                                    <td></td>
                                    <td></td>
                                    <td></td>
                                </tr>
                                <tr role="row" class="orders" style="text-align:center;">
                                    <td>利润总额</td>
                                    <foreach name="manage_quarter" item="ma">
                                        <th>¥ <?php if($ma['monthzml']=="" || $ma['monthzml']==0 || count($quarter)==0){echo '0.00';}else{echo round($ma['monthzml'],2);}?></th>
                                    </foreach>
                                </tr>
                                <tr role="row" class="orders" style="text-align:center;">
                                    <td>人事费用率(%)</td>
                                    <foreach name="personnel_costs" item="pe">
                                        <th><?php if($pe['personnel_costs']=="" || $pe['personnel_costs']==0 || count($quarter)==0){echo '0.00';}else{echo round($pe['personnel_costs'],2);}?> %</th>
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

