<?php use Sys\P; ?>
<!DOCTYPE html>
<html lang="zh-CN">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!-- 上述3个meta标签*必须*放在最前面，任何其他内容都*必须*跟随其后！ -->

    <title><?php echo P::SYSTEM_NAME; ?></title>
    <!-- bootstrap 3.0.2 -->
    <link href="__HTML__/css/bootstrap.min.css" rel="stylesheet" type="text/css" />

    <!-- Theme style -->
    <link href="__HTML__/css/py.css" rel="stylesheet" type="text/css" />
    <!--[if lt IE 9]>
    <script src="__HTML__/js/html5shiv.min.js"></script>
    <script src="__HTML__/js/respond.min.js"></script>
    <![endif]-->
    <?php /*echo PHP_EOL . $__additional_css__ */?>

    <!-- jQuery (necessary for Bootstrap's JavaScript plugins) -->
    <script src="https://cdn.bootcss.com/jquery/1.12.4/jquery.min.js"></script>
    <!-- Include all compiled plugins (below), or include individual files as needed -->
    <script src="https://cdn.bootcss.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>

</head>
<style>
    .a4-endwise{
        width: 100%;
        /*height: 1485px;*/
        overflow: hidden;
        padding: 0;
        word-break:break-all;
    }

    .a4-page-tables{
        page-break-before: auto;
        page-break-after: always;
    }

    .a4-page-tables table tr td{ font-size: 12px;  padding-top: 3px;  padding-bottom: 3px;  position: relative;}
    .one-third-a4{ height: 350px; margin: 16px 0; border: dashed 1px #ffffff;}

    @page{
        margin:0
    }

</style>
<body>
<!--startprint-->
    <div class="a4-endwise" id="jiekuandan"  style="align: center;">

        <foreach name="lists" item="v">
            <div class="a4-page-tables">
                <div class="one-third-a4">
                    <table class="jkd-table" style="width: 99%;">
                        <tr>
                            <td  colspan="6" style="text-align: center;">
                                <b style="font-weight: 600;font-size: large;">借款单</b>
                            </td>
                        </tr>
                        <tr>
                            <td  colspan="6">
                                <div style="display: inline-block; float: left; min-width:230px; clear: left;">
                                    借款单编号：{$v[0]['jkd_id']}
                                </div>
                                <div style="display: inline-block; float: right; clear: right;">
                                    借款时间：{$v[0]['jk_time']|date='Y 年 m 月 d 日',###} &emsp;&emsp;
                                    支付方式：
                                    <foreach name="jk_type" key="kk" item="vv">
                                        <input type="radio" name="type" value="{$kk}" <?php if ($v[0]['type']== $kk) echo "checked"; ?> /> <?php if ($v[0]['type']== $kk) echo '√'; ?>{$vv} &nbsp;
                                    </foreach>
                                </div>
                            </td>
                        </tr>
                        <tr>
                            <td class="td" colspan="2">&emsp;团号：{$v[0]['group_id']}</td>
                            <td class="td" colspan="3">&emsp;项目名称：{$v[0]['project']}</td>
                            <td class="td">&emsp;计调：{$v[0]['req_uname']}</td>
                        </tr>
                        <tr>
                            <td colspan="6" class="td">
                                &emsp;用途说明：  {$v[0].description}
                            </td>
                        </tr>
                        <tr>
                            <td colspan="3" class="td">&emsp;借款金额：{$v[0].sum_chinese}</td>
                            <td colspan="3" class="td">&emsp;&yen;&emsp;<input type="text" style="border:none;border-bottom: solid 1px #808080; " value="{$v[0].sum}">元</td>
                        </tr>
                        <tr>
                            <td colspan="6" class="td">&emsp;受款单位：{$v[0].payee}</td>
                        </tr>
                        <tr>
                            <td colspan="3" class="td">&emsp;开户行名称：{$v[0].bank_name}</td>
                            <td colspan="3" class="td">&emsp;账号：{$v[0].card_num}</td>
                        </tr>
                        <tr>
                            <td colspan="3" class="td">&emsp;借款单位：{$v[0].department}</td>
                            <td colspan="3" class="td">&emsp;借款人签字：<img src="/{$v[0].jk_file}" height='35px' alt=""></td>
                        </tr>
                        <tr>
                            <td colspan="3" class="td">&emsp;预算审批人签字：<span id="ysspr"> <?php if($v[0]['ys_audit_status']==2){echo "<span class='red'>不通过</span>"; }elseif ($v[0]['ys_audit_status']==1){ echo "<img src='/".$v[0]['ys_audit_file']."' height='35px'>";}; ?></span></td>
                            <td colspan="3" class="td">&emsp;财务主管签字：<span id="cwzg"><?php if($v[0]['cw_audit_status']==2){echo "<span class='red'>不通过</span>"; }elseif ($v[0]['cw_audit_status']==1){ echo "<img src='/".$v[0]['cw_audit_file']."' height='35px'>";}; ?></span></td>
                        </tr>
                        <tr id="print_time">
                            <td  colspan="6" style="text-align: right; ">打印时间：<?php echo date('Y-m-d H:i:s',time()); ?></td>
                        </tr>
                    </table>
                </div>

                <if condition="$v[1]">
                    <div class="one-third-a4">
                        <table class="jkd-table" style="width: 99%;">
                            <tr>
                                <td  colspan="6" style="text-align: center;">
                                    <b style="font-weight: 600;font-size: large;">借款单</b>
                                </td>
                            </tr>
                            <tr>
                                <td  colspan="6">
                                    <div style="display: inline-block; float: left; min-width:230px; clear: left;">
                                        借款单编号：{$v[1]['jkd_id']}
                                    </div>
                                    <div style="display: inline-block; float: right; clear: right;">
                                        借款时间：{$v[1]['jk_time']|date='Y 年 m 月 d 日',###} &emsp;&emsp;
                                        支付方式：
                                        <foreach name="jk_type" key="kk" item="vv">
                                            <input type="radio" name="type" value="{$kk}" <?php if ($v[1]['type']== $kk) echo "checked"; ?> /> <?php if ($v[1]['type']== $kk) echo '√'; ?>{$vv} &nbsp;
                                        </foreach>
                                    </div>
                                </td>
                            </tr>
                            <tr>
                                <td class="td" colspan="2">&emsp;团号：{$v[1]['group_id']}</td>
                                <td class="td" colspan="3">&emsp;项目名称：{$v[1]['project']}</td>
                                <td class="td">&emsp;计调：{$v[1]['req_uname']}</td>
                            </tr>
                            <tr>
                                <td colspan="6" class="td">
                                    &emsp;用途说明：  {$v[1].description}
                                </td>
                            </tr>
                            <tr>
                                <td colspan="3" class="td">&emsp;借款金额：{$v[1].sum_chinese}</td>
                                <td colspan="3" class="td">&emsp;&yen;&emsp;<input type="text" style="border:none;border-bottom: solid 1px #808080; " value="{$v[1].sum}">元</td>
                            </tr>
                            <tr>
                                <td colspan="6" class="td">&emsp;受款单位：{$v[1].payee}</td>
                            </tr>
                            <tr>
                                <td colspan="3" class="td">&emsp;开户行名称：{$v[1].bank_name}</td>
                                <td colspan="3" class="td">&emsp;账号：{$v[1].card_num}</td>
                            </tr>
                            <tr>
                                <td colspan="3" class="td">&emsp;借款单位：{$v[1].department}</td>
                                <td colspan="3" class="td">&emsp;借款人签字：<img src="/{$v[1].jk_file}" height='35px' alt=""></td>
                            </tr>
                            <tr>
                                <td colspan="3" class="td">&emsp;预算审批人签字：<span id="ysspr"> <?php if($v[1]['ys_audit_status']==2){echo "<span class='red'>不通过</span>"; }elseif ($v[1]['ys_audit_status']==1){ echo "<img src='/".$v[1]['ys_audit_file']."' height='35px'>";}; ?></span></td>
                                <td colspan="3" class="td">&emsp;财务主管签字：<span id="cwzg"><?php if($v[1]['cw_audit_status']==2){echo "<span class='red'>不通过</span>"; }elseif ($v[1]['cw_audit_status']==1){ echo "<img src='/".$v[1]['cw_audit_file']."' height='35px'>";}; ?></span></td>
                            </tr>
                            <tr id="print_time">
                                <td  colspan="6" style="text-align: right; ">打印时间：<?php echo date('Y-m-d H:i:s',time()); ?></td>
                            </tr>
                        </table>
                    </div>
                </if>

                <if condition="$v[2]">
                    <div class="one-third-a4">
                        <table class="jkd-table" style="width: 99%;">
                            <tr>
                                <td  colspan="6" style="text-align: center;">
                                    <b style="font-weight: 600;font-size: large;">借款单</b>
                                </td>
                            </tr>
                            <tr>
                                <td  colspan="6">
                                    <div style="display: inline-block; float: left; min-width:230px; clear: left;">
                                        借款单编号：{$v[2]['jkd_id']}
                                    </div>
                                    <div style="display: inline-block; float: right; clear: right;">
                                        借款时间：{$v[2]['jk_time']|date='Y 年 m 月 d 日',###} &emsp;&emsp;
                                        支付方式：
                                        <foreach name="jk_type" key="kk" item="vv">
                                            <input type="radio" name="type" value="{$kk}" <?php if ($v[2]['type']== $kk) echo "checked"; ?> /> <?php if ($v[2]['type']== $kk) echo '√'; ?>{$vv} &nbsp;
                                        </foreach>
                                    </div>
                                </td>
                            </tr>
                            <tr>
                                <td class="td" colspan="2">&emsp;团号：{$v[2]['group_id']}</td>
                                <td class="td" colspan="3">&emsp;项目名称：{$v[2]['project']}</td>
                                <td class="td">&emsp;计调：{$v[2]['req_uname']}</td>
                            </tr>
                            <tr>
                                <td colspan="6" class="td">
                                    &emsp;用途说明：  {$v[2].description}
                                </td>
                            </tr>
                            <tr>
                                <td colspan="3" class="td">&emsp;借款金额：{$v[2].sum_chinese}</td>
                                <td colspan="3" class="td">&emsp;&yen;&emsp;<input type="text" style="border:none;border-bottom: solid 1px #808080; " value="{$v[2].sum}">元</td>
                            </tr>
                            <tr>
                                <td colspan="6" class="td">&emsp;受款单位：{$v[2].payee}</td>
                            </tr>
                            <tr>
                                <td colspan="3" class="td">&emsp;开户行名称：{$v[2].bank_name}</td>
                                <td colspan="3" class="td">&emsp;账号：{$v[2].card_num}</td>
                            </tr>
                            <tr>
                                <td colspan="3" class="td">&emsp;借款单位：{$v[2].department}</td>
                                <td colspan="3" class="td">&emsp;借款人签字：<img src="/{$v[2].jk_file}" height='35px' alt=""></td>
                            </tr>
                            <tr>
                                <td colspan="3" class="td">&emsp;预算审批人签字：<span id="ysspr"> <?php if($v[2]['ys_audit_status']==2){echo "<span class='red'>不通过</span>"; }elseif ($v[2]['ys_audit_status']==1){ echo "<img src='/".$v[2]['ys_audit_file']."' height='35px'>";}; ?></span></td>
                                <td colspan="3" class="td">&emsp;财务主管签字：<span id="cwzg"><?php if($v[2]['cw_audit_status']==2){echo "<span class='red'>不通过</span>"; }elseif ($v[2]['cw_audit_status']==1){ echo "<img src='/".$v[2]['cw_audit_file']."' height='35px'>";}; ?></span></td>
                            </tr>
                            <tr id="print_time">
                                <td  colspan="6" style="text-align: right; ">打印时间：<?php echo date('Y-m-d H:i:s',time()); ?></td>
                            </tr>
                        </table>
                    </div>
                </if>
            </div>
        </foreach>
    </div>

    <if condition="rolemenu(array('Finance/print_jkd'))">
        <!--<div class="content no-print">
            <button class="btn btn-default" onclick="print_A4_view('jiekuandan');"><i class="fa fa-print"></i> 打印</button>
        </div>-->
    </if>

<!--endprint-->

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