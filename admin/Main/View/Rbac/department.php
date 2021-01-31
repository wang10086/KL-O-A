<include file="Index:header2" />

            <aside class="right-side">
                <!-- Content Header (Page header) -->
                <section class="content-header">
                    <h1>
                        部门管理 <small></small>
                    </h1>
                    <ol class="breadcrumb">
                        <li><a href="{:U('Index/index')}"><i class="fa fa-home"></i> 首页</a></li>
                        <li><a href="{:U('Rbac/department')}"><i class="fa fa-gift"></i> 部门管理</a></li>
                        <li class="active">部门列表</li>
                    </ol>
                </section>

                <!-- Main content -->
                <section class="content">

                    <div class="row">
                        <div class="col-xs-12">
                            <div class="box box-warning">
                                <div class="box-header">
                                    <h3 class="box-title">部门列表</h3>
                                    <if condition="rolemenu(array('Rbac/add_department'))">
                                    <div class="box-tools pull-right">
                                    	<a href="javascript:;" class="btn btn-info btn-sm" onclick="javascript:opensearch('searchtext',500,150);"><i class="fa fa-search"></i> 搜索</a>
                                        <a href="javascript:;" onClick="javascript:open_department(`{:U('Rbac/add_department',array('id'=>$row['id']))}`)" ><button onClick="javascript:;" title="修改" class="btn btn-sm btn-success"><i class="fa fa-plus"></i> 新增部门</button></a>
                                    </div>
                                    </if>
                                </div><!-- /.box-header -->
                                <div class="box-body">
                                    <table class="table table-bordered dataTable fontmini" id="tablelist" style="margin-top:10px;">
                                        <tr role="row" class="orders" >
                                            <th class="sorting" width="80" data="id">ID</th>
                                            <th class="sorting" data="department">部门名称</th>
                                            <th class="sorting taskOptions" data="letter" width="100">部门字母</th>
                                            <th class="sorting taskOptions" data="letter" width="100">团号编码</th>
                                            <if condition="rolemenu(array('Rbac/add_department'))">
                                            <th class="taskOptions" width="100">编辑</th>
                                            </if>
                                            <if condition="rolemenu(array('Rbac/del_department'))">
                                            <th class="taskOptions" width="100">删除</th>
                                            </if>
                                        </tr>
                                        <foreach name="lists" item="row">
                                            <tr>
                                                <td>{$row.id}</td>
                                                <td>{$row.department}</td>
                                                <td class="taskOptions">{$row.letter}</td>
                                                <td class="taskOptions">{$row.groupno}</td>
                                                <if condition="rolemenu(array('Rbac/add_department'))">
                                                    <td class="taskOptions">
                                                        <a href="javascript:;" onClick="javascript:open_department(`{:U('Rbac/add_department',array('id'=>$row['id']))}`)" ><button onClick="javascript:;" title="修改" class="btn btn-info btn-smsm"><i class="fa fa-pencil"></i></button></a>
                                                    </td>
                                                </if>
                                                <if condition="rolemenu(array('Rbac/del_department'))">
                                                    <td class="taskOptions">
                                                        <button onClick="javascript:ConfirmDel(`{:U('Rbac/del_department',array('id'=>$row['id']))}`)" title="删除" class="btn btn-warning btn-smsm"><i class="fa fa-times"></i></button>
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
            
            
            <div id="searchtext">
                <form action="" method="post" id="searchform">
                <input type="hidden" name="m" value="Main">
                <input type="hidden" name="c" value="Rbac">
                <input type="hidden" name="a" value="department">
                <div class="form-group col-md-12"></div>
                <div class="form-group col-md-12">
                    <input type="text" class="form-control" name="key" placeholder="部门名称">
                </div>

                </form>
            </div>

<include file="Index:footer2" />

<script type="text/javascript">
    function open_department (obj) {
        art.dialog.open(obj, {
            lock:true,
            id:'audit_win',
            title: '部门管理',
            width:600,
            height:300,
            okValue: '提交',
            ok: function () {
                this.iframe.contentWindow.gosubmint();
                return false;
            },
            cancelValue:'取消',
            cancel: function () {
            },
            close:function(){
                art.dialog.open.origin.location.reload();
            }
        });
    }
</script>
