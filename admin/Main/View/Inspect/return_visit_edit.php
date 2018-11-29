<div class="box box-warning">
    <div class="box-header">
        <h3 class="box-title">回访记录</h3>
    </div>
    <div class="box-body">
        <?php if ($return_visit){ ?>
        <div class="content">
            <table class="table table-bordered dataTable fontmini" id="tablelist" >
                <tr role="row" class="orders" >
                    <th class="sorting" width="160" data="">回访时间</th>
                    <th class="sorting" width="100" data="">客户联系方式</th>
                    <th class="sorting" width="" data="">回访内容</th>
                    <th class="sorting" width="100" data="">回访人员</th>
                    <if condition="rolemenu(array('Inspect/return_visit'))">
                        <th width="40" class="taskOptions">编辑</th>
                    </if>
                </tr>
                <foreach name="visit_lists" item="row">
                    <tr>
                        <td>{$row.input_time|date="Y-m-d H:i:s",###}</td>
                        <td>{$row.tel}</td>
                        <td>{$row.content}</td>
                        <td>{$row.input_user_name}</td>
                        <if condition="rolemenu(array('Inspect/return_visit'))">
                            <td class="taskOptions">
                                <button class="btn btn-info btn-smsm" title="编辑" onclick="show_visit({$row.id})"><i class="fa fa-pencil"></i></button>
                            </td>
                        </if>
                    </tr>
                </foreach>
            </table>
        </div>
        <?php }else{ ?>
        <div class="content" id="no_visit"><div class="form-group" style="margin-left: 20px;">暂无回访记录！<if condition="rolemenu(array('Inspect/return_visit'))">
                    <a href="javascript:;" onclick="show_visit_from()">立即回访</a></if></div></div>
        <?php } ?>

        <div class="content" style="margin-top: 20px;">
            <form method="post" action="{:U('Inspect/return_visit')}" id="visit_form">
                <input type="hidden" name="dosubmint" value="1">
                <input type="hidden" name="opid" value="{$op.op_id}">

                <if condition="rolemenu(array('Inspect/return_visit'))">
                <div class="tcscon">
                    <div id="tcs">
                        <div class="userlist form-title">
                            <div class="unitbox" style="width:20%">客户联系方式</div>
                            <div class="unitbox" style="width:75%">备注</div>
                        </div>
                        <div class="userlist no-border">
                            <input type="text" class="form-control dtel" style="width:20%" name="tel"  value="" >
                            <input type="text" class="form-control dcontent" style="width:75%" name="content" value="">
                        </div>
                    </div>

                    <div class="form-group col-md-12" id="useraddbtns">
                        <a  href="javascript:;" class="btn btn-info btn-sm" onClick="javascript:save('visit_form','<?php echo U('Inspect/return_visit'); ?>',{$op.op_id});">保存</a>
                    </div>
                    <div class="form-group">&nbsp;</div>
                </div><!--/.col (right) -->
                </if>
            </form>
        </div>

    </div>
</div><!--/.col (right) -->

<script type="text/javascript">
    $(function () {
        var return_visit = <?php echo $return_visit?$return_visit:0; ?>;
        if (return_visit){
            $('#visit_form').show();
        }else{
            $('#visit_form').hide();
        }
    })

    function show_visit(id) {
        art.dialog.open('index.php?m=Main&c=Inspect&a=return_visit&id='+id,{
            lock:true,
            title: '编辑回访信息',
            id:'visit',
            width:600,
            height:400,
            fixed: true,
            okVal:'提交',
            ok: function () {
                this.iframe.contentWindow.myform.submit();
                location.reload();
                return false;
            },
            cancelVal:'取消',
            cancel: function () {
            }

        });
    }

    function show_visit_from() {
        $('#no_visit').hide();
        $('#visit_form').show();
    }

    artDialog.alert = function (content, status) {
        return artDialog({
            id: 'Alert',
            icon: status,
            width:300,
            height:120,
            fixed: true,
            lock: true,
            time: 1,
            content: content,
            ok: true
        });
    };


    //保存信息
    function save(id,url,opid){
        var tel     = $('.dtel').val();
        var content = $('.dcontent').val();
        if (!tel || !content){
            art_show_msg('请完善相关信息');
            return false;
        }else{
            $.ajax({
                type: "POST",
                url: url,
                dataType:'json',
                data: $('#'+id).serialize(),
                success:function(data){
                    if(parseInt(data)>0){
                        art.dialog.alert('保存成功','success');
                    }else{
                        art.dialog.alert('保存失败','warning');
                    }
                }
            });
            setTimeout("history.go(0)",1000);
        }
    }


</script>