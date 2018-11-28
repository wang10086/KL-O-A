<include file="Index:header2" />

<aside class="right-side">

    <section class="content-header">
        <h1><?php echo date('Y',time());?>季度经营报表</h1>
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
                    <a href="{:U('Manage/Manage_month',array('year'=>$prveyear,'month'=>'01','post'=>$post))}" class="btn btn-default" style="padding:8px 18px;">上一年</a>
                    <a href="'.U('Manage/Manage_month',array('month'=>1)).'" class="btn btn-default" style="padding:8px 18px;">第一季度</a>
                    <a href="'.U('Manage/Manage_month',array('month'=>2)).'" class="btn btn-default" style="padding:8px 18px;">第二季度</a>
                    <a href="'.U('Manage/Manage_month',array('month'=>3)).'" class="btn btn-default" style="padding:8px 18px;">第三季度</a>
                    <a href="'.U('Manage/Manage_month',array('month'=>4)).'" class="btn btn-default" style="padding:8px 18px;">第四季度</a>
                    <a href="{:U('Manage/Manage_month',array('year'=>$nextyear,'month'=>'01','post'=>$post))}" class="btn btn-default" style="padding:8px 18px;">下一年</a>
                </div>

                <div class="box box-warning">
                    <div class="box-header">
                        <h3 class="box-title">季度经营报表</h3>
                    </div><!-- /.box-header -->
                    <div class="box-body">

                        <table class="table table-bordered dataTable fontmini" id="tablecenter">
                            <tr role="row" class="orders" style="text-align:center;" >
                                <th style="width:10em;" rowspan="2"><b>项目</b></th>
                                <th style="width:10em;" rowspan="2"><b>公司</b></th>
                                <th style="width:10em;" colspan="2"><b>京区业务中心</b></th>
                                <th style="width:10em;" colspan="2"><b>京外业务中心</b></th>
                                <th style="width:10em;" colspan="2"><b>南京项目部</b></th>
                                <th style="width:10em;" colspan="2"><b>武汉项目部</b></th>
                                <th style="width:10em;" colspan="2"><b>沈阳项目部</b></th>
                                <th style="width:10em;" colspan="2"><b>长春项目部</b></th>
                                <th style="width:10em;" colspan="2"><b>市场部</b></th>
                            </tr>
                            <tr role="row" class="orders" style="text-align:center;">
                                <?php for($i=0;$i<7;$i++){?>
                                    <td>数额</td>
                                    <td>占比</td>
                                <?php } ?>
                            </tr>

                            <tr role="row" class="orders" style="text-align:center;">
                                <td>员工人数</td>
                                <td>{$number[0]['employees_sum']}</td>
                                <td>{$number[1]['employees_sum']}</td>
                                <td>{$number[1]['proportion']}</td>
                                <td>{$number[2]['employees_sum']}</td>
                                <td>{$number[2]['proportion']}</td>
                                <td>{$number[3]['employees_sum']}</td>
                                <td>{$number[3]['proportion']}</td>
                                <td>{$number[4]['employees_sum']}</td>
                                <td>{$number[4]['proportion']}</td>
                                <td>{$number[5]['employees_sum']}</td>
                                <td>{$number[5]['proportion']}</td>
                                <td>{$number[6]['employees_sum']}</td>
                                <td>{$number[6]['proportion']}</td>
                                <td>{$number[7]['employees_sum']}</td>
                                <td>{$number[7]['proportion']}</td>
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
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
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
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                            </tr>
                            <tr role="row" class="orders" style="text-align:center;">
                                <td>营业利率</td>
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
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
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
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
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
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
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
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
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
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                            </tr>
                        </table><br><br>

                    </div><!-- /.box-body -->
                </div><!-- /.box -->

            </div><!--/.col (right) -->

        </div>   <!-- /.row -->

    </section><!-- /.content -->

</aside><!-- /.right-side -->


<include file="Index:footer2" />

