<include file="Index:header2" />
<style>
    #btn-default_1{
        background-color:#00acd6;
    }
</style>
<aside class="right-side">

    <section class="content-header">
        <h1><a ></a>季度财务预算准确率<small>{$year}年{$quarter}季度</small></h1>
        <ol class="breadcrumb">
            <li><a href="{:U('Index/index')}"><i class="fa fa-home"></i> 首页</a></li>
            <li><a href="javascript:;"><i class="fa fa-gift"></i> 季度财务预算准确率</a></li>
        </ol>
    </section>

    <!-- Main content -->
    <section class="content">

        <div class="row">
            <!-- right column -->
            <div class="col-md-12">
                <!--<div class="btn-group" id="catfont" style="padding-bottom:20px;">
                    <?php /*if (($year-1)>2017){ */?>
                    <a href="{:U('Manage/public_kpi_budget',array('year'=>$year-1))}" class="btn btn-default" id="btn-default_id1" style="padding:8px 18px;">上一年</a>
                    <?php /*} */?>
                    <?php
/*                        for($i=1;$i<5;$i++){
                            if ($quarter == $i){
                                echo '<a href="'.U('Manage/public_kpi_budget',array('year'=>$year,'month'=>$month,'quarter'=>$quarter)).'" class="btn btn-info" style="padding:8px 18px;">'.$i.'季度</a>';
                            }else{
                                echo '<a href="'.U('Manage/public_kpi_budget',array('year'=>$year,'month'=>$month,'quarter'=>$quarter)).'" class="btn btn-default" style="padding:8px 18px;">'.$i.'季度</a>';
                            }
                        }
                    */?>
                    <a href="{:U('Manage/public_kpi_budget',array('year'=>$year+1))}" class="btn btn-default" id="btn-default_id3" style="padding:8px 18px;">下一年</a>
                </div>-->

                <div class="box box-warning">
                    <div class="box-header">
                        <h3 class="box-title">季度财务预算准确率</h3>
                    </div><!-- /.box-header -->
                    <div class="box-body">

                        <table class="table table-bordered dataTable fontmini" id="tablecenter">
                            <tr role="row" class="orders" style="text-align:center;" >
                                <th class="black">类型</th>
                                <th class="black">预算数据</th>
                                <th class="black">完成数据</th>
                                <th class="black">偏差</th>
                                <th class="black" width="80">合格范围</th>
                                <th class="black" width="80">完成率</th>
                                <th class="black" width="80">分值(分)</th>
                                <th class="black" width="80">得分(分)</th>
                                <th class="black" width="80">合计完成率</th>
                            </tr>

                            <tr>
                                <td>季度营收</td>
                                <td><a href="{:U('Manage/Manage_quarter',array('year'=>$year,'quart'=>$month))}">{$data.quarter_plan_income}</a></td>
                                <td>{$data.quarter_real_income}</td>
                                <td>{$data.income_offset}</td>
                                <td rowspan="2">{$target}</td>
                                <td>{$data.income_avg}</td>
                                <td>40</td>
                                <td>{$data.income_s}</td>
                                <td rowspan="2">{$data.complete}</td>
                            </tr>
                            <tr>
                                <td>季度利润</td>
                                <td><a href="{:U('Manage/Manage_quarter',array('year'=>$year,'quart'=>$month))}">{$data.quarter_plan_profit}</a></td>
                                <td>{$data.quarter_real_profit}</td>
                                <td>{$data.profit_offset}</td>
                                <td>{$data.profit_avg}</td>
                                <td>60</td>
                                <td>{$data.profit_s}</td>
                            </tr>
                        </table><br><br>

                    </div><!-- /.box-body -->
                </div><!-- /.box -->

            </div><!--/.col (right) -->

        </div>   <!-- /.row -->

    </section><!-- /.content -->

</aside><!-- /.right-side -->


<include file="Index:footer2" />