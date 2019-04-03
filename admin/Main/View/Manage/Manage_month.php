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
                    <?php if (($year-1)>2017){ ?>
                    <a href="{:U('Manage/Manage_month',array('year'=>$year-1))}" class="btn btn-default" id="btn-default_id1" style="padding:8px 18px;">上一年</a>
                    <?php } ?>
                    <?php
                        for($i=1;$i<13;$i++){
                         echo '<a href="'.U('Manage/Manage_month',array('year'=>$year,'month'=>$i)).'" class="btn btn-default" id="btn-default'.$i.'" style="padding:8px 18px;">'.$i.'月</a>';
                        }
                    ?>
                    <a href="{:U('Manage/Manage_month',array('year'=>$year+1))}" class="btn btn-default" id="btn-default_id3" style="padding:8px 18px;">下一年</a>
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
                                <th style="width:10em;" ><b>市场部(业务)</b></th>
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
                                <th>&yen; <?php echo $profit['公司']['monthzsr']?$profit['公司']['monthzsr']:'0.00'; ?></th>
                                <th>&yen; <?php echo $profit['京区业务中心']['monthzsr']?$profit['京区业务中心']['monthzsr']:'0.00'; ?></th>
                                <th>&yen; <?php echo $profit['京外业务中心']['monthzsr']?$profit['京外业务中心']['monthzsr']:'0.00'; ?></th>
                                <th>&yen; <?php echo $profit['南京项目部']['monthzsr']?$profit['南京项目部']['monthzsr']:'0.00'; ?></th>
                                <th>&yen; <?php echo $profit['武汉项目部']['monthzsr']?$profit['武汉项目部']['monthzsr']:'0.00'; ?></th>
                                <th>&yen; <?php echo $profit['沈阳项目部']['monthzsr']?$profit['沈阳项目部']['monthzsr']:'0.00'; ?></th>
                                <th>&yen; <?php echo $profit['长春项目部']['monthzsr']?$profit['长春项目部']['monthzsr']:'0.00'; ?></th>
                                <th>&yen; <?php echo $profit['市场部']['monthzsr']?$profit['市场部']['monthzsr']:'0.00'; ?></th>
                                <th>&yen; <?php echo $profit['常规业务中心']['monthzsr']?$profit['常规业务中心']['monthzsr']:'0.00'; ?></th>
                                <th>&yen; <?php echo $profit['机关部门']['monthzsr']?$profit['机关部门']['monthzsr']:'0.00'; ?></th>
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
                                <td><a href="{:U('Manage/HR_cost',array('year'=>$year,'month'=>$month,'tm'=>'m'))}">人力资源成本</a></td>
                                <th>&yen; <?php echo $hr_cost['公司']?$hr_cost['公司']:'0.00'; ?></th>
                                <th>&yen; <?php echo $hr_cost['京区业务中心']?$hr_cost['京区业务中心']:'0.00'; ?></th>
                                <th>&yen; <?php echo $hr_cost['京外业务中心']?$hr_cost['京外业务中心']:'0.00'; ?></th>
                                <th>&yen; <?php echo $hr_cost['南京项目部']?$hr_cost['南京项目部']:'0.00'; ?></th>
                                <th>&yen; <?php echo $hr_cost['武汉项目部']?$hr_cost['武汉项目部']:'0.00'; ?></th>
                                <th>&yen; <?php echo $hr_cost['沈阳项目部']?$hr_cost['沈阳项目部']:'0.00'; ?></th>
                                <th>&yen; <?php echo $hr_cost['长春项目部']?$hr_cost['长春项目部']:'0.00'; ?></th>
                                <th>&yen; <?php echo $hr_cost['市场部']?$hr_cost['市场部']:'0.00'; ?></th>
                                <th>&yen; <?php echo $hr_cost['常规业务中心']?$hr_cost['常规业务中心']:'0.00'; ?></th>
                                <th>&yen; <?php echo $hr_cost['机关部门']?$hr_cost['机关部门']:'0.00'; ?></th>
                            </tr>
                            <tr role="row" class="orders" style="text-align:center;">
                                <td><a href="{:U('Manage/otherExpenses',array('year'=>$year,'month'=>$month,'tm'=>'m'))}">其他费用</a></td>
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

            </div><!--/.col (right) -->

        </div>   <!-- /.row -->

    </section><!-- /.content -->

</aside><!-- /.right-side -->


<include file="Index:footer2" />
<script>
    $(function(){

        var sum = "<?php echo $post;?>";
        var num = "\<?php echo $month;?>";
        if(sum==1 && num==''){
           $('#btn-default_id1').attr('id','btn-default_1');return false;
        }
        if(sum==2 && num==''){
            $('#btn-default_id3').attr('id','btn-default_1');return false;
        }
        if(sum=='' && num!==''){
            $("#btn-default<?php echo $month;?>").attr('id','btn-default_1');return false;
        }
    });
</script>