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
                        <li><a href="{:U('SupplierRes/res')}"><i class="fa fa-gift"></i> {$_pagetitle_}</a></li>
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
                                         <a href="{:U('SupplierRes/addreskind')}" class="btn btn-sm btn-danger"><i class="fa fa-plus"></i> 添加分类</a>
                                    </div>
                                </div><!-- /.box-header -->
                                <div class="box-body">
<table class="table table-bordered dataTable fontmini" id="tablelist">
                                        <tr role="row" class="orders" >
                <th>ID</th>
                <th>名称</th>
                <if condition="rolemenu(array('SupplierRes/addreskind'))">
                <th width="60" class="taskOptions">编辑</th>
                </if> 
                <if condition="rolemenu(array('SupplierRes/delreskind'))">
                <th width="60" class="taskOptions">删除</th>
                </if> 
            </tr>
        <foreach name="lists" item="row">
            <tr>
                <td>{$row.id}</td>
                <td>{$row.name}</td>
                <if condition="rolemenu(array('SupplierRes/addreskind'))">
                <td class="taskOptions">
                
                <button onClick="javascript:window.location.href='{:U('SupplierRes/addreskind',array('id'=>$row['id']))}';" title="修改" class="btn btn-info btn-smsm"><i class="fa fa-pencil"></i></button>
                
                </td>
                </if>
                <if condition="rolemenu(array('SupplierRes/delreskind'))">
                <td class="taskOptions">
                <button onClick="javascript:ConfirmDel('{:U('SupplierRes/delreskind',array('id'=>$row['id']))}')" title="删除" class="btn btn-warning btn-smsm"><i class="fa fa-times"></i></button>
                </td>
                </if>
                
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
