<include file="Index:header2" />

            <aside class="right-side">
                <!-- Content Header (Page header) -->
                <section class="content-header">
                    <h1>
                        部门信息
                        <small>部门借款审核人</small>
                    </h1>
                    <ol class="breadcrumb">
                        <li><a href="{:U('Index/index')}"><i class="fa fa-home"></i> 首页</a></li>
                        <li><a href="{:U('Rbac/pdca_auth')}"><i class="fa fa-gift"></i> {$_pagetitle_}</a></li>
                        <li class="active">部门借款审核人</li>
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
                                        <th width="100">标识</th>
                                        <th>部门名称</th>
                                        <th width="120">借款审核人</th>
                                        <if condition="rolemenu(array('Finance/set_jiekuan_user'))">
                                        <th width="50" class="taskOptions">设置</th>
                                        </if>
                                    </tr>
   
                                    <foreach name="departments" item="row">
                                        <tr>
                                            <td>{$row.id}</td>
                                            <td>{$row.letter}</td>
                                            <td>{:tree_pad($row['level'])} {$row.department}  </td>
                                            <td>{$row.jk_audit_user_name}</td>
                                            <if condition="rolemenu(array('Rbac/set_jiekuan_user'))">
                                            <td class="taskOptions">
                                            <a href="javascript:;" onClick="set_jiekuan_user({$row.id})" title="设置" class="btn btn-info btn-smsm"><i class="fa fa-pencil"></i></a>
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
	function set_jiekuan_user(id) {
		art.dialog.open('index.php?m=Main&c=Finance&a=set_jiekuan_user&id='+id,{
			lock:true,
			title: '指定部门借款审核人',
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