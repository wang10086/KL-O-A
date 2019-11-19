<include file="Index:header2" />

            <aside class="right-side">
                <!-- Content Header (Page header) -->
                <section class="content-header">
                    <h1>内部满意度评分人员设置</h1>

                    <ol class="breadcrumb">
                        <li><a href="{:U('Index/index')}"><i class="fa fa-home"></i> 首页</a></li>
                        <li><a href="{:U('Inspect/satisfaction')}"><i class="fa fa-gift"></i> 内部满意度</a></li>
                        <li class="active">{$_action_}</li>
                    </ol>
                </section>

                <!-- Main content -->
                <section class="content">

                    <div class="row">
                        <div class="col-xs-12">
                            <div class="box box-warning">
                                <div class="box-header">
                                    <h3 class="box-title">{$_action_}</h3>
                                    <div class="box-tools pull-right">
                                        <if condition="rolemenu(array('Inspect/satisfaction_user'))">
                                            <a href="javascript:;" onclick="province_edit()" class="btn btn-sm btn-info"><i class="fa fa-plus"></i> 添加被评分人</a>
                                        </if>
                                    </div>
                                </div><!-- /.box-header -->
                                <div class="box-body">
                                <table class="table table-bordered dataTable fontmini" id="tablelist">
                                    <tr role="row" class="orders" >
                                        <th width="60" class="taskOptions">ID</th>
                                        <th>姓名</th>
                                        <th width="">类型</th>
                                        <if condition="rolemenu(array('Inspect/satisfaction_user_edit'))">
                                        <th width="50" class="taskOptions">编辑</th>
                                        </if>
                                        <if condition="rolemenu(array('Inspect/satisfaction_user_del'))">
                                            <th width="50" class="taskOptions">删除</th>
                                        </if>
                                    </tr>
   
                                    <foreach name="list" item="row">
                                        <tr>
                                            <td class="taskOptions">{$row.id}</td>
                                            <td>{$row.account_name}  </td>
                                            <td><?php echo $row['type'] == 1 ? '管理岗' : '其他岗'; ?></td>
                                            <if condition="rolemenu(array('Inspect/satisfaction_user_edit'))">
                                            <td class="taskOptions">
                                            <a href="javascript:;" onClick="province_edit({$row.id})" title="编辑" class="btn btn-info btn-smsm"><i class="fa fa-pencil"></i></a>
                                            </td>
                                            </if>
                                            <if condition="rolemenu(array('Inspect/satisfaction_user_del'))">
                                                <td class="taskOptions">
                                                    <a href="javascript:;" onClick="ConfirmDel(`{:U('Inspect/satisfaction_user_del',array('id'=>$row['id']))}`)" title="删除" class="btn btn-danger btn-smsm"><i class="fa fa-times"></i></a>
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
	function province_edit(id) {
		art.dialog.open('index.php?m=Main&c=Inspect&a=satisfaction_user_edit&id='+id,{
			lock:true,
			title: '编辑被评分人',
            id: 'audit_win',
			width:600,
			height:260,
			okVal: '提交',
			fixed: true,
			ok: function () {
				this.iframe.contentWindow.gosubmint();
				return false;
			},
			cancelVal:'取消',
			cancel: function () {
			}
		});	
	}
	</script>