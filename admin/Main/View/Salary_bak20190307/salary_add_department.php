<include file="Index:header2" />
<script src="__HTML__/js/public.js?v=1.0.6" type="text/javascript"></script>
<aside class="right-side">
    <section class="content-header">
        <h1>部门管理</h1>
        <ol class="breadcrumb">
            <li><a href="{:U('Index/index')}"><i class="fa fa-home"></i> 首页</a></li>
            <li><a href="javascript:;"><i class="fa fa-gift"></i> 部门管理</a></li>
        </ol>
    </section>

    <!-- Main content -->
    <section class="content">
        <div class="row">
            <!-- right column -->
            <div class="col-md-12">


                <div class="box box-warning">
                    <div class="box-header">
                        <h3 class="box-title">添加部门</h3>
                    </div><!-- /.box-header -->
                    <div class="box-body">
                        <div class="content">
                            <form action="{:U('Salary/salary_add_department')}" method="post">
                                <input type="hidden" name="dosubmint" value="1">
                                <p>添加部门: <input type="text" name="department" /></p>
                                <p>添加字母: <input type="text" name="letter" /></p>
                                <input type="submit" value="提交" />
                            </form>

                        </div>
                    </div><!-- /.box-body -->
                </div><!-- /.box -->

                <div class="box box-warning">
                    <div class="box-header">
                        <h3 class="box-title">部门列表</h3>
                    </div><!-- /.box-header -->
                    <div class="box-body">
                        <table class="table table-bordered dataTable fontmini" id="tablelist" style="margin-top:10px;">
                            <tr role="row" class="orders" >
                                <th class="sorting" width="80" data="o.op_id">ID</th>
                                <th class="sorting" data="o.status">部门名称</th>
                                <th class="sorting" data="o.project">部门字母</th>
                                <th class="taskOptions" width="100">编辑</th>
                            </tr>
                            <foreach name="lists" item="row">
                                <tr>
                                    <td>{$row.id}</td>
                                    <td>{$row.department}</td>
                                    <td>{$row.letter}</td>
                                    <if condition="rolemenu(array('Salary/edit_department'))">
                                        <td class="taskOptions">
                                            <button onClick="javascript:ConfirmDel('{:U('Salary/edit_department',array('id'=>$row['id']))}')" title="删除" class="btn btn-warning btn-smsm"><i class="fa fa-times"></i></button>
                                        </td>
                                    </if>
                                </tr>
                            </foreach>
                        </table>
                    </div><!-- /.box-body -->
                    <div class="box-footer clearfix">
                        <div class="pagestyle">{$pages}</div>
                    </div>
                </div><!-- /.box -->

            </div><!--/.col (right) -->
        </div>   <!-- /.row -->
    </section><!-- /.content -->

</aside>
<include file="Index:footer2" />