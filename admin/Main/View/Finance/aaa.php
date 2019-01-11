<!DOCTYPE html>
<html lang="zh-CN">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!-- 上述3个meta标签*必须*放在最前面，任何其他内容都*必须*跟随其后！ -->
    <title>学员满意度测评表</title>

    <!-- Bootstrap -->
    <link href="https://cdn.bootcss.com/bootstrap/3.3.7/css/bootstrap.min.css" rel="stylesheet">

    <!-- HTML5 shim and Respond.js for IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
    <script src="https://cdn.bootcss.com/html5shiv/3.7.3/html5shiv.min.js"></script>
    <script src="https://cdn.bootcss.com/respond.js/1.4.2/respond.min.js"></script>
    <![endif]-->
</head>
<style>
    /*.a4-endwise{
        width: 1075px;
        height: 1567px;
        border: 1px red solid;
        overflow: hidden;
        padding: 0;
        word-break:break-all;
    }*/
    /*.a4-broadwise{
        width: 1569px;
        height: 1073px;
        border: 1px #000 solid;
        overflow: hidden;
        padding: 0;
        word-break:break-all;
    }*/

    .a4-endwise{
        width: 1050px;
        /*height: 1485px;*/
        height: 495px;
        border: 1px red solid;
        overflow: hidden;
        padding: 0;
        word-break:break-all;
    }

    .print{
        position: fixed;
        top: 1%;
        right: 10%;
    }
</style>
<body>
<a class="print" href="javascript:;" onclick="preview();">打印</a>
<!--startprint-->
<div class="container a4-endwise" id="test">
    <div class="" id="baoxiaodan" style="border: 1px solid red; padding: 0; height: 395px; ">
        <table style="width: 90%;margin: 0 5%;">
            <tr>
                <td class="" colspan="6" style="text-align: center;">
                    <b style="font-weight: 600;font-size: large;">报销单</b>
                </td>
            </tr>
            <tr>
                <td class="" colspan="6">
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
                <td class=" td" colspan="5">&emsp;报销单位：{$baoxiao.department}</td>
                <td class=" td">&emsp;报销时间：{$baoxiao['bx_time']|date='Y 年 m 月 d 日',###}</td>
            </tr>

            <tr>
                <td colspan="2" class=" td">&emsp;用途说明</td>
                <td colspan="4" class=" td">
                    <div class="">
                        {$baoxiao.description}
                    </div>
                </td>
            </tr>
            <tr>
                <td colspan="2" class=" td">&emsp;报销金额</td>
                <td colspan="3" class=" td">&emsp;{$baoxiao.sum_chinese}</td>
                <td class=" td">&emsp;&yen;&emsp;<input type="text" style="border:none;border-bottom: solid 1px #808080; " value="{$baoxiao.sum}">元</td>
            </tr>
            <tr>
                <td colspan="6" class=" td">&emsp;受款单位：{$baoxiao.payee}</td>
            </tr>
            <tr>
                <td colspan="3" class=" td">&emsp;开户行名称：{$baoxiao.bank_name}</td>
                <td colspan="3" class=" td">&emsp;账号：{$baoxiao.card_num}</td>
            </tr>

            <tr>
                <td class=" td" colspan="6">
                    <div style="display: inline-block; width: 30%;">&emsp;报销人签字：<img src="/{$baoxiao.bx_file}" height="35px" alt=""></div>
                    <div style="display: inline-block; width: 30%;">&emsp;证明验收人签字：<span id="zmysr"> <?php if($audit_userinfo['zm_audit_status']==2){echo "<span class='red'>不通过</span>"; }elseif ($audit_userinfo['zm_audit_status']==1){ echo "<img src='/$audit_userinfo[zm_audit_file]' height='35px'>";}; ?></span></div>
                    <div style="display: inline-block; width: 30%;">&emsp;部门主管签字：<span id="zmysr"> <?php if($audit_userinfo['manager_audit_status']==2){echo "<span class='red'>不通过</span>"; }elseif ($audit_userinfo['manager_audit_status']==1){ echo "<img src='/$audit_userinfo[manager_audit_file]' height='35px'>";}; ?></span></div>
                </td>
            </tr>

            <tr>
                <td colspan="3" class=" td" style="width: 50%;">&emsp;预算审批人签字：<span id="ysspr"> <?php if($audit_userinfo['ys_audit_status']==2){echo "<span class='red'>不通过</span>"; }elseif ($audit_userinfo['ys_audit_status']==1){ echo "<img src='/$audit_userinfo[ys_audit_file]' height='35px'>";}; ?></span></td>
                <td colspan="3" class=" td" style="width: 50%;">&emsp;财务主管签字：<span id="cwzg"><?php if($audit_userinfo['cw_audit_status']==2){echo "<span class='red'>不通过</span>"; }elseif ($audit_userinfo['cw_audit_status']==1){ echo "<img src='/$audit_userinfo[cw_audit_file]' height='35px'>";}; ?></span></td>
            </tr>
            <!--<tr id="print_time">
                            <td class="" colspan="6" style="text-align: right; ">打印时间：<?php /*echo date('Y-m-d H:i:s',time()); */?></td>
                        </tr>-->

        </table>
    </div>
</div>
<!--<div class="container a4-endwise">

</div>
<div class="container a4-endwise">

</div>-->
<!--endprint-->

<!-- jQuery (necessary for Bootstrap's JavaScript plugins) -->
<script src="https://cdn.bootcss.com/jquery/1.12.4/jquery.min.js"></script>
<!-- Include all compiled plugins (below), or include individual files as needed -->
<script src="https://cdn.bootcss.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
<script>
    /**
     * [打印]
     * @return {[type]} [description]
     */
    function preview()
    {
        bdhtml=window.document.body.innerHTML;//获取当前页的html代码
        sprnstr="<!--startprint-->";//设置打印开始区域
        eprnstr="<!--endprint-->";//设置打印结束区域
        prnhtml=bdhtml.substring(bdhtml.indexOf(sprnstr)+18); //从开始代码向后取html
        prnhtml=prnhtml.substring(0,prnhtml.indexOf(eprnstr));//从结束代码向前取html
        window.document.body.innerHTML=prnhtml;
        window.print();
        window.document.body.innerHTML=bdhtml;
    }
</script>

</body>
</html>