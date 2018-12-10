<div class="box-body">
    <form method="post" action="<?php echo U('Finance/public_save'); ?>" id="save_loan">
    <input type="hidden" name="dosubmint" value="1">
    <input type="hidden" name="opid" value="{$op.op_id}">
    <input type="hidden" name="savetype" value="5">
    <div class="content" id="loanlist" style="display:block;">
    <table class="table table-striped">
        <thead>
            <tr>
                <th></th>
                <th width="120">团号</th>
                <th width="">费用项</th>
                <th width="80">单价</th>
                <th width="20">&nbsp;</th>
                <th width="80">数量</th>
                <th width="100">合计</th>
                <th width="80">类型</th>
                <th width="160">已借款金额</th>
                <th width="80">删除</th>
            </tr>
        </thead>
        <tbody>
            <foreach name="loan" item="v">
            <tr class="expense" id="loan_id_{$v.id}">
                <td>
                    <input type="hidden" name="loan[20000{$v.id}][costacc_id]" value="{$v.id}">
                    <input type="hidden" name="loan[20000{$v.id}][op_id]" value="{$v.op_id}">
                    <input type="hidden" name="loan[20000{$v.id}][group_id]" value="{$v.group_id}">
                    <input type="hidden" name="loan[20000{$v.id}][title]" value="{$v.title}">
                    <input type="hidden" name="loan[20000{$v.id}][unitcost]" value="{$v.unitcost}">
                    <input type="hidden" name="loan[20000{$v.id}][amount]" value="{$v.amount}">
                    <input type="hidden" name="loan[20000{$v.id}][ctotal]" value="{$v.ctotal}">
                    <input type="hidden" name="loan[20000{$v.id}][amount]" value="{$v.amount}">
                    <input type="hidden" name="loan[20000{$v.id}][type]" value="{$v.type}">
                    <input type="hidden" name="loan[20000{$v.id}][jiekuan]" value="{$v.jiekuan}">
                </td>
                <td>{$v.group_id}</td>
                <td>{$v.title}</td>
                <td>{$v.unitcost}</td>
                <td><span>X</span></td>
                <td>&yen;{$v.amount}</td>
                <td class="total">&yen;{$v.ctotal}</td>
                <td>{$v.type}</td>
                <td>{$v.jiekuan}</td>
                <td><a href="javascript:;" class="btn btn-danger btn-flat" onclick="delbox('loan_id_{$v.id}')">删除</a></td></tr>;
            </foreach>
        </tbody>
        <tfoot>
            <tr>
                <td align="left" colspan="10">
                <input type="text" name="group_id" id="groupId" onblur="get_yusuan()" placeholder="请输入团号信息" style="width:200px;height: 33px; margin-right: 10px;">
                <a href="javascript:;" class="btn btn-success btn-sm" style="margin-left:-8px;"  onClick="show_group()"><i class="fa fa-fw  fa-plus"></i> 增加团号信息</a>
                <!--<a  href="javascript:;" class="btn btn-info btn-sm" onClick="javascript:save('save_loan','<?php /*echo U('Finance/public_save'); */?>');">保存</a>-->
                <input type="submit" class="btn btn-info btn-sm" value="保存">
                </td>
            </tr>
        </tfoot>
    </table>
    </div>
    </form> 
</div>

<script>
    $(function () {
        $('#groupId').hide();
    })

    function show_group() {
        $('#groupId').show();
    }

    function get_yusuan() {
        var group_id    = $('#groupId').val();
        if (group_id){
            $.ajax({
                type: "post",
                url : "<?php echo U('Ajax/get_yslist'); ?>",
                dataType: "json",
                data: {group_id:group_id},
                success:function (data) {
                    var status  = data.status;
                    var msg     = data.msg;
                    if (status==1){
                        art.dialog.open("/index.php?m=Main&c=Finance&a=select_ys&opid="+msg,{
                            lock:true,
                            title: '选择预算信息',
                            width:1000,
                            id:'showys',
                            height:500,
                            okVal: '提交',
                            fixed: true,
                            ok: function () {
                                var origin = artDialog.open.origin;
                                var loan = this.iframe.contentWindow.gosubmint();
                                var loan_html = '';
                                for (var j = 0; j < loan.length; j++) {
                                    if (loan[j].id) {
                                        var i = parseInt(Math.random()*100000)+j;
                                        loan_html += '<tr class="expense" id="loan_'+i+'">' +
                                            '<td><input type="hidden" name="loan['+i+'][costacc_id]" value="'+loan[j].id+'">' +
                                            '<input type="hidden" name="loan['+i+'][op_id]" value="'+loan[j].op_id+'">' +
                                            '<input type="hidden" name="loan['+i+'][group_id]" value="'+loan[j].group_id+'">' +
                                            '<input type="hidden" name="loan['+i+'][title]" value="'+loan[j].title+'">' +
                                            '<input type="hidden" name="loan['+i+'][unitcost]" value="'+loan[j].unitcost+'">' +
                                            '<input type="hidden" name="loan['+i+'][amount]" value="'+loan[j].amount+'">' +
                                            '<input type="hidden" name="loan['+i+'][ctotal]" value="'+loan[j].ctotal+'">' +
                                            '<input type="hidden" name="loan['+i+'][amount]" value="'+loan[j].amount+'">' +
                                            '<input type="hidden" name="loan['+i+'][type]" value="'+loan[j].type+'">' +
                                            '<input type="hidden" name="loan['+i+'][jiekuan]" value="'+loan[j].jiekuan+'">' +
                                            '</td>'+
                                            '<td>'+loan[j].group_id+'</td>' +
                                            '<td>'+loan[j].title+'</td>' +
                                            '<td>'+loan[j].unitcost+'</td>' +
                                            '<td><span>X</span></td>'+
                                            '<td>&yen;'+loan[j].amount+'</td>' +
                                            '<td class="total">&yen;'+loan[j].ctotal+'</td>' +
                                            '<td>'+loan[j].type+'</td>' +
                                            '<td>'+loan[j].jiekuan+'</td>' +
                                            '<td><a href="javascript:;" class="btn btn-danger btn-flat" onclick="delbox(\'loan_'+i+'\')">删除</a></td></tr>';
                                    };
                                }
                                $('#loanlist').show();
                                $('#groupId').hide();
                                $('#loanlist').find('tbody').append(loan_html);
                                top.art.dialog({id:"showys"}).close();
                            },
                            cancelValue:'取消',
                            cancel: function () {
                            }
                        });
                    }else{
                        art_show_msg(msg,3);
                        return false;
                    }
                }
            });
        }else{
            art_show_msg('团号输入有误,请重新输入',3);
            return  false;
        }
    }

    //移除
    function delbox(obj){
        $('#'+obj).remove();
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
    function save(id,url){
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

</script>