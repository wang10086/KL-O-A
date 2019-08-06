<include file="Index:header2" />
<style>
    #btn-default_1{
        background-color:#00acd6;
    }
</style>
<aside class="right-side">

    <section class="content-header">
        <h1><a ></a>{$title}<small>{$year}年{$month}月</small></h1>
        <ol class="breadcrumb">
            <li><a href="{:U('Index/index')}"><i class="fa fa-home"></i> 首页</a></li>
            <li><a href="javascript:;"><i class="fa fa-gift"></i> {$title}</a></li>
        </ol>
    </section>

    <!-- Main content -->
    <section class="content">

        <div class="row">
            <!-- right column -->
            <div class="col-md-12">
                <div class="box box-warning">
                    <div class="box-header">
                        <h3 class="box-title">{$title}</h3>
                        <h3 class="box-title pull-right">
                            <span class=" green">被考核人：{$userinfo.nickname}</span>
                        </h3>
                    </div><!-- /.box-header -->
                    <div class="box-body">

                        <table class="table table-bordered dataTable fontmini" id="tablecenter">
                            <tr role="row" class="orders" style="text-align:center;" >
                                <th class="black">实施专家</th>
                                <th class="black">基本工资</th>
                                <th class="black">1.5倍工资</th>
                                <th class="black">业绩贡献</th>
                                <th class="black" width="80">业绩贡献度</th>
                            </tr>

                            <foreach name="lists" item="v">
                                <tr>
                                    <td>{$v.uasrname}</td>
                                    <td>{$v.salary}</td>
                                    <td>{$v.t_salary}</td>
                                    <td>{$v.profit}</td>
                                    <td>{$v.complete}</td>
                                </tr>
                            </foreach>

                            <tr class="black">
                                <td>合计</td>
                                <td>{$data.sum_salary}</td>
                                <td>{$data.sum_base_wages}</td>
                                <td>{$data.sum_profit}</td>
                                <td>{$data.complete}</td>
                            </tr>
                        </table><br><br>

                    </div><!-- /.box-body -->
                </div><!-- /.box -->

            </div><!--/.col (right) -->

        </div>   <!-- /.row -->

    </section><!-- /.content -->

</aside><!-- /.right-side -->


<include file="Index:footer2" />