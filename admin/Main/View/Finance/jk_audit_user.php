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
                                        <th width="100">部门经理(主管)</th>
                                        <th width="100">借款审核人</th>
                                        <th width="100">部门分管领导</th>
                                        <th width="100">线控负责人</th>
                                    </tr>
   
                                    <foreach name="departments" item="row">
                                        <tr>
                                            <td>{$row.id}</td>
                                            <td>{$row.letter}</td>
                                            <td>{:tree_pad($row['level'])} {$row.department}  </td>
                                            <td>{$row.manager_name}
                                                <if condition="rolemenu(array('Finance/set_manager'))">
                                                    <span style="float: right; clear: both;"><a href="javascript:;" onClick="set_user({$row.id},'set_manager','设置部门主管')" title="设置部门主管" class="btn btn-info btn-smsm"><i class="fa fa-pencil"></i></a></span>
                                                </if>
                                            </td>
                                            <td>{$row.jk_audit_user_name}
                                                <if condition="rolemenu(array('Finance/set_jiekuan_user'))">
                                                <span style="float: right; clear: both;"><a href="javascript:;" onClick="set_user({$row.id},'set_jiekuan_user','设置部门借款审核人')" title="设置借款审核人" class="btn btn-info btn-smsm"><i class="fa fa-pencil"></i></a></span>
                                                </if>
                                            </td>
                                            <td>{$row.boss_name}
                                                <if condition="rolemenu(array('Finance/set_depart_boss'))">
                                                    <span style="float: right; clear: both;"><a href="javascript:;" onClick="set_user({$row.id},'set_depart_boss','设置部门分管领导')" title="设置部门分管领导" class="btn btn-info btn-smsm"><i class="fa fa-pencil"></i></a></span>
                                                </if>
                                            </td>
                                            <td>{$row.line_blame_name}
                                                <if condition="rolemenu(array('Finance/set_line_blame'))">
                                                    <span style="float: right; clear: both;"><a href="javascript:;" onClick="set_user({$row.id},'set_line_blame','设置部门线控负责人')" title="设置部门线控负责人" class="btn btn-info btn-smsm"><i class="fa fa-pencil"></i></a></span>
                                                </if>
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
	<script type="text/javascript">
    function set_user(id,action,title=''){
        let url = 'index.php?m=Main&c=Finance&a='+ action +'&id='+id;
        art.dialog.open(url,{
            lock:true,
            title: title != '' ? title : '设置人员信息',
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