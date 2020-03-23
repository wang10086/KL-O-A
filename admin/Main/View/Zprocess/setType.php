<include file="Index:header2" />

            <aside class="right-side">
                <!-- Content Header (Page header) -->
                <section class="content-header">
                    <h1>
                        {$_pagetitle_}
                        <small>{$_action_}</small>
                    </h1>
                    <ol class="breadcrumb">
                        <li><a href="{:U('Zindex/index')}"><i class="fa fa-home"></i> 首页</a></li>
                        <li><a href="javascript:;"><i class="fa fa-gift"></i> {$_pagetitle_}</a></li>
                        <li class="active">{$_action_}</li>
                    </ol>
                </section>

                <!-- Main content -->
                <section class="content">

                    <div class="row">
                        <div class="col-xs-12">
                            <div class="box box-success">
                                <div class="box-header">
                                    <h3 class="box-title">{$_action_}</h3>
                                    <div class="box-tools pull-right">
                                         <!--<a href="{:U('Zprocess/addType')}" class="btn btn-sm btn-danger"><i class="fa fa-plus"></i> 新增</a>-->
                                         <a href="javascript:;" onclick="art_show_msg('开发中...')" class="btn btn-sm btn-danger"><i class="fa fa-plus"></i> 新增</a>
                                    </div>
                                </div><!-- /.box-header -->
                                <div class="box-body">
                                <table class="table table-bordered dataTable fontmini" id="tablelist">
                                    <tr role="row" class="orders" >
                                        <th class="taskOptions" width="60">ID</th>
                                        <th width="">名称</th>
                                        <th width="">流程说明</th>
                                        <th class="taskOptions" width="80">操作</th>
                                    </tr>

                                    <tr>
                                        <td>1</td>
                                        <td>LTC主干流程 </td>
                                        <td>{$row.level}</td>
                                        <td>
                                        <a href="javascript:;">修改</a>&nbsp; | &nbsp;
                                        <a href="javascript:;">删除</a>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>3</td>
                                        <td>├ &emsp; 测试流程1</td>
                                        <td>{$row.level}</td>
                                        <td>
                                            <a href="javascript:;">修改</a>&nbsp; | &nbsp;
                                            <a href="javascript:;">删除</a>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>2</td>
                                        <td>IPD流程 </td>
                                        <td>{$row.level}</td>
                                        <td>
                                            <a href="javascript:;">修改</a>&nbsp; | &nbsp;
                                            <a href="javascript:;">删除</a>
                                        </td>
                                    </tr>

                                </table>
                                </div><!-- /.box-body -->
                                <div class="box-footer clearfix">
                                    <ul class="pagination pagination-sm no-margin pull-right">
                                        {$pages}
                                    </ul>
                                </div>
                            </div><!-- /.box -->

                        </div><!-- /.col -->
                     </div>

                </section><!-- /.content -->
            </aside><!-- /.right-side -->

<include file="Index:footer2" />
