
<?php if($jiekuan){ ?>
        <div class="box-body" >
            <div class="row"><!-- right column -->
                <div class="form-group col-md-12">
                    <div class="form-group col-md-12 a4-endwise" id="jiekuandan"  style="align: center;">
                        <table id="jkd-table" style="width: 99%; margin-top: 20px;">
                            <tr>
                                <td class="" colspan="6" style="text-align: center;">
                                    <b style="font-weight: 600;font-size: large;">借款单</b>
                                </td>
                            </tr>
                            <tr>
                                <td class="" colspan="6">
                                    <div style="display: inline-block; float: left; min-width:230px; clear: left;">
                                        借款单编号：{$jiekuan['jkd_id']}
                                    </div>
                                    <div style="display: inline-block; float: right; clear: right;">
                                        借款时间：{$jiekuan['jk_time']|date='Y 年 m 月 d 日',###} &emsp;&emsp;
                                        支付方式：
                                        <foreach name="jk_type" key="k" item="v">
                                            <input type="radio" name="type" value="{$k}" <?php if ($jiekuan['type']== $k) echo "checked"; ?> /> <?php if ($jiekuan['type']== $k) echo '√'; ?>{$v} &nbsp;
                                        </foreach>
                                    </div>
                                </td>
                            </tr>

                            <tr>
                                <td class=" td" colspan="2">&emsp;团号：{$op['group_id']}</td>
                                <td class=" td" colspan="3">&emsp;项目名称：{$op['project']}</td>
                                <td class=" td">&emsp;计调：{$jidiao}</td>
                            </tr>

                            <tr>
                                <td colspan="6" class=" td">
                                    &emsp;用途说明：  {$jiekuan.description}
                                </td>
                            </tr>
                            <tr>
                                <td colspan="3" class=" td">&emsp;借款金额：{$jiekuan.sum_chinese}</td>
                                <td colspan="3" class=" td">&emsp;&yen;&emsp;<input type="text" style="border:none;border-bottom: solid 1px #808080; " value="{$jiekuan.sum}">元</td>
                            </tr>
                            <tr>
                                <td colspan="6" class=" td">&emsp;受款单位：{$jiekuan.payee}</td>
                            </tr>
                            <tr>
                                <td colspan="3" class=" td">&emsp;开户行名称：{$jiekuan.bank_name}</td>
                                <td colspan="3" class=" td">&emsp;账号：{$jiekuan.card_num}</td>
                            </tr>

                            <tr>
                                <td colspan="3" class=" td">&emsp;借款单位：{$jiekuan.department}</td>
                                <td colspan="3" class=" td">&emsp;借款人签字：<img src="/{$jiekuan.jk_file}" height='35px' alt=""></td>
                            </tr>

                            <tr>
                                <td colspan="3" class=" td">&emsp;预算审批人签字：<span id="ysspr"> <?php if($audit_userinfo['ys_audit_status']==2){echo "<span class='red'>不通过</span>"; }elseif ($audit_userinfo['ys_audit_status']==1){ echo "<img src='/$audit_userinfo[ys_audit_file]' height='35px'>";}; ?></span></td>
                                <td colspan="3" class=" td">&emsp;财务主管签字：<span id="cwzg"><?php if($audit_userinfo['cw_audit_status']==2){echo "<span class='red'>不通过</span>"; }elseif ($audit_userinfo['cw_audit_status']==1){ echo "<img src='/$audit_userinfo[cw_audit_file]' height='35px'>";}; ?></span></td>
                            </tr>
                            <tr id="print_time">
                                <td class="" colspan="6" style="text-align: right; ">打印时间：<?php echo date('Y-m-d H:i:s',time()); ?></td>
                            </tr>

                        </table>
                    </div>
                    <if condition="rolemenu(array('Finance/print_jkd'))">
                        <div class="content no-print">
                            <a href="{:U('Print/printLoanBill',array('jkids'=>$jiekuan['id']))}" class="btn btn-default"><i class="fa fa-print"></i> 打印</a>
                        </div>
                    </if>
                </div>
            </div><!--/.col (right) -->
        </div>

    <include file="audit_nopjk_form" />

<?php }else{ ?>
    <div class="content" style="padding-top:40px;">  获取借款信息失败!</div>
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
        var audit_usertype = '<?php echo $audit_usertype; ?>';
        $.ajax({
            type: 'POST',
            url : "{:U('Ajax/check_pwd')}",
            data: {pwd:pwd},
            success:function (msg) {
                if (msg.stu ==1){
                    var html = '';
                    if (audit_usertype ==1 ){
                        html += '<label>部门负责人审核：</label>'+
                            '<input type="hidden" name="info[manager_audit_file]" value="'+msg.file_url+'">'+
                            '<img width="100" src="/'+msg.file_url+'" alt="">';
                    }else if(audit_usertype ==2){
                        html += '<label>分管领导签字：</label>'+
                            '<input type="hidden" name="info[ys_audit_file]" value="'+msg.file_url+'">'+
                            '<img width="100" src="/'+msg.file_url+'" alt="">';
                    }else if(audit_usertype ==3){
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

    //打印部分页面 A4纸
    function print_A4_view(id){
        $('.a4-endwise').css({'height': '560px', 'border-bottom': '1px #AAAAAA dashed'});
        $('#jkd-table').css({'width': '90%','margin': '10px 5%'});
        document.body.innerHTML=document.getElementById(''+id+'').innerHTML;
        window.print();
    }
</script>
