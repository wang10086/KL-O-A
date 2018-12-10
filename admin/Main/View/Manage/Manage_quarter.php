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
                                    <th style="width:10em;" ><b>常规旅游中心</b></th>
                                    <th style="width:10em;" ><b>机关部门</b></th>
                                </tr>
                                <tr role="row" class="orders" style="text-align:center;">
                                    <th>员工人数</th>
                                    <foreach name="quarter" item="qua">
                                        <th><?php if(is_numeric($qua['sum'])){echo round($qua['sum']);}else{echo '111111111111';}?>(人)</th>
                                    </foreach>
                                </tr>

                                <tr role="row" class="orders" style="text-align:center;">
                                    <td>营业收入</td>
                                    <td></td>
                                    <td>1</td>
                                    <td></td>
                                    <td>1</td>
                                    <td></td>
                                    <td></td>
                                    <td></td>
                                    <td></td>
                                    <td></td>
                                    <td>1</td>
                                </tr>
                                <tr role="row" class="orders" style="text-align:center;">
                                    <td>营业毛利</td>
                                    <td><?php echo $n['employees_sum'];?></td>
                                    <td>1</td>
                                    <td></td>
                                    <td>1</td>
                                    <td></td>
                                    <td></td>
                                    <td></td>
                                    <td></td>
                                    <td></td>
                                    <td>1</td>
                                </tr>
                                <tr role="row" class="orders" style="text-align:center;">
                                    <td>营业毛利率(%)</td>
                                    <td><?php echo $n['employees_sum'];?></td>
                                    <td>1</td>
                                    <td></td>
                                    <td>1</td>
                                    <td></td>
                                    <td></td>
                                    <td></td>
                                    <td></td>
                                    <td></td>
                                    <td>1</td>
                                </tr>
                                <tr role="row" class="orders" style="text-align:center;">
                                    <td>人力资源成本</td>
                                    <td>1</td>
                                    <td></td>
                                    <td>1</td>
                                    <td></td>
                                    <td></td>
                                    <td></td>
                                    <td></td>
                                    <td></td>
                                    <td>1</td>
                                    <td></td>


                                </tr>
                                <tr role="row" class="orders" style="text-align:center;">
                                    <td>其他费用</td>
                                    <td><?php echo $n['employees_sum'];?></td>
                                    <td>1</td>
                                    <td></td>
                                    <td>1</td>
                                    <td></td>
                                    <td></td>
                                    <td></td>
                                    <td></td>
                                    <td></td>
                                    <td>1</td>
                                </tr>
                                <tr role="row" class="orders" style="text-align:center;">
                                    <td>利润总额</td>
                                    <td><?php echo $n['employees_sum'];?></td>
                                    <td>1</td>
                                    <td></td>
                                    <td>1</td>
                                    <td></td>
                                    <td></td>
                                    <td></td>
                                    <td></td>
                                    <td></td>
                                    <td>1</td>
                                </tr>
                                <tr role="row" class="orders" style="text-align:center;">
                                    <td>人事费用率</td>
                                    <td><?php echo $n['employees_sum'];?></td>
                                    <td>1</td>
                                    <td></td>
                                    <td>1</td>
                                    <td></td>
                                    <td></td>
                                    <td></td>
                                    <td></td>
                                    <td></td>
                                    <td>1</td>
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
                                    <th style="width:10em;" ><b>常规旅游中心</b></th>
                                    <th style="width:10em;" ><b>机关部门</b></th>
                                </tr>
                                <tr role="row" class="orders" style="text-align:center;">
                                    <td>员工人数</td>
                                    <foreach name="quarter" item="q">
                                        <th><?php if($q['sum']=="" || $q['sum']==0 || count($quarter)==0){echo '0.00';}else{echo round($q['sum']);}?>(人)</th>
                                    </foreach>
                                </tr>

                                <tr role="row" class="orders" style="text-align:center;">
                                    <td>营业收入</td>
                                    <td></td>
                                    <td>1</td>
                                    <td></td>
                                    <td>1</td>
                                    <td></td>
                                    <td></td>
                                    <td></td>
                                    <td></td>
                                    <td></td>
                                    <td>1</td>
                                </tr>
                                <tr role="row" class="orders" style="text-align:center;">
                                    <td>营业毛利</td>
                                    <td><?php echo $n['employees_sum'];?></td>
                                    <td>1</td>
                                    <td></td>
                                    <td>1</td>
                                    <td></td>
                                    <td></td>
                                    <td></td>
                                    <td></td>
                                    <td></td>
                                    <td>1</td>
                                </tr>
                                <tr role="row" class="orders" style="text-align:center;">
                                    <td>营业毛利率(%)</td>
                                    <td><?php echo $n['employees_sum'];?></td>
                                    <td>1</td>
                                    <td></td>
                                    <td>1</td>
                                    <td></td>
                                    <td></td>
                                    <td></td>
                                    <td></td>
                                    <td></td>
                                    <td>1</td>
                                </tr>
                                <tr role="row" class="orders" style="text-align:center;">
                                    <th>人力资源成本</th>
                                    <foreach name="quarter" item="qu">
                                        <th>¥ <?php if($qu['money']=="" || $qu['money']==0 || count($qu)==0){echo '0.00';}else{echo round($qu['money'],2);}?></th>
                                    </foreach>

                                </tr>
                                <tr role="row" class="orders" style="text-align:center;">
                                    <td>其他费用</td>
                                    <td><?php echo $n['employees_sum'];?></td>
                                    <td>1</td>
                                    <td></td>
                                    <td>1</td>
                                    <td></td>
                                    <td></td>
                                    <td></td>
                                    <td></td>
                                    <td></td>
                                    <td>1</td>
                                </tr>
                                <tr role="row" class="orders" style="text-align:center;">
                                    <td>利润总额</td>
                                    <td><?php echo $n['employees_sum'];?></td>
                                    <td>1</td>
                                    <td></td>
                                    <td>1</td>
                                    <td></td>
                                    <td></td>
                                    <td></td>
                                    <td></td>
                                    <td></td>
                                    <td>1</td>
                                </tr>
                                <tr role="row" class="orders" style="text-align:center;">
                                    <td>人事费用率</td>
                                    <td><?php echo $n['employees_sum'];?></td>
                                    <td>1</td>
                                    <td></td>
                                    <td>1</td>
                                    <td></td>
                                    <td></td>
                                    <td></td>
                                    <td></td>
                                    <td></td>
                                    <td>1</td>
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

