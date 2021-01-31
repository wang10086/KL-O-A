<include file="Index:header2" />

            <aside class="right-side">
                <!-- Content Header (Page header) -->
                <section class="content-header">
                    <h1>{$_pagetitle_}<small>资源所属项目部</small></h1>

                    <ol class="breadcrumb">
                        <li><a href="{:U('Index/index')}"><i class="fa fa-home"></i> 首页</a></li>
                        <li><a href="{:U('ScienceRes/index')}"><i class="fa fa-gift"></i> {$_pagetitle_}</a></li>
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
                                </div><!-- /.box-header -->
                                <div class="box-body">
                                <table class="table table-bordered dataTable fontmini" id="tablelist">
                                    <tr role="row" class="orders" >
                                        <th width="60" class="taskOptions">ID</th>
                                        <th>省份/城市</th>
                                        <th width="">所属项目部门</th>
                                        <if condition="rolemenu(array('ScienceRes/province_edit'))">
                                        <th width="50" class="taskOptions">设置</th>
                                        </if>
                                    </tr>
   
                                    <foreach name="list" item="row">
                                        <tr>
                                            <td class="taskOptions">{$row.id}</td>
                                            <td>{$row.name}  </td>
                                            <td>{$row.department}</td>
                                            <if condition="rolemenu(array('ScienceRes/province_edit'))">
                                            <td class="taskOptions">
                                            <a href="javascript:;" onClick="province_edit({$row.id})" title="设置" class="btn btn-info btn-smsm"><i class="fa fa-pencil"></i></a>
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
		art.dialog.open('index.php?m=Main&c=ScienceRes&a=province_edit&id='+id,{
			lock:true,
			title: '设置各省份资源所属项目部',
            id: 'audit_win',
			width:500,
			height:230,
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