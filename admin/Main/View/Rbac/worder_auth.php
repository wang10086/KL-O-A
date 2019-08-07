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
                        <li><a href="{:U('Rbac/pdca_auth')}"><i class="fa fa-gift"></i> {$_pagetitle_}</a></li>
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
                                    
                                </div><!-- /.box-header -->
                                <div class="box-body">
                                <table class="table table-bordered dataTable fontmini" id="tablelist">
                                    <tr role="row" class="orders" >
                                        <th width="60">ID</th>
                                        <!--<th>标识</th>-->
                                        <th>部门角色</th>
                                        <th width="120">工单指派人</th>
                                        <if condition="rolemenu(array('Rbac/op_pdca_auth'))">
                                        <th width="50" class="taskOptions">设置</th>
                                        </if>
                                    </tr>
   
                                    <foreach name="roles" item="row">
                                        <tr>
                                            <td>{$row.id}</td>
                                            <!--<td>{$row.name}</td>-->
                                            <td>{:tree_pad($row['level'])} {$row.role_name}  </td>
                                            <td>{$row.worder}</td>
                                            <if condition="rolemenu(array('Rbac/op_worder_auth'))">
                                            <td class="taskOptions">
                                            <a href="javascript:;" onClick="op_worder_auth({$row.id})" title="设置" class="btn btn-info btn-smsm"><i class="fa fa-pencil"></i></a>
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
	<script>
    //编辑PDCA项目
	function op_worder_auth(id) {
		var pdcaid = '{$pdca.id}';
		art.dialog.open('index.php?m=Main&c=Rbac&a=op_worder_auth&id='+id,{
			lock:true,
			title: '指定部门工单执行人',
			width:800,
			height:400,
			okValue: '提交',
			fixed: true,
			ok: function () {
				this.iframe.contentWindow.gosubmint();
				return false;
			},
			cancelValue:'取消',
			cancel: function () {
			}
		});	
	}
	</script>