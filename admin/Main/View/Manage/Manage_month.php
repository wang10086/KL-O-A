<include file="Index:header2" />
<style>
    #btn-default_1{
        background-color:#00acd6;
    }
</style>
<aside class="right-side">

    <section class="content-header">
        <h1><a >{$year}</a>月度经营报表</h1>
        <ol class="breadcrumb">
            <li><a href="{:U('Index/index')}"><i class="fa fa-home"></i> 首页</a></li>
            <li><a href="{:U('Manage/Manage_month')}"><i class="fa fa-gift"></i> 月度经营报表</a></li>
        </ol>
    </section>

    <!-- Main content -->
    <section class="content">

        <div class="row">
            <!-- right column -->
            <div class="col-md-12">
                <div class="btn-group" id="catfont" style="padding-bottom:20px;">

                    <a href="{:U('Manage/Manage_month',array('year'=>$year,'month'=>'1','post'=>1))}" class="btn btn-default" id="btn-default_id1" style="padding:8px 18px;">上一年</a>
                    <?php
                        for($i=1;$i<13;$i++){
                         echo '<a href="'.U('Manage/Manage_month',array('year'=>$year,'month'=>$i)).'" class="btn btn-default" id="btn-default'.$i.'" style="padding:8px 18px;">'.$i.'月</a>';
                        }
                    ?>
                    <a href="{:U('Manage/Manage_month',array('year'=>$year,'month'=>'1','post'=>2))}" class="btn btn-default" id="btn-default_id3" style="padding:8px 18px;">下一年</a>
                </div>

                <div class="box box-warning">
                    <div class="box-header">
                        <h3 class="box-title">月度经营报表</h3>
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

            </div><!--/.col (right) -->

        </div>   <!-- /.row -->

    </section><!-- /.content -->

</aside><!-- /.right-side -->


<include file="Index:footer2" />
<script>
    $(function(){
        var sum = <?php echo $post;?>;
        var num = <?php echo $month;?>;
        if(sum==1){
           $('#btn-default_id1').attr('id','btn-default_1');return false;
        }
        if(sum==2){
            $('#btn-default_id3').attr('id','btn-default_1');return false;
        }
        if(sum==0){
            $('#btn-default<?php echo $month;?>').attr('id','btn-default_1');return false;
        }
    });
</script>