<include file="print_header" />

<body>

<!--startprint-->
    <div class="a4-endwise" id="jiekuandan"  style="align: center;">

        <foreach name="lists" item="v">
            <div class="a4-page-tables">
                <div class="one-third-a4">
                    <table class="bxd-table" style="width: 99%;">
                        <tr>
                            <td  colspan="6" style="text-align: center;">
                                <b style="font-weight: 600;font-size: large;">{$company[$v[0]['company']]}报销单</b>
                            </td>
                        </tr>
                        <tr>
                            <td  colspan="6">
                                <div style="display: inline-block; float: left; min-width:230px; clear: left;">
                                    报销单编号：{$v[0]['bxd_id']}
                                </div>
                                <div style="display: inline-block; float: right; clear: right;">
                                    报销时间：{$v[0]['bx_time']|date='Y 年 m 月 d 日',###} &emsp;&emsp;
                                    支付方式：
                                    <foreach name="jk_type" key="kk" item="vv">
                                        <input type="radio" name="type" value="{$kk}" <?php if ($v[0]['type']== $kk) echo "checked"; ?> /> <?php if ($v[0]['type']== $kk) echo '√'; ?>{$vv} &nbsp;
                                    </foreach>
                                </div>
                            </td>
                        </tr>
                        <?php if ($v[0]['bxd_type']==1){ ?>
                            <!--团内支出报销-->
                            <tr>
                                <td class="td" colspan="2">&emsp;团号：<span class="black">{$v[0]['group_ids']}</span></td>
                                <td class="td" colspan="3">&emsp;项目名称：<span class="black">{$v[0]['project']}</span></td>
                                <td class="td">&emsp;计调：{$v[0]['req_uname']}</td>
                            </tr>
                        <?php } ?>
                        <tr>
                            <td colspan="6" class="td">
                                &emsp;用途说明：  {$v[0].description}
                            </td>
                        </tr>
                        <tr>
                            <td colspan="5" class="td">&emsp;报销金额：{$v[0].sum_chinese}</td>
                            <td colspan="1" class="td">&emsp;&yen;&emsp;<span class="black"><input type="text" style="border:none;border-bottom: solid 1px #808080; " value="{$v[0].sum}"></span>元</td>
                        </tr>
                        <tr>
                            <td colspan="6" class="td">&emsp;受款单位：{$v[0].payee}</td>
                        </tr>
                        <tr>
                            <td colspan="3" class="td">&emsp;开户行名称：{$v[0].bank_name}</td>
                            <td colspan="3" class="td">&emsp;账号：{$v[0].card_num}</td>
                        </tr>
                        <?php if ($v[0]['bxd_type']==1){ ?>
                            <!--团内支出报销-->
                            <tr>
                                <td colspan="3" class="td">&emsp;报销单位：{$v[0].department}</td>
                                <td colspan="3" class="td">&emsp;报销人签字：<img src="/{$v[0].bx_file}" height='35px' alt=""></td>
                            </tr>
                            <tr>
                                <td colspan="2" class="td">&emsp;证明验收人签字：<span id="zmysr"> <?php if($v[0]['zm_audit_status']==2){echo "<span class='red'>不通过</span>"; }elseif ($v[0]['zm_audit_status']==1){ echo "<img src='/".$v[0]['zm_audit_file']."' height='35px'>";}; ?></span></td>
                                <td colspan="2" class="td">&emsp;预算审批人签字：<span id="ysspr"> <?php if($v[0]['ys_audit_status']==2){echo "<span class='red'>不通过</span>"; }elseif ($v[0]['ys_audit_status']==1){ echo "<img src='/".$v[0]['ys_audit_file']."' height='35px'>";}; ?></span></td>
                                <td colspan="2" class="td">&emsp;财务主管签字：<span id="cwzg"><?php if($v[0]['cw_audit_status']==2){echo "<span class='red'>不通过</span>"; }elseif ($v[0]['cw_audit_status']==1){ echo "<img src='/".$v[0]['cw_audit_file']."' height='35px'>";}; ?></span></td>
                            </tr>
                        <?php }else{ ?>
                            <!--非团支出报销-->
                            <tr>
                                <td colspan="2" class="td">&emsp;报销单位：{$v[0].department}</td>
                                <td colspan="2" class="td">&emsp;报销人签字：<img src="/{$v[0].bx_file}" height='35px' alt=""></td>
                                <td colspan="2" class="td">&emsp;证明验收人签字：<span id="zmysr"> <?php if($v[0]['zm_audit_status']==2){echo "<span class='red'>不通过</span>"; }elseif ($v[0]['zm_audit_status']==1){ echo "<img src='/".$v[0]['zm_audit_file']."' height='35px'>";}; ?></span></td>
                            </tr>
                            <tr>
                                <td colspan="2" class="td">&emsp;部门主管签字：<span id="bmzg"> <?php if($v[0]['manager_audit_status']==2){echo "<span class='red'>不通过</span>"; }elseif ($v[0]['manager_audit_status']==1){ echo "<img src='/".$v[0]['manager_audit_file']."' height='35px'>";}; ?></span></td>
                                <td colspan="2" class="td">&emsp;部门分管领导签字：<span id="ysspr"> <?php if($v[0]['ys_audit_status']==2){echo "<span class='red'>不通过</span>"; }elseif ($v[0]['ys_audit_status']==1){ echo "<img src='/".$v[0]['ys_audit_file']."' height='35px'>";}; ?></span></td>
                                <td colspan="2" class="td">&emsp;财务主管签字：<span id="cwzg"><?php if($v[0]['cw_audit_status']==2){echo "<span class='red'>不通过</span>"; }elseif ($v[0]['cw_audit_status']==1){ echo "<img src='/".$v[0]['cw_audit_file']."' height='35px'>";}; ?></span></td>
                            </tr>
                        <?php } ?>
                        <tr>
                            <?php if ($v[0]['cw_remark']){ ?>
                                <td  colspan="3" class="td" >&emsp;财务备注：{$v[0].cw_remark}</td>
                                <td  colspan="3" class="td" >&emsp;打印时间：<?php echo date('Y-m-d H:i:s',time()); ?></td>
                            <?php }else{ ?>
                                <td  colspan="6" style="text-align: right; ">打印时间：<?php echo date('Y-m-d H:i:s',time()); ?></td>
                            <?php } ?>
                        </tr>
                        <?php if ($v[0]['bxd_type'] !=1){ ?>
                            <!--非团支出报销-->
                            <tr>
                                <td colspan="6">&emsp;</td>
                            </tr>
                        <?php } ?>
                    </table>
                </div>

                <if condition="$v[1]">
                    <div class="one-third-a4">
                        <table class="bxd-table" style="width: 99%;">
                            <tr>
                                <td  colspan="6" style="text-align: center;">
                                    <b style="font-weight: 600;font-size: large;">{$company[$v[1]['company']]}报销单</b>
                                </td>
                            </tr>
                            <tr>
                                <td  colspan="6">
                                    <div style="display: inline-block; float: left; min-width:230px; clear: left;">
                                        报销单编号：{$v[1]['bxd_id']}
                                    </div>
                                    <div style="display: inline-block; float: right; clear: right;">
                                        报销时间：{$v[1]['bx_time']|date='Y 年 m 月 d 日',###} &emsp;&emsp;
                                        支付方式：
                                        <foreach name="jk_type" key="kk" item="vv">
                                            <input type="radio" name="type" value="{$kk}" <?php if ($v[1]['type']== $kk) echo "checked"; ?> /> <?php if ($v[1]['type']== $kk) echo '√'; ?>{$vv} &nbsp;
                                        </foreach>
                                    </div>
                                </td>
                            </tr>

                            <?php if ($v[1]['bxd_type']==1){ ?>
                                <!--团内支出报销-->
                                <tr>
                                    <td class="td" colspan="2">&emsp;团号：<span class="black">{$v[1]['group_ids']}</span></td>
                                    <td class="td" colspan="3">&emsp;项目名称：<span class="black">{$v[1]['project']}</span></td>
                                    <td class="td">&emsp;计调：{$v[1]['req_uname']}</td>
                                </tr>
                            <?php } ?>

                            <tr>
                                <td colspan="6" class="td">
                                    &emsp;用途说明：  {$v[1].description}
                                </td>
                            </tr>
                            <tr>
                                <td colspan="5" class="td">&emsp;报销金额：{$v[1].sum_chinese}</td>
                                <td colspan="1" class="td">&emsp;&yen;&emsp;<span class="black"><input type="text" style="border:none;border-bottom: solid 1px #808080; " value="{$v[1].sum}"></span>元</td>
                            </tr>
                            <tr>
                                <td colspan="6" class="td">&emsp;受款单位：{$v[1].payee}</td>
                            </tr>
                            <tr>
                                <td colspan="3" class="td">&emsp;开户行名称：{$v[1].bank_name}</td>
                                <td colspan="3" class="td">&emsp;账号：{$v[1].card_num}</td>
                            </tr>
                            <?php if ($v[1]['bxd_type']==1){ ?>
                                <!--团内支出报销-->
                                <tr>
                                    <td colspan="3" class="td">&emsp;报销单位：{$v[1].department}</td>
                                    <td colspan="3" class="td">&emsp;报销人签字：<img src="/{$v[1].bx_file}" height='35px' alt=""></td>
                                </tr>
                                <tr>
                                    <td colspan="2" class="td">&emsp;证明验收人签字：<span id="zmysr"> <?php if($v[1]['zm_audit_status']==2){echo "<span class='red'>不通过</span>"; }elseif ($v[1]['zm_audit_status']==1){ echo "<img src='/".$v[1]['zm_audit_file']."' height='35px'>";}; ?></span></td>
                                    <td colspan="2" class="td">&emsp;预算审批人签字：<span id="ysspr"> <?php if($v[1]['ys_audit_status']==2){echo "<span class='red'>不通过</span>"; }elseif ($v[1]['ys_audit_status']==1){ echo "<img src='/".$v[1]['ys_audit_file']."' height='35px'>";}; ?></span></td>
                                    <td colspan="2" class="td">&emsp;财务主管签字：<span id="cwzg"><?php if($v[1]['cw_audit_status']==2){echo "<span class='red'>不通过</span>"; }elseif ($v[1]['cw_audit_status']==1){ echo "<img src='/".$v[1]['cw_audit_file']."' height='35px'>";}; ?></span></td>
                                </tr>
                            <?php }else{ ?>
                                <!--非团支出报销-->
                                <tr>
                                    <td colspan="2" class="td">&emsp;报销单位：{$v[1].department}</td>
                                    <td colspan="2" class="td">&emsp;报销人签字：<img src="/{$v[1].bx_file}" height='35px' alt=""></td>
                                    <td colspan="2" class="td">&emsp;证明验收人签字：<span id="zmysr"> <?php if($v[1]['zm_audit_status']==2){echo "<span class='red'>不通过</span>"; }elseif ($v[1]['zm_audit_status']==1){ echo "<img src='/".$v[1]['zm_audit_file']."' height='35px'>";}; ?></span></td>
                                </tr>
                                <tr>
                                    <td colspan="2" class="td">&emsp;部门主管签字：<span id="bmzg"> <?php if($v[1]['manager_audit_status']==2){echo "<span class='red'>不通过</span>"; }elseif ($v[1]['manager_audit_status']==1){ echo "<img src='/".$v[1]['manager_audit_file']."' height='35px'>";}; ?></span></td>
                                    <td colspan="2" class="td">&emsp;部门分管领导签字：<span id="ysspr"> <?php if($v[1]['ys_audit_status']==2){echo "<span class='red'>不通过</span>"; }elseif ($v[1]['ys_audit_status']==1){ echo "<img src='/".$v[1]['ys_audit_file']."' height='35px'>";}; ?></span></td>
                                    <td colspan="2" class="td">&emsp;财务主管签字：<span id="cwzg"><?php if($v[1]['cw_audit_status']==2){echo "<span class='red'>不通过</span>"; }elseif ($v[1]['cw_audit_status']==1){ echo "<img src='/".$v[1]['cw_audit_file']."' height='35px'>";}; ?></span></td>
                                </tr>
                            <?php } ?>

                            <tr>
                                <?php if ($v[1]['cw_remark']){ ?>
                                    <td  colspan="3" class="td" >&emsp;财务备注：{$v[1].cw_remark}</td>
                                    <td  colspan="3" class="td" >&emsp;打印时间：<?php echo date('Y-m-d H:i:s',time()); ?></td>
                                <?php }else{ ?>
                                    <td  colspan="6" style="text-align: right; ">打印时间：<?php echo date('Y-m-d H:i:s',time()); ?></td>
                                <?php } ?>
                            </tr>
                            <?php if ($v[1]['bxd_type'] !=1){ ?>
                                <!--非团支出报销-->
                                <tr>
                                    <td colspan="6">&emsp;</td>
                                </tr>
                            <?php } ?>
                        </table>
                    </div>
                </if>

                <if condition="$v[2]">
                    <div class="one-third-a4">
                        <table class="bxd-table" style="width: 99%;">
                            <tr>
                                <td  colspan="6" style="text-align: center;">
                                    <b style="font-weight: 600;font-size: large;">{$company[$v[2]['company']]}报销单</b>
                                </td>
                            </tr>
                            <tr>
                                <td  colspan="6">
                                    <div style="display: inline-block; float: left; min-width:230px; clear: left;">
                                        报销单编号：{$v[2]['bxd_id']}
                                    </div>
                                    <div style="display: inline-block; float: right; clear: right;">
                                        报销时间：{$v[2]['bx_time']|date='Y 年 m 月 d 日',###} &emsp;&emsp;
                                        支付方式：
                                        <foreach name="jk_type" key="kk" item="vv">
                                            <input type="radio" name="type" value="{$kk}" <?php if ($v[2]['type']== $kk) echo "checked"; ?> /> <?php if ($v[2]['type']== $kk) echo '√'; ?>{$vv} &nbsp;
                                        </foreach>
                                    </div>
                                </td>
                            </tr>

                            <?php if ($v[2]['bxd_type']==1){ ?>
                                <!--团内支出报销-->
                                <tr>
                                    <td class="td" colspan="2">&emsp;团号：<span class="black">{$v[2]['group_ids']}</span></td>
                                    <td class="td" colspan="3">&emsp;项目名称：<span class="black">{$v[2]['project']}</span></td>
                                    <td class="td">&emsp;计调：{$v[2]['req_uname']}</td>
                                </tr>
                            <?php }?>

                            <tr>
                                <td colspan="6" class="td">
                                    &emsp;用途说明：  {$v[2].description}
                                </td>
                            </tr>
                            <tr>
                                <td colspan="5" class="td">&emsp;报销金额：{$v[2].sum_chinese}</td>
                                <td colspan="1" class="td">&emsp;&yen;&emsp;<span class="black"><input type="text" style="border:none;border-bottom: solid 1px #808080; " value="{$v[2].sum}"></span>元</td>
                            </tr>
                            <tr>
                                <td colspan="6" class="td">&emsp;受款单位：{$v[2].payee}</td>
                            </tr>
                            <tr>
                                <td colspan="3" class="td">&emsp;开户行名称：{$v[2].bank_name}</td>
                                <td colspan="3" class="td">&emsp;账号：{$v[2].card_num}</td>
                            </tr>

                            <?php if ($v[2]['bxd_type']==1){ ?>
                                <!--团内支出报销-->
                                <tr>
                                    <td colspan="3" class="td">&emsp;报销单位：{$v[2].department}</td>
                                    <td colspan="3" class="td">&emsp;报销人签字：<img src="/{$v[2].bx_file}" height='35px' alt=""></td>
                                </tr>
                                <tr>
                                    <td colspan="2" class="td">&emsp;证明验收人签字：<span id="zmysr"> <?php if($v[2]['zm_audit_status']==2){echo "<span class='red'>不通过</span>"; }elseif ($v[2]['zm_audit_status']==1){ echo "<img src='/".$v[2]['zm_audit_file']."' height='35px'>";}; ?></span></td>
                                    <td colspan="2" class="td">&emsp;预算审批人签字：<span id="ysspr"> <?php if($v[2]['ys_audit_status']==2){echo "<span class='red'>不通过</span>"; }elseif ($v[2]['ys_audit_status']==1){ echo "<img src='/".$v[2]['ys_audit_file']."' height='35px'>";}; ?></span></td>
                                    <td colspan="2" class="td">&emsp;财务主管签字：<span id="cwzg"><?php if($v[2]['cw_audit_status']==2){echo "<span class='red'>不通过</span>"; }elseif ($v[2]['cw_audit_status']==1){ echo "<img src='/".$v[2]['cw_audit_file']."' height='35px'>";}; ?></span></td>
                                </tr>
                            <?php }else{ ?>
                                <!--非团支出报销-->
                                <tr>
                                    <td colspan="2" class="td">&emsp;报销单位：{$v[2].department}</td>
                                    <td colspan="2" class="td">&emsp;报销人签字：<img src="/{$v[2].bx_file}" height='35px' alt=""></td>
                                    <td colspan="2" class="td">&emsp;证明验收人签字：<span id="zmysr"> <?php if($v[2]['zm_audit_status']==2){echo "<span class='red'>不通过</span>"; }elseif ($v[2]['zm_audit_status']==1){ echo "<img src='/".$v[2]['zm_audit_file']."' height='35px'>";}; ?></span></td>
                                </tr>
                                <tr>
                                    <td colspan="2" class="td">&emsp;部门主管签字：<span id="bmzg"> <?php if($v[2]['manager_audit_status']==2){echo "<span class='red'>不通过</span>"; }elseif ($v[2]['manager_audit_status']==1){ echo "<img src='/".$v[2]['manager_audit_file']."' height='35px'>";}; ?></span></td>
                                    <td colspan="2" class="td">&emsp;部门分管领导签字：<span id="ysspr"> <?php if($v[2]['ys_audit_status']==2){echo "<span class='red'>不通过</span>"; }elseif ($v[2]['ys_audit_status']==1){ echo "<img src='/".$v[2]['ys_audit_file']."' height='35px'>";}; ?></span></td>
                                    <td colspan="2" class="td">&emsp;财务主管签字：<span id="cwzg"><?php if($v[2]['cw_audit_status']==2){echo "<span class='red'>不通过</span>"; }elseif ($v[2]['cw_audit_status']==1){ echo "<img src='/".$v[2]['cw_audit_file']."' height='35px'>";}; ?></span></td>
                                </tr>
                            <?php } ?>

                            <tr>
                                <?php if ($v[2]['cw_remark']){ ?>
                                    <td  colspan="3" class="td" >&emsp;财务备注：{$v[2].cw_remark}</td>
                                    <td  colspan="3" class="td" >&emsp;打印时间：<?php echo date('Y-m-d H:i:s',time()); ?></td>
                                <?php }else{ ?>
                                    <td  colspan="6" style="text-align: right; ">打印时间：<?php echo date('Y-m-d H:i:s',time()); ?></td>
                                <?php } ?>
                            </tr>
                            <?php if ($v[2]['bxd_type'] !=1){ ?>
                                <!--非团支出报销-->
                                <tr>
                                    <td colspan="6">&emsp;</td>
                                </tr>
                            <?php } ?>
                        </table>
                    </div>
                </if>
            </div>
        </foreach>
    </div>

<!--endprint-->

<script>
    $(function () {
        print_A4_view('jiekuandan');
    })


    //打印部分页面 A4纸
    function print_A4_view(id){
        $('.bxd-table').css({'width': '90%','margin': '30px 5%'});
        document.body.innerHTML=document.getElementById(''+id+'').innerHTML;
        window.print();
    }

    /**
     * [打印]
     * @return {[type]} [description]
     */
    /*function print_A4_view()
    {
        bdhtml=window.document.body.innerHTML;//获取当前页的html代码
        sprnstr="<!--startprint-->";//设置打印开始区域
        eprnstr="<!--endprint-->";//设置打印结束区域
        prnhtml=bdhtml.substring(bdhtml.indexOf(sprnstr)+18); //从开始代码向后取html
        prnhtml=prnhtml.substring(0,prnhtml.indexOf(eprnstr));//从结束代码向前取html
        window.document.body.innerHTML=prnhtml;
        window.print();
        window.document.body.innerHTML=bdhtml;
    }*/
</script>

</body>
</html>