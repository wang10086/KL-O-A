<include file="Index:header2" />

            <aside class="right-side">
                <!-- Content Header (Page header) -->
                <section class="content-header">
                    <h1>{$_action_} <small>不合格处理率</small></h1>
                    <ol class="breadcrumb">
                        <li><a href="{:U('Index/index')}"><i class="fa fa-home"></i> 首页</a></li>
                        <li><a href="javascript:;"><i class="fa fa-gift"></i> 数据统计</a></li>
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
                                        <a href="javascript:;" onclick="edit_unqualify(0)" class="btn btn-info btn-sm">添加考核指标</a>
                                    </div>
                                </div><!-- /.box-header -->
                                <div class="box-body">
                                    <table class="table table-bordered dataTable fontmini" id="tablelist" style="margin-top:10px;">
                                        <tr role="row" class="orders" >
                                            <th class="taskOptions" width="60">序号</th>
                                            <th class="taskOptions" style="min-width: 100px;">工作项目</th>
                                            <th class="taskOptions">内容</th>
                                            <th class="taskOptions">衡量方法</th>
                                            <if condition="rolemenu(array('Sale/timely_edit'))">
                                            <th width="60" class="taskOptions">编辑</th>
                                            </if>
                                            <if condition="rolemenu(array('Sale/timely_del'))">
                                                <th width="60" class="taskOptions">编辑</th>
                                            </if>
                                        </tr>
                                        <foreach name="lists" key="k" item="v">
                                            <tr>
                                                <td class="taskOptions">{$v['id']}</td>
                                                <td class="taskOptions">{$v['title']}</td>
                                                <td class="">{$v['content']}</td>
                                                <td class="">{$v['rules']}</td>
                                                <if condition="rolemenu(array('Sale/timely_edit'))">
                                                <td class="taskOptions">
                                                    <a href="javascript:;" onclick="edit_unqualify({$v.id})" title="编辑" class="btn btn-info btn-smsm"><i class="fa fa-pencil"></i></a>
                                                </td>
                                                </if>
                                                <if condition="rolemenu(array('Sale/timely_del'))">
                                                <td class="taskOptions">
                                                    <a href="javascript:;" onclick="ConfirmDel(`<?php echo U('Inspect/unqualify_del',array('id'=>$v['id'])); ?>`)" title="删除" class="btn btn-warning btn-smsm"><i class="fa fa-times"></i></a>
                                                </td>
                                                </if>
                                            </tr>
                                        </foreach>
                                    </table>
                                </div><!-- /.box-body -->
                            </div><!-- /.box -->

                        </div><!-- /.col -->
                    </div>

                </section><!-- /.content -->
            </aside><!-- /.right-side -->

<include file="Index:footer2" />

<script>
    //编辑计调及时率考核指标
    function edit_unqualify(id) {
        art.dialog.open('index.php?m=Main&c=Inspect&a=unqualify_edit&id='+id,{
            lock:true,
            title: '配置不合格处理率考核指标',
            width:800,
            height:400,
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