
<?php if($baoxiao){ ?>
    <div class="box-body">
        <table class="table table-bordered dataTable fontmini" id="tablelist" style="margin-top:10px;">
            <tr role="row" class="orders" >
                <th class="sorting" width="150" data="title">费用项</th>
                <th class="sorting" width="150" data="total">合计</th>
                <th class="sorting" width="150" data="yjk">报销金额</th>
                <th class="sorting" width="150" data="sjk">本次报销金额</th>
            </tr>
            <foreach name="bx_lists" item="row">
                <tr>
                    <td>{$row.title}</td>
                    <td>{$row.ys}</td>
                    <td>{$row.ybx}</td>
                    <td <?php if ($row['ybx']>$row['sbx']){ echo "class='red'"; } ?>>{$row.sbx}</td>
                </tr>
            </foreach>
        </table>
    </div><!-- /.box-body -->

        <div class="box-body" id="jiekuandan" >
            <div class="row"><!-- right column -->
                <div class="form-group col-md-12">
                    <div class="form-group col-md-12" style="align: center;">
                        <table style="width: 100%; margin-top: 20px;">
                            <tr>
                                <td class="td_title" colspan="6">
                                    <div class="form-group col-md-12">
                                        <h4><b>报销单</b></h4>
                                    </div>
                                </td>
                            </tr>
                            <tr>
                                <td class="td_con" colspan="6">
                                    <div style="display: inline-block; float: left; min-width:230px; clear: left;">
                                        报销单编号：{$baoxiao['bxd_id']}
                                    </div>
                                    <div style="display: inline-block; float: right; clear: right;">
                                        支付方式：
                                        <input type="radio" name="type" value="1" <?php if ($baoxiao['type']== 1) echo "checked"; ?> /> <?php if ($baoxiao['type']== 1) echo '√'; ?>支票 &nbsp;
                                        <input type="radio" name="type" value="2" <?php if ($baoxiao['type']== 2) echo "checked"; ?> /> <?php if ($baoxiao['type']== 2) echo '√'; ?>现金 &nbsp;
                                        <input type="radio" name="type" value="3" <?php if ($baoxiao['type']== 3) echo "checked"; ?> /> <?php if ($baoxiao['type']== 3) echo '√'; ?>汇款 &nbsp;
                                        <input type="radio" name="type" value="4" <?php if ($baoxiao['type']== 4) echo "checked"; ?> /> <?php if ($baoxiao['type']== 4) echo '√'; ?>其他 &nbsp;
                                    </div>
                                </td>
                            </tr>

                            <tr>
                                <td class="td_con td" colspan="5">报销单位：{$baoxiao.department}</td>
                                <td class="td_con td">报销时间：{$baoxiao['bx_time']|date='Y 年 m 月 d 日',###}</td>
                            </tr>

                            <tr>
                                <td colspan="2" class="td_con td">用途说明</td>
                                <td colspan="4" class="td_con td">
                                    <div class="form-group col-md-12">
                                        <textarea class="form-control no-border-textarea">{$baoxiao.description}</textarea>
                                    </div>
                                </td>
                            </tr>
                            <tr>
                                <td colspan="2" class="td_con td">报销金额</td>
                                <td colspan="3" class="td_con td">{$baoxiao.sum_chinese}</td>
                                <td class="td_con td">&yen;&emsp;<input type="text" style="border:none;border-bottom: solid 1px #808080; " value="{$baoxiao.sum}">元</td>
                            </tr>
                            <tr>
                                <td colspan="6" class="td_con td">受款单位：{$baoxiao.payee}</td>
                            </tr>
                            <tr>
                                <td colspan="3" class="td_con td">开户行名称：{$baoxiao.bank_name}</td>
                                <td colspan="3" class="td_con td">账号：{$baoxiao.card_num}</td>
                            </tr>

                            <tr>
                                <td colspan="3" class="td_con td">报销人签字：<img src="/{$baoxiao.jk_file}" height="50px" alt=""></td>
                                <td colspan="3" class="td_con td">证明验收人签字：<span id="zmysr"> <?php if($audit_userinfo['zm_audit_status']==2){echo "<span class='red'>不通过</span>"; }elseif ($audit_userinfo['zm_audit_status']==1){ echo "<img src='/$audit_userinfo[zm_audit_file]' height='50px'>";}; ?></span></td>
                            </tr>

                            <tr>
                                <td colspan="3" class="td_con td">预算审批人签字：<span id="ysspr"> <?php if($audit_userinfo['ys_audit_status']==2){echo "<span class='red'>不通过</span>"; }elseif ($audit_userinfo['ys_audit_status']==1){ echo "<img src='/$audit_userinfo[ys_audit_file]' height='50px'>";}; ?></span></td>
                                <td colspan="3" class="td_con td">财务主管签字：<span id="cwzg"><?php if($audit_userinfo['cw_audit_status']==2){echo "<span class='red'>不通过</span>"; }elseif ($audit_userinfo['cw_audit_status']==1){ echo "<img src='/$audit_userinfo[cw_audit_file]' height='50px'>";}; ?></span></td>
                            </tr>
                            <tr id="print_time">
                                <td class="td_con" colspan="6" style="text-align: right; ">打印时间：<?php echo date('Y-m-d H:i:s',time()); ?></td>
                            </tr>

                        </table>
                    </div>
                    <if condition="rolemenu(array('Finance/print_jkd'))">
                        <div class="content no-print">
                            <button class="btn btn-default" onclick="show_print_time(),print_view('jiekuandan');"><i class="fa fa-print"></i> 打印</button>
                        </div>
                    </if>
                </div>
            </div><!--/.col (right) -->
        </div>

    <include file="audit_bx_form" />

<?php }else{ ?>
    <div class="content" style="padding-top:40px;">  获取报销信息失败!</div>
<?php } ?>

<script>
    $(function () {
        $('#print_time').hide();
    })

    function show_print_time() {
        $('#print_time').show();
    }

    function show_qianzi() {
        var html = '';
        html += '<label>签字：</label>'+
            '<input type="password" name="password" class="" placeholder="请输入签字密码"  />&emsp;'+
            '<input type="button" value="确定" onclick="check_pwd()">';
        $('#shr_qianzi').html(html);
    }

    function check_pwd() {
        var pwd = $('input[name="password"]').val();
        var audit_usertype = '<?php echo "$audit_usertype"; ?>';
        $.ajax({
            type: 'POST',
            url : "{:U('Ajax/check_pwd')}",
            data: {pwd:pwd},
            success:function (msg) {
                if (msg.stu ==1){
                    var html = '';
                    if (audit_usertype ==1 ){
                        html += '<label>预算审核人签字：</label>'+
                            '<input type="hidden" name="info[ys_audit_file]" value="'+msg.file_url+'">'+
                            '<img width="100" src="/'+msg.file_url+'" alt="">';
                    }else if(audit_usertype ==2){
                        html += '<label>财务主管签字：</label>'+
                            '<input type="hidden" name="info[cw_audit_file]" value="'+msg.file_url+'">'+
                            '<img width="100" src="/'+msg.file_url+'" alt="">';
                    }
                    $('#shr_qianzi').html(html);
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
            art_show_msg('请完善审核信息');
            return false;
        }
    }
</script>
