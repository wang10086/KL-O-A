<include file="print_header" />

<body>
    <div class="a4-endwise" id="jiekuandan"  style="align: center;">
        <div class="a4-page-tables">
            <div class="one-third-a4">
                <table class="jkd-table" style="width: 99%;">
                    <tr>
                        <td  colspan="6" style="text-align: center;">
                            <b style="font-weight: 600;font-size: large;">报销单</b>
                        </td>
                    </tr>
                    <tr>
                        <td  colspan="6">
                            <div style="display: inline-block; float: left; min-width:230px; clear: left;">
                                报销单编号：{$list['bxd_id']}
                            </div>
                            <div style="display: inline-block; float: right; clear: right;">
                                报销时间：{$list['bx_time']|date='Y 年 m 月 d 日',###} &emsp;&emsp;
                                支付方式：
                                <foreach name="bx_type" key="kk" item="vv">
                                    <input type="radio" name="type" value="{$kk}" <?php if ($list['type']== $kk) echo "checked"; ?> /> <?php if ($list['type']== $kk) echo '√'; ?>{$vv} &nbsp;
                                </foreach>
                            </div>
                        </td>
                    </tr>
                    <?php if (in_array($list['bxd_type'],array(2,3))){ ?>
                        <!--非团借款报销+直接报销-->
                        <tr>
                            <td class="td" colspan="6">&emsp;报销信息：非团支出报销</td>
                        </tr>
                    <?php }else{ ?>
                        <!--团内支出报销-->
                        <tr>
                            <td class="td" colspan="2">&emsp;团号：{$list['group_ids']}</td>
                            <td class="td" colspan="3">&emsp;项目名称：{$list['project']}</td>
                            <td class="td">&emsp;计调：{$list['req_uname']}</td>
                        </tr>
                    <?php } ?>
                    <tr>
                        <td colspan="6" class="td">
                            &emsp;用途说明：  {$list.description}
                        </td>
                    </tr>
                    <tr>
                        <td colspan="3" class="td">&emsp;报销金额：{$list.sum_chinese}</td>
                        <td colspan="3" class="td">&emsp;&yen;&emsp;<input type="text" style="border:none;border-bottom: solid 1px #808080; " value="{$list.sum}">元</td>
                    </tr>
                    <tr>
                        <td colspan="6" class="td">&emsp;受款单位：{$list.payee}</td>
                    </tr>
                    <tr>
                        <td colspan="3" class="td">&emsp;开户行名称：{$list.bank_name}</td>
                        <td colspan="3" class="td">&emsp;账号：{$list.card_num}</td>
                    </tr>
                    <tr>
                        <td colspan="2" class="td">&emsp;报销单位：{$list.department}</td>
                        <td colspan="2" class="td">&emsp;报销人签字：<img src="/{$list.bx_file}" height='35px' alt=""></td>
                        <td colspan="2" class="td">证明验收人签字：<span id="zmysr"> <?php if($list['zm_audit_status']==2){echo "<span class='red'>不通过</span>"; }elseif ($list['zm_audit_status']==1){ echo "<img src='/".$list['zm_audit_file']."' height='50px'>";}; ?></span></td>
                    </tr>
                    <?php if (in_array($list['bxd_type'],array(2,3))){ ?>
                        <!--非团支出报销+直接报销-->
                        <tr>
                            <td colspan="2" class="td">&emsp;部门主管签字：<span id=""> <?php if($list['manager_audit_status']==2){echo "<span class='red'>不通过</span>"; }elseif ($list['manager_audit_status']==1){ echo "<img src='/".$list['manager_audit_file']."' height='35px'>";}; ?></span></td>
                            <td colspan="2" class="td">&emsp;部门分管领导签字：<span id="ysspr"> <?php if($list['ys_audit_status']==2){echo "<span class='red'>不通过</span>"; }elseif ($list['ys_audit_status']==1){ echo "<img src='/".$list['ys_audit_file']."' height='35px'>";}; ?></span></td>
                            <td colspan="2" class="td">&emsp;财务主管签字：<span id="cwzg"><?php if($list['cw_audit_status']==2){echo "<span class='red'>不通过</span>"; }elseif ($list['cw_audit_status']==1){ echo "<img src='/".$list['cw_audit_file']."' height='35px'>";}; ?></span></td>
                        </tr>
                    <?php }else{ ?>
                        <!--团内支出报销-->
                        <tr>
                            <td colspan="3" class="td">&emsp;预算审批人签字：<span id="ysspr"> <?php if($list['ys_audit_status']==2){echo "<span class='red'>不通过</span>"; }elseif ($list['ys_audit_status']==1){ echo "<img src='/".$list['ys_audit_file']."' height='35px'>";}; ?></span></td>
                            <td colspan="3" class="td">&emsp;财务主管签字：<span id="cwzg"><?php if($list['cw_audit_status']==2){echo "<span class='red'>不通过</span>"; }elseif ($list['cw_audit_status']==1){ echo "<img src='/".$list['cw_audit_file']."' height='35px'>";}; ?></span></td>
                        </tr>
                    <?php } ?>
                    <tr id="print_time">
                        <td  colspan="6" style="text-align: right; ">打印时间：<?php echo date('Y-m-d H:i:s',time()); ?></td>
                    </tr>
                </table>
            </div>
        </div>
    </div>

<script>
    $(function () {
        print_A4_view('jiekuandan');
    })


    //打印部分页面 A4纸
    function print_A4_view(id){
        $('.jkd-table').css({'width': '90%','margin': '30px 5%'});
        document.body.innerHTML=document.getElementById(''+id+'').innerHTML;
        window.print();
    }

</script>

</body>
</html>