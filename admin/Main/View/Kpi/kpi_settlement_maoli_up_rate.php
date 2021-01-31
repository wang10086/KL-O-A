<include file="Index:header2" />
<style>
    #btn-default_1{
        background-color:#00acd6;
    }
</style>
<aside class="right-side">

    <section class="content-header">
        <h1><a ></a>{$_action_}<small>{$year}年{$quarter}季度</small></h1>
        <ol class="breadcrumb">
            <li><a href="{:U('Index/index')}"><i class="fa fa-home"></i> 首页</a></li>
            <li><a href="javascript:;"><i class="fa fa-gift"></i> {$_action_}</a></li>
        </ol>
    </section>

    <!-- Main content -->
    <section class="content">

        <div class="row">
            <!-- right column -->
            <div class="col-md-12">
                <div class="btn-group" id="catfont" style="padding-bottom:20px;">
                    <?php if (($year-1)>2017){ ?>
                    <a href="{:U('Kpi/public_kpi_settlement_maoli_up_rate',array('year'=>$year-1,'quarter'=>$quarter,'kid'=>$kid))}" class="btn btn-default" id="btn-default_id1" style="padding:8px 18px;">上一年</a>
                    <?php } ?>
                    <?php
                        for($i=1;$i<5;$i++){
                            if ($quarter == $i){
                                echo '<a href="'.U('Kpi/public_kpi_settlement_maoli_up_rate',array('year'=>$year,'quarter'=>$i,'kid'=>$kid)).'" class="btn btn-info" style="padding:8px 18px;">'.$i.'季度</a>';
                            }else{
                                echo '<a href="'.U('Kpi/public_kpi_settlement_maoli_up_rate',array('year'=>$year,'quarter'=>$i,'kid'=>$kid)).'" class="btn btn-default" style="padding:8px 18px;">'.$i.'季度</a>';
                            }
                        }
                    ?>
                    <?php if ($year < date("Y")){ ?>
                    <a href="{:U('Kpi/public_kpi_settlement_maoli_up_rate',array('year'=>$year+1,'quarter'=>$quarter,'kid'=>$kid))}" class="btn btn-default" id="btn-default_id3" style="padding:8px 18px;">下一年</a>
                    <?php } ?>
                </div>

                <div class="box box-warning">
                    <div class="box-header">
                        <h3 class="box-title">{$department}</h3>
                    </div><!-- /.box-header -->
                    <div class="box-body">

                        <table class="table table-bordered dataTable fontmini" id="tablecenter">
                            <tr role="row" class="orders" style="text-align:center;" >
                                <th class="">年度</th>
                                <th class="">项目数</th>
                                <th class="">毛利额</th>
                                <th class="">增长率</th>
                                <th width="100">详情</th>
                            </tr>
                            <tr>
                                <td>{$lastYearData.year}</td>
                                <td>{$lastYearData.op_num}</td>
                                <td>{$lastYearData.sum_maoli}</td>
                                <td rowspan="2">{$up_rate}</td>
                                <td><a href="{:U('Kpi/public_kpi_settlement_maoli_up_rate_detail', array('kid'=>$kid,'year'=>$lastYearData['year'],'quarter'=>$quarter))}" class="btn btn-smsm btn-info" title="详情"><i class="fa fa-bars"></i></a></td>
                            </tr>
                            <tr>
                                <td>{$thisYearData.year}</td>
                                <td>{$thisYearData.op_num}</td>
                                <td>{$thisYearData.sum_maoli}</td>
                                <td><a href="{:U('Kpi/public_kpi_settlement_maoli_up_rate_detail', array('kid'=>$kid,'year'=>$thisYearData['year'],'quarter'=>$quarter))}" class="btn btn-smsm btn-info" title="详情"><i class="fa fa-bars"></i></a></td>
                            </tr>
                        </table><br><br>

                    </div><!-- /.box-body -->
                </div><!-- /.box -->

            </div><!--/.col (right) -->

        </div>   <!-- /.row -->

    </section><!-- /.content -->

</aside><!-- /.right-side -->


<include file="Index:footer2" />
