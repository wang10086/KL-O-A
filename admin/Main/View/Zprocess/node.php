<include file="Index:header2" />

            <aside class="right-side">
                <!-- Content Header (Page header) -->
                <section class="content-header">
                    <h1>{$_action_}</h1>
                    <ol class="breadcrumb">
                        <li><a href="{:U('Zprocess/public_index')}"><i class="fa fa-home"></i> 首页</a></li>
                        <li><a href="{:U('Zprocess/process')}"><i class="fa fa-gift"></i> {$_pagetitle_}</a></li>
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
                                    	 <a href="javascript:;" class="btn btn-info btn-sm" onclick="javascript:opensearch('searchtext',500,200);"><i class="fa fa-search"></i> 搜索</a>
                                        <if condition="rolemenu(array('Zprocess/addNode'))">
                                        <a href="{:U('Zprocess/addNode')}" class="btn btn-sm btn-success"><i class="fa fa-plus"></i> 录入节点</a>
                                        </if>
                                    </div>
                                </div><!-- /.box-header -->
                                <div class="box-body">
                                <table class="table table-bordered dataTable fontmini" id="tablelist" style="margin-top:10px;">
                                    <tr role="row" class="orders" >
                                        <th class="taskOptions" width="60">ID</th>
                                        <th class="sorting" data="title">工作事项</th>
                                        <th class="sorting" data="job">责任人职务</th>
                                        <th class="sorting" data="blame_uid">责任人</th>
                                        <th class="sorting" data="day">所需天数</th>
                                        <th class="sorting" data="time_data">完成时点</th>
                                        <th class="sorting" data="OK_data">完成依据</th>
                                        <th class="sorting" data="before_remind">是否提前提醒</th>
                                        <th class="sorting" data="after_remind">是否超时提醒</th>
                                        <th class="sorting" data="feedback_uid">完成后反馈对象</th>
                                        <th class="sorting" data="remark">备注</th>
                                        <if condition="rolemenu(array('Rbac/node'))">
                                            <th width="80" class="taskOptions">URL连接</th>
                                        </if>

                                        <if condition="rolemenu(array('Zprocess/addNode'))">
                                        <th width="40" class="taskOptions">编辑</th>
                                        </if>

                                        <if condition="rolemenu(array('Zprocess/delNode'))">
                                        <th width="40" class="taskOptions">删除</th>
                                        </if>
                                    </tr>
                                    <foreach name="lists" item="row">
                                    <tr>
                                        <td class="taskOptions">{$row.id}</td>
                                        <td><a href="javascript:;">{$row.title}</a></td>
                                        <td>{$row.job}</td>
                                        <td class="taskOptions">{$row.blame_name}</td>
                                        <td class="taskOptions">{$row.day}</td>
                                        <!--<td><div class="tdbox_long" title="{$row.time_data}">{$row.time_data}</div></td>-->
                                        <td>{$row.time_data}</td>
                                        <td>{$row.OK_data}</td>
                                        <td class="taskOptions">{$row['before_remind']?'提醒':'不提醒'}</td>
                                        <td class="taskOptions">{$row['after_remind']?'提醒':'不提醒'}</td>
                                        <td class="taskOptions">{$row.feedback_name}</td>
                                        <td>{$row.remark}</td>
                                        <if condition="rolemenu(array('Rbac/node'))">
                                            <td class="taskOptions">{$row.node_url}<br /><a href="javascript:;" onclick= set_node_url({$row.id})>编辑</a></td>
                                        </if>

                                        <if condition="rolemenu(array('Zprocess/addNode'))">
                                        <td class="taskOptions">
                                        <a href="{:U('Zprocess/addNode',array('id'=>$row['id']))}" title="编辑" class="btn btn-info btn-smsm"><i class="fa fa-pencil"></i></a>
                                        </td>
                                        </if>
                                        <if condition="rolemenu(array('Zprocess/delNode'))">
                                        <td class="taskOptions">
                                        <button onClick="javascript:ConfirmDel(`{:U('Zprocess/delNode',array('id'=>$row['id']))}`)" title="删除" class="btn btn-warning btn-smsm"><i class="fa fa-times"></i></button>
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
                <form action="" method="get" id="searchform">
                <input type="hidden" name="m" value="Main">
                <input type="hidden" name="c" value="Zprocess">
                <input type="hidden" name="a" value="node">

                <div class="form-group col-md-12">
                    <input type="text" class="form-control" name="title" placeholder="节点名称关键字">
                </div>

                <div class="form-group col-md-12">
                    <select class="form-control" name="process_id">
                        <option value="">==请选择流程==</option>
                        <foreach name="process_lists" item="v">
                            <option value="{$v.id}">{$v.title}</option>
                        </foreach>
                    </select>
                </div>

                </form>
            </div>

<include file="Index:footer2" />

<script>

    /*function ConfirmDel(url,msg) {

        if(!msg){
            var msg = '真的要删除吗？';
        }

        art.dialog({
            title: '提示',
            width:400,
            height:100,
            lock:true,
            fixed: true,
            content: '<span style="width:100%; text-align:center; font-size:18px;float:left; clear:both;">'+msg+'</span>',
            ok: function (msg) {
                window.location.href=url;
                //this.title('3秒后自动关闭').time(3);
                return false;
            },
            cancelVal: '取消',
            cancel: true //为true等价于function(){}
        });

    }*/

    function set_node_url (id) {
        art.dialog.open('/index.php?m=Main&c=Zprocess&a=setNodeUrl&id='+id, {
            lock:true,
            id: 'audit_win',
            title: '编辑节点连接',
            width:500,
            height:200,
            okVal: '提交',
            ok: function () {
                this.iframe.contentWindow.gosubmint();
                setTimeout("parent.art.dialog.list['audit_win'].close()",1500);
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
