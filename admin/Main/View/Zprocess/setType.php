<include file="Index:header2" />

            <aside class="right-side">
                <!-- Content Header (Page header) -->
                <section class="content-header">
                    <h1>
                        {$_pagetitle_}
                        <small>{$_action_}</small>
                    </h1>
                    <ol class="breadcrumb">
                        <li><a href="{:U('Zprocess/public_index')}"><i class="fa fa-home"></i> 首页</a></li>
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
                                        <if condition="rolemenu(array('Zprocess/addType'))">
                                         <a href="javascript:;" onclick="add_type()" class="btn btn-sm btn-danger"><i class="fa fa-plus"></i> 新增</a>
                                        </if>
                                    </div>
                                </div><!-- /.box-header -->
                                <div class="box-body">
                                <table class="table table-bordered dataTable fontmini" id="tablelist">
                                    <tr role="row" class="orders" >
                                        <th class="taskOptions" width="60">ID</th>
                                        <th width="">名称</th>
                                        <!--<th width="">流程说明</th>-->
                                        <th class="taskOptions" width="80">操作</th>
                                    </tr>

                                    <foreach name="lists" key="k" item="v">
                                        <tr>
                                            <td>{$v.id}</td>
                                            <td>{$v.title} <!--<a class="pull-right" href="javascript:;"><i class="fa fa-plus"></i> 子类型</a>&nbsp;--></td>
                                            <!--<td>{$row.level}</td>-->
                                            <td>
                                                <if condition="rolemenu(array('Zprocess/addType'))">
                                                <a href="javascript:;" onclick="add_type({$v.id})">修改</a>&nbsp; | &nbsp;
                                                </if>
                                                <if condition="rolemenu(array('Zprocess/delType'))">
                                                <a href="javascript:;" onclick="ConfirmDel(`/index.php?m=Main&c=Zprocess&a=delType&id=`+{$v.id})">删除</a>
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
    function add_type (id) {
        art.dialog.open('/index.php?m=Main&c=Zprocess&a=addType&id='+id, {
            lock:true,
            id: 'audit_win',
            title: '编辑流程类型',
            width:500,
            height:200,
            okVal: '提交',
            ok: function () {
                this.iframe.contentWindow.gosubmint();
                setTimeout("parent.art.dialog.list['audit_win'].close()",1500);
                //parent.art.dialog.list["audit_win"].close();
                return false;
            },
            cancelVal:'取消',
            cancel: function () {},
            close : function () {
                location.reload();
            }
        });
    }
</script>
