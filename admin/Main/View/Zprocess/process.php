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
                                        <if condition="rolemenu(array('Zprocess/addProcess'))">
                                        <a href="{:U('Zprocess/addProcess')}" class="btn btn-sm btn-success"><i class="fa fa-plus"></i> 录入流程</a>
                                        </if>
                                    </div>
                                </div><!-- /.box-header -->
                                <div class="box-body">

                                <div class="btn-group" id="catfont">
                                    <a href="{:U('Zprocess/process',array('pin'=>0))}" class="btn <?php if($pin==0){ echo 'btn-info';}else{ echo 'btn-default';} ?>">全部流程</a>
                                    <foreach name="typeLists" key="k" item="v">
                                        <a href="{:U('Zprocess/process',array('pin'=>$k))}" class="btn <?php if($pin==$k){ echo 'btn-info';}else{ echo 'btn-default';} ?>">{$v}</a>
                                    </foreach>
                                </div>

                                <table class="table table-bordered dataTable fontmini" id="tablelist" style="margin-top:10px;">
                                    <tr role="row" class="orders" >
                                        <th class="sorting" width="60" data="id">ID</th>
                                        <th class="sorting" data="title">流程名称</th>
                                        <th class="sorting" data="title">流程说明</th>
                                        <th class="sorting" data="type">流程类型</th>
                                        <th class="sorting" data="input_time">录入时间</th>

                                        <if condition="rolemenu(array('Zprocess/addProcess'))">
                                        <th width="40" class="taskOptions">编辑</th>
                                        </if>

                                        <if condition="rolemenu(array('Zprocess/delProcess'))">
                                        <th width="40" class="taskOptions">删除</th>
                                        </if>

                                        <if condition="rolemenu(array('Rbac/node'))">
                                            <th width="80" class="taskOptions">表单连接</th>
                                        </if>
                                    </tr>
                                    <foreach name="lists" item="row">
                                    <tr>
                                        <td>{$row.id}</td>
                                        <td><a href="javascript:;">{$row.title}</a></td>
                                        <td><div class="tdbox_long">{$row.remark}</div></td>
                                        <td>{$typeLists[$row['type']]}</td>
                                        <td>{$row.input_time|date='Y-m-d H:i:s',###}</td>

                                        <if condition="rolemenu(array('Zprocess/addProcess'))">
                                        <td class="taskOptions">
                                        <a href="{:U('Zprocess/addProcess',array('id'=>$row['id']))}" title="编辑" class="btn btn-info btn-smsm"><i class="fa fa-pencil"></i></a>
                                        </td>
                                        </if>
                                        <if condition="rolemenu(array('Zprocess/delProcess'))">
                                        <td class="taskOptions">
                                        <button onClick="javascript:ConfirmDel(`{:U('Zprocess/delProcess',array('id'=>$row['id']))}`)" title="删除" class="btn btn-warning btn-smsm"><i class="fa fa-times"></i></button>
                                        </td>
                                        </if>

                                        <if condition="rolemenu(array('Rbac/node'))">
                                            <td class="taskOptions">{$row.form_url}<br /><a href="javascript:;" onclick= set_url({$row.id})>编辑</a></td>
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
                <input type="hidden" name="a" value="process">
                <input type="hidden" name="pin" value="{$pin}">

                <div class="form-group col-md-12">
                    <input type="text" class="form-control" name="title" placeholder="流程标题">
                </div>
                </form>
            </div>

<include file="Index:footer2" />

<script>

    function ConfirmDel(url,msg) {
        /*
         if (confirm("真的要删除吗？")){
         window.location.href=url;
         }else{
         return false;
         }
         */

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

    }

    function set_url (id) {
        art.dialog.open('/index.php?m=Main&c=Zprocess&a=setFormUrl&id='+id, {
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
