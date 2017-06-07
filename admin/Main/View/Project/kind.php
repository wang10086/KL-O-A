<include file="Index:header2" />

            <aside class="right-side">
                <!-- Content Header (Page header) -->
                <section class="content-header">
                    <h1>
                        {$_pagetitle_}
                        <small>{$_pagedesc_}</small>
                    </h1>
                    <ol class="breadcrumb">
                        <li><a href="{:U('Index/index')}"><i class="fa fa-home"></i> 首页</a></li>
                        <li><a href="{:U('Project/index')}"><i class="fa fa-gift"></i> {$_pagetitle_}</a></li>
                        <li class="active">{$_action_}</li>
                    </ol>
                </section>

                <!-- Main content -->
                <section class="content">

                    <div class="row">
                        <div class="col-xs-12">
                            <div class="box">
                                <div class="box-header">
                                    <h3 class="box-title">{$_action_}</h3>
                                    <div class="box-tools pull-right">
                                         <a href="{:U('Project/addkind')}" class="btn btn-sm btn-danger"><i class="fa fa-plus"></i> 新增顶级分类</a>
                                    </div>
                                </div><!-- /.box-header -->
                                <div class="box-body">
<table class="table table-bordered dataTable fontmini" id="tablelist">
                                        <tr role="row" class="orders" >
                <th width="60">ID</th>
                <th>名称</th>
                <th width="100">级别</th>
                <th width="60" class="taskOptions">编辑</th>
                <th width="60" class="taskOptions">删除</th>
            </tr>
        <foreach name="lists" item="row">
            <tr>
                <td>{$row.id}</td>
                <td>{:tree_pad($row['level'])} {$row.name} <a class="pull-right" href="{:U('Project/addkind',array('pid'=>$row['id']))}"><i class="fa fa-plus"></i> 子分类</a>&nbsp; </td>
                <td>{$row.level}</td>
                <td class="taskOptions">
                <button onClick="javascript:window.location.href='{:U('Project/addkind',array('id'=>$row['id']))}';" title="修改" class="btn btn-info btn-smsm"><i class="fa fa-pencil"></i></button>
                </td>
                
                <td class="taskOptions">
                <button onClick="javascript:ConfirmDel('{:U('Project/delkind',array('id'=>$row['id']))}')" title="删除" class="btn btn-warning btn-smsm"><i class="fa fa-times"></i></button>
                </td>
                
            </tr>
        </foreach>										
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
