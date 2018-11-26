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
                    <?php
                    for($i=1;$i<13;$i++){
                        echo '<a href="'.U('Manage/Manage_month',array('month'=>$i)).'" class="btn btn-default" style="padding:8px 18px;">'.$i.'月</a>';
                    }
                    ?>
                    <a href="{:U('Manage/Manage_month',array('year'=>$nextyear,'month'=>'01','post'=>$post))}" class="btn btn-default" style="padding:8px 18px;">下一年</a>
                </div>

                <div class="box box-warning">
                    <div class="box-header">
                        <h3 class="box-title">季度经营报表</h3>
                    </div><!-- /.box-header -->
                    <div class="box-body">

                        <table class="table table-bordered dataTable fontmini" id="tablecenter">
                            <tr role="row" class="orders" style="text-align:center;" >
                                <th style="width:10em;"><b>项目</b></th>
                                <th style="width:10em;"><b>公司</b></th>
                                <th style="width:15em;">
                                    <p><b>京区业务中心</b></p>
                                    <p style="border-top:1px solid #ddd;margin:0em -0.7em 1em -0.7em;">
                                    <center style="margin-bottom: -0.9em;">
                                        <a style="padding: 1em;margin-right: -0.3em;border-right:1px solid #ddd;">数额</a>
                                        <a style="text-align:center;padding: 1em;">占比</a>
                                    </center>
                                    </p>
                                </th>
                                <th style="width:15em;">
                                    <p><b>京外业务中心</b></p>
                                    <p style="border-top:1px solid #ddd;margin:0em -0.7em 1em -0.7em;">
                                    <center style="margin-bottom: -0.9em;">
                                        <a style="padding: 1em;margin-right: -0.3em;border-right:1px solid #ddd;">数额</a>
                                        <a style="text-align:center;padding: 1em;">占比</a>
                                    </center>
                                    </p>
                                </th>
                                <th style="width:15em;">
                                    <p><b>南京项目部</b></p>
                                    <p style="border-top:1px solid #ddd;margin:0em -0.7em 1em -0.7em;">
                                    <center style="margin-bottom: -0.9em;">
                                        <a style="padding: 1em;margin-right: -0.3em;border-right:1px solid #ddd;">数额</a>
                                        <a style="text-align:center;padding: 1em;">占比</a>
                                    </center>
                                    </p>
                                </th>
                                <th style="width:15em;">
                                    <p><b>武汉项目部</b></p>
                                    <p style="border-top:1px solid #ddd;margin:0em -0.7em 1em -0.7em;">
                                    <center style="margin-bottom: -0.9em;">
                                        <a style="padding: 1em;margin-right: -0.3em;border-right:1px solid #ddd;">数额</a>
                                        <a style="text-align:center;padding: 1em;">占比</a>
                                    </center>
                                    </p>
                                </th>
                                <th style="width:15em;">
                                    <p><b>沈阳项目部</b></p>
                                    <p style="border-top:1px solid #ddd;margin:0em -0.7em 1em -0.7em;">
                                    <center style="margin-bottom: -0.9em;">
                                        <a style="padding: 1em;margin-right: -0.3em;border-right:1px solid #ddd;">数额</a>
                                        <a style="text-align:center;padding: 1em;">占比</a>
                                    </center>
                                    </p>
                                </th>
                                <th style="width:15em;">
                                    <p><b>长春项目部</b></p>
                                    <p style="border-top:1px solid #ddd;margin:0em -0.7em 1em -0.7em;">
                                    <center style="margin-bottom: -0.9em;">
                                        <a style="padding: 1em;margin-right: -0.3em;border-right:1px solid #ddd;">数额</a>
                                        <a style="text-align:center;padding: 1em;">占比</a>
                                    </center>
                                    </p>
                                </th>
                                <th style="width:15em;">
                                    <p><b>市场部</b></p>
                                    <p style="border-top:1px solid #ddd;margin:0em -0.7em 1em -0.7em;">
                                    <center style="margin-bottom: -0.9em;">
                                        <a style="padding: 1em;margin-right: -0.3em;border-right:1px solid #ddd;">数额</a>
                                        <a style="text-align:center;padding: 1em;">占比</a>
                                    </center>
                                    </p>
                                </th>
                            </tr>

                            <tr role="row" class="orders" style="text-align:center;">
                                <td>员工人数</td>
                                <td>1</td>
                                <td>1</td>
                                <td>{$f['file']['id']}</td>
                                <td>1</td>
                                <td>{$f['file']['id']}</td>
                                <td>{$f['file']['account_name']}</td>
                                <td>{$f['file']['id']}</td>
                                <td>{$f['file']['account_name']}</td>
                            </tr>
                            <tr role="row" class="orders" style="text-align:center;">
                                <td>营业收入</td>
                                <td>1</td>
                                <td>1</td>
                                <td>{$f['file']['id']}</td>
                                <td>1</td>
                                <td>{$f['file']['id']}</td>
                                <td>{$f['file']['account_name']}</td>
                                <td>{$f['file']['id']}</td>
                                <td>{$f['file']['account_name']}</td>
                            </tr>
                            <tr role="row" class="orders" style="text-align:center;">
                                <td>营业毛利</td>
                                <td>1</td>
                                <td>1</td>
                                <td>{$f['file']['id']}</td>
                                <td>1</td>
                                <td>{$f['file']['id']}</td>
                                <td>{$f['file']['account_name']}</td>
                                <td>{$f['file']['id']}</td>
                                <td>{$f['file']['account_name']}</td>
                            </tr>
                            <tr role="row" class="orders" style="text-align:center;">
                                <td>营业利率(%)</td>
                                <td>1</td>
                                <td>1</td>
                                <td>{$f['file']['id']}</td>
                                <td>1</td>
                                <td>{$f['file']['id']}</td>
                                <td>{$f['file']['account_name']}</td>
                                <td>{$f['file']['id']}</td>
                                <td>{$f['file']['account_name']}</td>
                            </tr>
                            <tr role="row" class="orders" style="text-align:center;">
                                <td>人力资源成本</td>
                                <td>1</td>
                                <td>1</td>
                                <td>{$f['file']['id']}</td>
                                <td>1</td>
                                <td>{$f['file']['id']}</td>
                                <td>{$f['file']['account_name']}</td>
                                <td>{$f['file']['id']}</td>
                                <td>{$f['file']['account_name']}</td>
                            </tr>
                            <tr role="row" class="orders" style="text-align:center;">
                                <td>其他费用</td>
                                <td>1</td>
                                <td>1</td>
                                <td>{$f['file']['id']}</td>
                                <td>1</td>
                                <td>{$f['file']['id']}</td>
                                <td>{$f['file']['account_name']}</td>
                                <td>{$f['file']['id']}</td>
                                <td>{$f['file']['account_name']}</td>
                            </tr>
                            <tr role="row" class="orders" style="text-align:center;">
                                <td>利润总额</td>
                                <td>1</td>
                                <td>1</td>
                                <td>{$f['file']['id']}</td>
                                <td>1</td>
                                <td>{$f['file']['id']}</td>
                                <td>{$f['file']['account_name']}</td>
                                <td>{$f['file']['id']}</td>
                                <td>{$f['file']['account_name']}</td>
                            </tr>
                            <tr role="row" class="orders" style="text-align:center;">
                                <td>人事费用率</td>
                                <td>1</td>
                                <td>1</td>
                                <td>{$f['file']['id']}</td>
                                <td>1</td>
                                <td>{$f['file']['id']}</td>
                                <td>{$f['file']['account_name']}</td>
                                <td>{$f['file']['id']}</td>
                                <td>{$f['file']['account_name']}</td>
                            </tr>

                        </table><br><br>

                    </div><!-- /.box-body -->
                </div><!-- /.box -->

            </div><!--/.col (right) -->

        </div>   <!-- /.row -->

    </section><!-- /.content -->

</aside><!-- /.right-side -->

</div>
</div>

<include file="Index:footer2" />

