<include file="Index:header2" />
<style>
    #btn-default_1{
        background-color:#00acd6;
    }
</style>
<aside class="right-side">

    <section class="content-header">
        <h1><a ></a>月度累计毛利率提升比率<small>{$year}年{$month}月</small></h1>
        <ol class="breadcrumb">
            <li><a href="{:U('Index/index')}"><i class="fa fa-home"></i> 首页</a></li>
            <li><a href="javascript:;"><i class="fa fa-gift"></i> 月度累计毛利率提升比率</a></li>
        </ol>
    </section>

    <!-- Main content -->
    <section class="content">

        <div class="row">
            <!-- right column -->
            <div class="col-md-12">
                <div class="btn-group" id="catfont" style="padding-bottom:20px;">
                    <?php if (($year-1)>2017){ ?>
                    <a href="{:U('Manage/public_elevate',array('year'=>$year-1))}" class="btn btn-default" id="btn-default_id1" style="padding:8px 18px;">上一年</a>
                    <?php } ?>
                    <?php
                        for($i=1;$i<13;$i++){
                            $i = str_pad($i,2,'0',STR_PAD_LEFT);
                            if ($month == $i){
                                echo '<a href="'.U('Manage/public_elevate',array('year'=>$year,'month'=>$i)).'" class="btn btn-info" style="padding:8px 18px;">'.$i.'月</a>';
                            }else{
                                echo '<a href="'.U('Manage/public_elevate',array('year'=>$year,'month'=>$i)).'" class="btn btn-default" style="padding:8px 18px;">'.$i.'月</a>';
                            }
                        }
                    ?>
                    <a href="{:U('Manage/public_elevate',array('year'=>$year+1))}" class="btn btn-default" id="btn-default_id3" style="padding:8px 18px;">下一年</a>
                </div>

                <div class="box box-warning">
                    <div class="box-header">
                        <h3 class="box-title">累计毛利率提升比率</h3>
                    </div><!-- /.box-header -->
                    <div class="box-body">

                        <table class="table table-bordered dataTable fontmini" id="tablecenter">
                            <tr role="row" class="orders" style="text-align:center;" >
                                <th class="black">年份</th>
                                <th class="black">总收入</th>
                                <th class="black">总毛利</th>
                                <th class="black">毛利率</th>
                                <th class="black" width="100">毛利率增长</th>
                            </tr>

                            <tr>
                                <td>{$year}年</td>
                                <td><a href="{:U('Manage/Manage_year')}">{$data.thisYear_zsr}</a></td>
                                <td>{$data.thisYear_zml}</td>
                                <td>{$data.thisYear_mll}%</td>
                                <td rowspan="2">{$elevate}</td>
                            </tr>
                            <tr>
                                <td>{$year-1}年</td>
                                <td><a href="{:U('Manage/Manage_year',array('year'=>$year-1))}">{$data.lastYear_zsr}</a></td>
                                <td>{$data.lastYear_zml}</td>
                                <td>{$data.lastYear_mll}%</td>
                            </tr>
                            <tr>
                                <td colspan="11" style="text-align: left;padding-left: 20px;">
                                    <p>
                                        说明：
                                        1、{$year}年数据取自{$year-1}年12月26日至{$year}年{$month}月<?php if (date('d') > 26){ echo '26'; }else{ echo date('d'); }; ?>日所有已结算项目数据；
                                        {$year-1}年数据取自{$year-2}年12月26日至{$year-1}年{$month}月<?php if (date('d') > 26){ echo '26'; }else{ echo date('d'); }; ?>日所有已结算项目数据。
                                    </p>
                                    <p>&emsp;&emsp;&emsp;2、截止目前，{$year}年总收入{$company_data.thisYear_zsr}元，总毛利{$company_data.thisYear_zml}，毛利率{$company_data.thisYear_mll}%。</p>
                                    <p>&emsp;&emsp;&emsp;3、表中{$year}年数据不包括“南北极合作”项目和“其他”项目。</p>
                                </td>
                            </tr>
                        </table><br><br>

                    </div><!-- /.box-body -->
                </div><!-- /.box -->

            </div><!--/.col (right) -->

        </div>   <!-- /.row -->

    </section><!-- /.content -->

</aside><!-- /.right-side -->


<include file="Index:footer2" />