<include file="Index:header2" />
<style>
    #btn-default_1{
        background-color:#00acd6;
    }
</style>
<aside class="right-side">

    <section class="content-header">
        <h1><a ></a>人事费用率控制<small>{$year}年{$quarter}季度</small></h1>
        <ol class="breadcrumb">
            <li><a href="{:U('Index/index')}"><i class="fa fa-home"></i> 首页</a></li>
            <li><a href="javascript:;"><i class="fa fa-gift"></i> 人事费用率控制</a></li>
        </ol>
    </section>

    <!-- Main content -->
    <section class="content">

        <div class="row">
            <!-- right column -->
            <div class="col-md-12">
                <!--<div class="btn-group" id="catfont" style="padding-bottom:20px;">
                    <?php /*if (($year-1)>2017){ */?>
                    <a href="{:U('Manage/public_person_cost_rate',array('year'=>$year-1))}" class="btn btn-default" id="btn-default_id1" style="padding:8px 18px;">上一年</a>
                    <?php /*} */?>
                    <?php
/*                        for($i=1;$i<5;$i++){
                            if ($quarter == $i){
                                echo '<a href="'.U('Manage/public_person_cost_rate',array('year'=>$year,'month'=>$month,'quarter'=>$quarter)).'" class="btn btn-info" style="padding:8px 18px;">'.$i.'季度</a>';
                            }else{
                                echo '<a href="'.U('Manage/public_person_cost_rate',array('year'=>$year,'month'=>$month,'quarter'=>$quarter)).'" class="btn btn-default" style="padding:8px 18px;">'.$i.'季度</a>';
                            }
                        }
                    */?>
                    <a href="{:U('Manage/public_person_cost_rate',array('year'=>$year+1))}" class="btn btn-default" id="btn-default_id3" style="padding:8px 18px;">下一年</a>
                </div>-->

                <div class="box box-warning">
                    <div class="box-header">
                        <h3 class="box-title">人事费用率控制</h3>
                    </div><!-- /.box-header -->
                    <div class="box-body">

                        <table class="table table-bordered dataTable fontmini" id="tablecenter">
                            <tr role="row" class="orders" style="text-align:center;" >
                                <th class="black">类型</th>
                                <th class="black">人力资源成本</th>
                                <th class="black">营业收入</th>
                                <th class="black">人事费用率</th>
                                <th class="black" width="100">合格范围</th>
                                <th class="black" width="80">合计完成率</th>
                            </tr>

                            <tr>
                                <td>预算数据</td>
                                <td><a href="{:U('Manage/Manage_quarter',array('year'=>$year,'quart'=>$month))}">{$data.plan_hr_cost}</a></td>
                                <td>{$data.plan_income}</td>
                                <td>{$data.plan_hr_avg}</td>
                                <td rowspan="2">-5%≤目标＜0</td>
                                <td rowspan="2">{$data.complete}</td>
                            </tr>
                            <tr>
                                <td>完成数据</td>
                                <td><a href="{:U('Manage/Manage_quarter',array('year'=>$year,'quart'=>$month))}">{$data.real_hr_cost}</a></td>
                                <td>{$data.real_income}</td>
                                <td>{$data.real_hr_avg}</td>
                            </tr>
                        </table><br><br>

                    </div><!-- /.box-body -->
                </div><!-- /.box -->

            </div><!--/.col (right) -->

        </div>   <!-- /.row -->

    </section><!-- /.content -->

</aside><!-- /.right-side -->


<include file="Index:footer2" />