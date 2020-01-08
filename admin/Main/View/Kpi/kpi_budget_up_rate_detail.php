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
                <div class="box box-warning">
                    <div class="box-header">
                        <h3 class="box-title">{$department}</h3>
                    </div><!-- /.box-header -->
                    <div class="box-body">

                        <table class="table table-bordered dataTable fontmini" id="tablecenter">
                            <tr role="row" class="orders" style="text-align:center;" >
                                <th class="">项目编号</th>
                                <th class="">团号</th>
                                <th class="">项目名称</th>
                                <th class="">毛利</th>
                                <th class="">销售</th>
                                <th class="">结算时间</th>
                            </tr>
                            <foreach name="lists" item="v">
                                <tr>
                                    <td>{$v.op_id}</td>
                                    <td>{$v.group_id}</td>
                                    <td>{$v.project}</td>
                                    <td>{$v.maoli}</td>
                                    <td>{$v.create_user_name}</td>
                                    <td>{$v.audit_time|date="Y-m-d H:i:s",###}</td>
                                </tr>
                            </foreach>
                        </table><br><br>
                    </div><!-- /.box-body -->

                    <div class="box-footer clearfix">
                        <div class="pagestyle">{$pages}</div>
                    </div>
                </div><!-- /.box -->

            </div><!--/.col (right) -->

        </div>   <!-- /.row -->

    </section><!-- /.content -->

</aside><!-- /.right-side -->


<include file="Index:footer2" />