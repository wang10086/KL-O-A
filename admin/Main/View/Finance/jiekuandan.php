
<?php if($jiekuan){ ?>
        <div class="box-body" id="jiekuandan" >
            <div class="row"><!-- right column -->
                <div class="form-group col-md-12">
                    <div class="form-group col-md-12" style="align: center;">
                        <table style="width: 100%; margin-top: 20px;">
                            <tr>
                                <td class="td_title" colspan="6">
                                    <div class="form-group col-md-12">
                                        <h4>科学国际旅行社 <b>借款单</b></h4>
                                    </div>
                                </td>
                            </tr>
                            <tr>
                                <td class="td_con" colspan="4" style="text-align: left">团号：{$op['group_id']}&emsp;</td>
                                <td class="td_con" colspan="2" style="text-align: right">
                                    借款时间：{$jiekuan['jk_time']|date='Y 年 m 月 d 日',###}&emsp;&emsp;&emsp;
                                    支付方式：
                                    <input type="radio" name="type" value="1" <?php if ($jiekuan['type']== 1) echo "checked"; ?> /> &nbsp;<?php if ($jiekuan['type']== 1) echo '√'; ?>支票 &emsp;
                                    <input type="radio" name="type" value="2" <?php if ($jiekuan['type']== 2) echo "checked"; ?> /> &nbsp;<?php if ($jiekuan['type']== 2) echo '√'; ?>现金 &emsp;
                                    <input type="radio" name="type" value="3" <?php if ($jiekuan['type']== 3) echo "checked"; ?> /> &nbsp;<?php if ($jiekuan['type']== 3) echo '√'; ?>汇款 &emsp;
                                    <input type="radio" name="type" value="4" <?php if ($jiekuan['type']== 4) echo "checked"; ?> /> &nbsp;<?php if ($jiekuan['type']== 4) echo '√'; ?>其他 &emsp;
                                </td>
                            </tr>
                            <tr>
                                <td class="td_con td">用途说明</td>
                                <td colspan="5" class="td_con td">
                                    <div class="form-group col-md-12">
                                        <textarea class="form-control no-border-textarea" readonly>{$jiekuan.description}</textarea>
                                    </div>
                                </td>
                            </tr>
                            <tr>
                                <td class="td_con td">借款金额</td>
                                <td colspan="4" class="td_con td">{$jiekuan.sum_chinese}</td>
                                <td class="td_con td">&yen;&emsp;<input type="text" style="border:none;border-bottom: solid 1px #808080; " value="{$jiekuan.sum}">元</td>
                            </tr>
                            <tr>
                                <td colspan="6" class="td_con td">受款单位：{$jiekuan.payee}</td>
                            </tr>
                            <tr>
                                <td colspan="5" class="td_con td">开户行名称：{$jiekuan.bank_name}</td>
                                <td class="td_con td">账号：{$jiekuan.card_num}</td>
                            </tr>

                            <tr>
                                <td colspan="5" class="td_con td">借款单位：{$jiekuan.rolename}</td>
                                <td class="td_con td">借款人签字：<img src="/{$jiekuan.jk_file}" width="150px" alt=""></td>
                            </tr>

                            <tr>
                                <td colspan="5" class="td_con td">预算审批人签字：<span id="ysspr"><img src="" width="150px" alt=""></span></td>
                                <td class="td_con td">财务主管签字：<span id="cwzg"><img src="" width="150px" alt=""></span></td>
                            </tr>

                        </table>
                    </div>

                    <div class="content no-print">
                        <button class="btn btn-default" onclick="print_view('jiekuandan');"><i class="fa fa-print"></i> 打印</button>
                    </div>
                </div>
            </div><!--/.col (right) -->
        </div>

    <?php if ($audit_userinfo['audit_status'] != 1){ ?>
    <form method="post" action="{:U('op/public_save')}" id="audit_jk" onsubmit="return submitBefore()">
        <input type="hidden" name="dosubmint" value="1">
        <input type="hidden" name="opid" value="{$op.op_id}">
        <input type="hidden" name="jk_id" value="{$jiekuan.id}">
        <input type="hidden" name="audit_usertype" value="{$audit_usertype}">
        <input type="hidden" name="audit_userid" value="{$audit_userinfo.audit_userid}">
        <input type="hidden" id="qianzi" value="0">
        <input type="hidden" name="savetype" value="3">
        <div class="content">
            <div class="form-group col-md-12">
                <label>审核借款信息：</label>
                <input type="radio" name="info[audit_status]" value="1" <?php if ($audit_userinfo['audit_status'] == 1){echo 'checked';} ?>> &emsp;通过&emsp;&emsp;&emsp;
                <input type="radio" name="info[audit_status]" value="2" <?php if ($audit_userinfo['audit_status'] == 2){echo 'checked';} ?>> &emsp;不通过
            </div>

            <div class="form-group col-md-12">
                <label>备注：</label>
                <textarea class="form-control"  name="info[remark]">{$audit_userinfo['remark']}</textarea>
            </div>

            <div class="form-group col-md-12" id="shr_qianzi">
                <label>签字：</label>
                <input type="button" onclick="show_qianzi()" value="签字">
            </div>

        </div>

        <div style="width:100%; text-align:center;">
            <input type="submit" class="btn btn-info btn-lg" value = '提交'>
        </div>
    </form>
    <?php } ?>

<?php }else{ ?>
    <div class="content" style="padding-top:40px;">  获取借款信息失败!</div>
<?php } ?>

<script>
    function show_qianzi() {
        var html = '';
        html += '<label>签字：</label>'+
            '<input type="text" name="password" class="" placeholder="请输入签字密码"  />&emsp;'+
            '<input type="button" value="确定" onclick="check_pwd()">';
        $('#shr_qianzi').html(html);
    }

    function check_pwd() {
        var pwd = $('input[name="password"]').val();
        var usertype = $('input[name="audit_usertype"]').val();
        $.ajax({
            type: 'POST',
            url : "{:U('Ajax/check_pwd')}",
            data: {pwd:pwd},
            success:function (msg) {
                if (msg.stu ==1){
                    var html = '';
                    html += '<label>签字：</label>'+
                        '<input type="hidden" name="info[audit_file]" value="'+msg.file_url+'">'+
                        '<img width="100" src="/'+msg.file_url+'" alt="">';
                    $('#shr_qianzi').html(html);
                    /*if (usertype ==1 ){
                        $('#ysspr').html(html);
                    }else if(usertype ==2){
                        $('#cwzg').html(html);
                    }*/
                    $('#qianzi').val('1');
                }else{
                    art_show_msg(msg.message);
                    return false;
                }
            }
        })
    }

    function submitBefore() {
        var isqianzi = $('#qianzi').val();
        if (isqianzi == 1){
            $('#jiekuanform').submit();
        }else{
            art_show_msg('请完善借款信息');
            return false;
        }
    }
</script>
