<div class="box-body">
    <form method="post" action="<?php echo U('Finance/public_save'); ?>" id="save_loan">
        <input type="hidden" name="dosubmint" value="1">
        <input type="hidden" name="opid" value="{$op.op_id}">
        <input type="hidden" name="savetype" value="5">
        <div class="content" id="loanlist" style="display:block;">
            <table class="table table-striped">
                <thead>
                    <tr>
                        <th width="60"></th>
                        <th width="150">团号</th>
                        <th width="">费用项</th>
                        <th width="120">合计</th>
                        <th width="150">类型</th>
                        <th width="120">已借款金额</th>
                        <th width="300">报销金额</th>
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
                            <input type="hidden" name="loan[20000{$v.id}][ctotal]" value="{$v.ctotal}" id="ys_20000{$v.id}">
                            <input type="hidden" name="loan[20000{$v.id}][amount]" value="{$v.amount}">
                            <input type="hidden" name="loan[20000{$v.id}][type]" value="{$v.type}">
                            <input type="hidden" name="loan[20000{$v.id}][jiekuan]" value="{$v.jiekuan}" id="jk_20000{$v.id}">
                        </td>
                        <td>{$v.group_id}</td>
                        <td>{$v.title}</td>
                        <td class="total">&yen;{$v.ctotal}</td>
                        <td>{$v.type}</td>
                        <td>{$v.jiekuan}</td>
                        <td>
                            <input type="hidden" value="<?php echo $v['baoxiao']?$v['baoxiao']:$v['jiekuan']; ?>" id="old_bx_20000{$v.id}">
                            <input type="text" name="loan[20000{$v.id}][baoxiao]" id="new_bx_20000{$v.id}" value="<?php echo $v['baoxiao']?$v['baoxiao']:$v['jiekuan']; ?>" onblur="upd_bxje(20000{$v.id})">
                        </td>
                        <td><a href="javascript:;" class="btn btn-danger btn-flat" onclick="delbox('loan_id_{$v.id}','20000{$v.id}')">删除</a></td></tr>;
                    </foreach>
                    <tr id="t-body">
                        <td>
                            <input type="hidden" name="ys_total" id="ys_total" value="{$total.ys_total}">
                            <input type="hidden" name="jk_total" id="jk_total" value="{$total.jk_total}">
                            <input type="hidden" name="bx_total" id="bx_total" value="{$total.bx_total}">
                        </td>
                        <td></td>
                        <td></td>
                        <td style="font-size:16px; color:#ff3300;" id="ys_total_td">&yen; {$total.ys_total}</td>
                        <td></td>
                        <td style="font-size:16px; color:#ff3300;" id="jk_total_td">&yen; {$total.jk_total}</td>
                        <td style="font-size:16px; color:#ff3300;" id="bx_total_td">&yen; {$total.bx_total}</td>
                        <td></td>
                    </tr>
                </tbody>
                <tfoot>
                    <tr>
                        <td align="left" colspan="10">
                        <input type="text" id="groupId" onblur="get_yusuan()" placeholder="请输入团号信息" style="width:200px;height: 33px; margin-right: 10px;">
                        <a href="javascript:;" class="btn btn-success btn-sm" style="margin-left:-8px;"  onClick="show_group()"><i class="fa fa-fw  fa-plus"></i> 增加团号信息</a>
                        <!--<a  href="javascript:;" class="btn btn-info btn-sm" onClick="javascript:save('save_loan','<?php /*echo U('Finance/public_save'); */?>');">保存</a>-->
                        <input type="submit" class="btn btn-info btn-sm" value="保存">
                        </td>
                    </tr>
                </tfoot>
            </table>
        </div>

        <div class="content">
            <input type="hidden" id="qianzi" value="0">
            <input type="hidden" name="yingjiekuan" id="jk_sum">
            <div style="width:100%; float:left;">

                <div class="form-group col-md-12">
                    <label>报销部门：</label>
                    <select class="form-control" name="info[department_id]" onchange="get_department()" id="department_id" required >
                        <option value="">--请选择--</option>
                        <foreach name="departments" item="v">
                            <option value="{$v.id}">{$v.department}</option>
                        </foreach>
                    </select>
                </div>

                <!--<div class="form-group col-md-6">
                    <label>团号：</label>
                    <input type="text" name="info[group_id]" class="form-control" value="<?php /*echo $list['group_id']?$list['group_id']:$op['group_id']; */?>" readonly />
                    <input type="hidden" name="info[op_id]" value="<?php /*echo $list['op_id']?$list['op_id']:$op['op_id']; */?>" />
                </div>-->

                <div class="form-group col-md-6">
                    <label>报销金额：</label>
                    <input type="text" name="info[sum]" id="baoxiaojine" class="form-control" value="{$list.sum}" onblur="todaxie($(this).val())" readonly />
                </div>

                <div class="form-group col-md-6">
                    <label>人民币(大写)：</label>
                    <input type="text" name="info[sum_chinese]" id="daxie" class="form-control" value="{$list.sum_chinese}" readonly />
                </div>

                <div class="form-group col-md-12" id="jk_type">
                    <label>支付方式：</label>
                    <foreach name="jk_type" key="k" item="v">
                        <input type="radio" name="type" value="{$k}" <?php if ($list['type']== $k) echo "checked"; ?> /> &nbsp;{$v} &emsp;&emsp;
                    </foreach>
                </div>

                <div class="form-group col-md-12">
                    <label>用途说明：</label>
                    <textarea class="form-control"  name="info[description]">{$list.description}</textarea>
                </div>
                <div class="form-group col-md-12 zp_show hk_show">
                    <label>受款单位：</label>
                    <input type="text" name="info[payee]" class="form-control zhipiao huikuan" value="{$list.payee}">
                </div>

                <div class="form-group col-md-6 hk_show">
                    <label>开户行名称：</label>
                    <input type="text" name="info[bank_name]" class="form-control huikuan" value="{$list.bank_name}">
                </div>

                <div class="form-group col-md-6 hk_show">
                    <label>账号：</label>
                    <input type="text" name="info[card_num]" class="form-control huikuan" value="{$list.card_num}">
                </div>

                <div class="form-group col-md-6" id="jkr_qianzi">
                    <label>报销人：</label>
                    <input type="button" onclick="show_qianzi()" class="info-button" value="签字">
                </div>

            </div>
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
        var group_id        = $('#groupId').val();
        var old_ys_total    = $('#ys_total').val();
        var old_jk_total    = $('#jk_total').val();
        var old_bx_total    = $('#bx_total').val();
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
                                var ys_total  = 0;
                                var jk_total  = 0;
                                var bx_total  = 0;
                                for (var j = 0; j < loan.length; j++) {
                                    if (loan[j].id) {
                                        ys_total += parseFloat(loan[j].ctotal);
                                        jk_total += parseFloat(loan[j].jiekuan);
                                        bx_total += parseFloat(loan[j].jiekuan);
                                        var i = parseInt(Math.random()*100000)+j;
                                        loan_html += '<tr class="expense" id="loan_'+i+'">' +
                                            '<td><input type="hidden" name="loan['+i+'][costacc_id]" value="'+loan[j].id+'">' +
                                            '<input type="hidden" name="loan['+i+'][op_id]" value="'+loan[j].op_id+'">' +
                                            '<input type="hidden" name="loan['+i+'][group_id]" value="'+loan[j].group_id+'">' +
                                            '<input type="hidden" name="loan['+i+'][title]" value="'+loan[j].title+'">' +
                                            '<input type="hidden" name="loan['+i+'][ctotal]" value="'+loan[j].ctotal+'" id="ys_'+i+'">' +
                                            '<input type="hidden" name="loan['+i+'][amount]" value="'+loan[j].amount+'">' +
                                            '<input type="hidden" name="loan['+i+'][type]" value="'+loan[j].type+'">' +
                                            '<input type="hidden" name="loan['+i+'][jiekuan]" value="'+loan[j].jiekuan+'" id="jk_'+i+'">' +
                                            '</td>'+
                                            '<td>'+loan[j].group_id+'</td>' +
                                            '<td>'+loan[j].title+'</td>' +
                                            '<td class="total">&yen;'+loan[j].ctotal+'</td>' +
                                            '<td>'+loan[j].type+'</td>' +
                                            '<td>'+loan[j].jiekuan+'</td>' +
                                            '<td>'+
                                            '<input type="hidden" value="'+loan[j].jiekuan+'" id="old_bx_'+i+'">'+
                                            '<input type="text" name="loan['+i+'][baoxiao]" id="new_bx_'+i+'" value="'+loan[j].jiekuan+'" onblur="upd_bxje('+i+')">'+
                                            '</td>' +
                                            '<td><a href="javascript:;" class="btn btn-danger btn-flat" onclick="delbox(\'loan_'+i+'\','+i+')">删除</a></td></tr>';
                                    };
                                }

                                var new_ys_total    = accAdd(old_ys_total,ys_total);
                                var new_jk_total    = accAdd(old_jk_total,jk_total);
                                var new_bx_total    = accAdd(old_bx_total,bx_total);
                                new_ys_total        = parseFloat(new_ys_total).toFixed(2);
                                new_jk_total        = parseFloat(new_jk_total).toFixed(2);
                                new_bx_total        = parseFloat(new_bx_total).toFixed(2);
                                $('#ys_total').val(new_ys_total);
                                $('#jk_total').val(new_jk_total);
                                $('#bx_total').val(new_bx_total);
                                $('#ys_total_td').html(new_ys_total);
                                $('#jk_total_td').html(new_jk_total);
                                $('#bx_total_td').html(new_bx_total);
                                $('#baoxiaojine').val(new_bx_total);    //报销单
                                todaxie(new_bx_total);
                                $('#loanlist').show();
                                $('#groupId').hide();
                                $('#loanlist').find('#t-body').before(loan_html);
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

    function resetsum(id){
        var old_ys_total    = $('#ys_total').val();
        var old_jk_total    = $('#jk_total').val();
        var old_bx_total    = $('#bx_total').val();
        var this_ys_total   = $('#ys_'+id).val();
        var this_jk_total   = $('#jk_'+id).val();
        var this_bx_total   = $('#new_bx_'+id).val();
        var new_ys_total    = accSub(old_ys_total,this_ys_total);
        var new_jk_total    = accSub(old_jk_total,this_jk_total);
        var new_bx_total    = accSub(old_bx_total,this_bx_total);
        new_ys_total        = parseFloat(new_ys_total).toFixed(2);
        new_jk_total        = parseFloat(new_jk_total).toFixed(2);
        new_bx_total        = parseFloat(new_bx_total).toFixed(2);
        $('#ys_total').val(new_ys_total);
        $('#jk_total').val(new_jk_total);
        $('#bx_total').val(new_bx_total);
        $('#ys_total_td').html(new_ys_total);
        $('#jk_total_td').html(new_jk_total);
        $('#bx_total_td').html(new_bx_total);
        $('#baoxiaojine').val(new_bx_total);    //报销单
        todaxie(new_bx_total);
    }

    function upd_bxje(id) {
        var sum_bx_total    = $('#bx_total').val();
        var this_old_bxje   = $('#old_bx_'+id).val();
        var this_new_bxje   = $('#new_bx_'+id).val();
        var new_bx_total    = accSub(sum_bx_total,this_old_bxje);   //减去旧的报销金额
            new_bx_total    = accAdd(new_bx_total,this_new_bxje);        //加上新的报销金额
        $('#bx_total').val(new_bx_total);
        $('#bx_total_td').html(new_bx_total);
        $('#old_bx_'+id).val(this_new_bxje);    //重新赋值
        $('#baoxiaojine').val(new_bx_total);    //报销单
        todaxie(new_bx_total);
    }

    function todaxie(num) {
        $.ajax({
            type: "post",
            url: "<?php echo U('Ajax/numTrmb'); ?>",
            dataType:'json',
            data: {num:num},
            success:function(data){
                if(data){
                    $('#daxie').val(data);
                }
            }
        });
    }

    //移除
    function delbox(obj,id){
        resetsum(id);
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