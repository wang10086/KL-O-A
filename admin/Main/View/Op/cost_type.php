<include file="Index:header2" />

    <aside class="right-side">
        <!-- Content Header (Page header) -->
        <section class="content-header">
            <h1>{$_action_}</h1>
            <ol class="breadcrumb">
                <li><a href="{:U('Index/index')}"><i class="fa fa-home"></i> 首页</a></li>
                <li><a href="{:U('Rbac/index')}"><i class="fa fa-gift"></i> {$_pagetitle_}</a></li>
                <li class="active">{$_action_}</li>
            </ol>
        </section>

        <!-- Main content -->
        <section class="content">
            <div class="row">
                <div class="col-xs-12">
                    <div class="box">
                        <div class="box-header">
                            <h3 class="box-title">费用项列表</h3>
                            <div class="box-tools pull-right">
                                    <a href="javascript:;" class="btn btn-success btn-sm" onclick="javascript:open_edit_cost_type(`{:U('Op/edit_cost_type')}`);"><i class="fa fa-plus"></i> 添加</a>
                            </div>
                        </div><!-- /.box-header -->
                        <div class="box-body">
                        <table class="table table-bordered dataTable fontmini" id="tablelist" style="margin-top:10px;">
                            <tr role="row" class="orders" >
                                <th class="sorting" width="80" data="id">编号</th>
                                <th class="sorting" data="name">费用项</th>
                                <if condition="rolemenu(array('Op/edit_cost_type'))">
                                <th width="40" class="taskOptions">编辑</th>
                                </if>

                                <if condition="rolemenu(array('Op/del_cost_type'))">
                                <th width="40" class="taskOptions">删除</th>
                                </if>
                            </tr>
                            <foreach name="lists" item="row">
                            <tr>
                                <td>{$row.id}</td>
                                <td>{$row.name}</td>
                                <if condition="rolemenu(array('Op/edit_cost_type'))">
                                <td class="taskOptions">
                                <a href="javascript:;" onclick="javascript:open_edit_cost_type(`{:U('Op/edit_cost_type',array('id'=>$row['id']))}`);" title="编辑" class="btn btn-info btn-smsm"><i class="fa fa-pencil"></i></a>
                                </td>
                                </if>
                                <if condition="rolemenu(array('Op/del_cost_type'))">
                                <td class="taskOptions">
                                <button onClick="javascript:ConfirmDel('{:U('Op/del_cost_type',array('id'=>$row['id']))}')" title="删除" class="btn btn-warning btn-smsm"><i class="fa fa-times"></i></button>
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

                </div><!-- /.col -->
                </div>

        </section><!-- /.content -->
    </aside><!-- /.right-side -->

<include file="Index:footer2" />

<script type="text/javascript">
function open_edit_cost_type (url) {
	art.dialog.open(url, {
		lock:true,
		title: '编辑费用项',
		width:600,
		height:300,
		okVal: '提交',
		ok: function () {
            this.iframe.contentWindow.gosubmint();
            this.close();
			return false;
		},
		cancelValue:'取消',
		cancel: function () {},
        close: function () {
            art.dialog.open.origin.location.reload();
        }
	});
}
</script>
