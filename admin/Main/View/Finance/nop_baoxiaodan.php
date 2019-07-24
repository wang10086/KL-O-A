
<?php if($baoxiao){ ?>
    <?php if ($share_lists){ ?>
    <div class="box-body">
        <table class="table table-bordered dataTable fontmini" id="tablelist" style="margin-top:10px;">
            <tr role="row" class="orders" >
                <th class="sorting" width="150" data="">部门名称</th>
                <th class="sorting" width="150" data="">分摊金额</th>
                <th class="sorting" width="150" data="">备注信息</th>
                <th class="sorting" width="150" data="">录入时间</th>
            </tr>
            <foreach name="share_lists" item="row">
                <tr>
                    <td>{$row.department}</td>
                    <td>&yen;{$row.depart_sum}</td>
                    <td>{$row.remark}</td>
                    <td>{$row.input_time|date="Y-m-d H:i:s",###}</td>
                </tr>
            </foreach>
        </table>
    </div><!-- /.box-body -->
    <?php } ?>

    <div class="box-body mt20" >
        <div class="row"><!-- right column -->
            <div class="form-group col-md-12">
                <div class="form-group col-md-12" style="align: center;">
                    <table style="width: 100%;">
                        <tr>
                            <td class="td_title" colspan="6">
                                <div class="form-group col-md-12">
                                    <h4><b>{$company[$baoxiao['company']]}报销单</b></h4>
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
                            <td class="td_con td" colspan="6">
                                <div style="display: inline-block; width: 33%;">报销人签字：<img src="/{$baoxiao.bx_file}" height="50px" alt=""></div>
                                <div style="display: inline-block; width: 33%;">证明验收人签字：<span id="zmysr"> <?php if($audit_userinfo['zm_audit_status']==2){echo "<span class='red'>不通过</span>"; }elseif ($audit_userinfo['zm_audit_status']==1){ echo "<img src='/$audit_userinfo[zm_audit_file]' height='50px'>";}; ?></span></div>
                                <div style="display: inline-block; width: 33%;">部门主管签字：<span id="zmysr"> <?php if($audit_userinfo['manager_audit_status']==2){echo "<span class='red'>不通过</span>"; }elseif ($audit_userinfo['manager_audit_status']==1){ echo "<img src='/$audit_userinfo[manager_audit_file]' height='50px'>";}; ?></span></div>
                            </td>
                        </tr>

                        <tr>
                            <td colspan="3" class="td_con td">部门分管领导签字：<span id="ysspr"> <?php if($audit_userinfo['ys_audit_status']==2){echo "<span class='red'>不通过</span>"; }elseif ($audit_userinfo['ys_audit_status']==1){ echo "<img src='/$audit_userinfo[ys_audit_file]' height='50px'>";}; ?></span></td>
                            <td colspan="3" class="td_con td">财务主管签字：<span id="cwzg"><?php if($audit_userinfo['cw_audit_status']==2){echo "<span class='red'>不通过</span>"; }elseif ($audit_userinfo['cw_audit_status']==1){ echo "<img src='/$audit_userinfo[cw_audit_file]' height='50px'>";}; ?></span></td>
                        </tr>
                    </table>
                </div>

                <?php if (in_array(cookie('userid'),array(1,11,$baoxiao['bx_user_id']))){ ?>
                    <div class="content no-print">
                        <a href="{:U('Print/printReimbursements',array('bxids'=>$baoxiao['id']))}" class="btn btn-default"><i class="fa fa-print"></i> 打印</a>
                    </div>
                <?php } ?>
            </div>
        </div><!--/.col (right) -->
    </div>

    <include file="audit_nopbx_form" />

<?php }else{ ?>
    <div class="content" style="padding-top:40px;">  获取报销信息失败!</div>
<?php } ?>

<script>

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
                    if (audit_usertype ==1){
                        html += '<label>证明验收人签字：</label>'+
                            '<input type="hidden" name="info[zm_audit_file]" value="'+msg.file_url+'">'+
                            '<img width="100" src="/'+msg.file_url+'" alt="">';
                    }else if(audit_usertype ==2){
                        html += '<label>部门主管签字：</label>'+
                            '<input type="hidden" name="info[manager_audit_file]" value="'+msg.file_url+'">'+
                            '<img width="100" src="/'+msg.file_url+'" alt="">';
                    }else if(audit_usertype ==3){
                        html += '<label>部门分管领导签字：</label>'+
                            '<input type="hidden" name="info[ys_audit_file]" value="'+msg.file_url+'">'+
                            '<img width="100" src="/'+msg.file_url+'" alt="">';
                    }else if(audit_usertype ==4){
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
            art_show_msg('请完善签字信息');
            return false;
        }
    }

</script>
