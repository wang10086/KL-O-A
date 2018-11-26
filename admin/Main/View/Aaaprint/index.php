<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN">
<html>
<head>
    <script src="__HTML__/js/jquery-1.7.2.min.js"></script>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
    <title>2018年11月工资发放表</title>
    <style>
        @media print{
            INPUT {display:none}
        }
    </style>
</head>

<body>

<TABLE border="0" style="font-size:9pt;" width="100%" align="center">
    <THEAD style="display:table-header-group;font-weight:bold">
    <tr role="row" class="orders" style="font-weight:bold;border:3px double red">
        <td class="sorting" style="width:5em;background-color:#66CCFF;">ID</td>
        <td class="sorting" style="width:8em;background-color:#66CCFF;">员工姓名</td>
        <td class="sorting aaa" style="width:20em;background-color:#66CCFF;">岗位名称</td>
        <td class="sorting" style="width:14em;background-color:#66CCFF;">所属部门</td>
        <td class="sorting" style="width:10em;background-color:#66CCFF;">岗位薪酬标准</td>
        <td class="sorting" style="width:10em;background-color:#66CCFF;">其中基本工资标准</td>
        <td class="sorting" style="width:9em;background-color:#66CCFF;">考勤扣款</td>
        <td class="sorting" style="width:10em;background-color:#66CCFF;">其中绩效工资标准</td>
        <td class="sorting" style="width:9em;background-color:#66CCFF;">绩效增减</td>
        <td class="sorting" style="width:9em;background-color:#66CCFF;">业绩提成</td>
        <td class="sorting" style="width:9em;background-color:#66CCFF;">奖金</td>
        <td class="sorting" style="width:9em;background-color:#66CCFF;">住房补贴</td>
        <td class="sorting" style="width:8em;background-color:#66CCFF;">其他补款</td>
        <td class="sorting" style="width:8em;background-color:#66CCFF;">应发工资</td>
        <td class="sorting" style="width:9em;background-color:#66CCFF;">医疗保险</td>
        <td class="sorting" style="width:9em;background-color:#66CCFF;">养老保险</td>
        <td class="sorting" style="width:9em;background-color:#66CCFF;">失业保险</td>
        <td class="sorting" style="width:9em;background-color:#66CCFF;">公积金</td>
        <td class="sorting" style="width:9em;background-color:#66CCFF;">个人保险合计</td>
        <td class="sorting" style="width:9em;background-color:#66CCFF;">计税工资</td>
        <td class="sorting" style="width:9em;background-color:#66CCFF;">个人所得税</td>
        <td class="sorting" style="width:9em;background-color:#66CCFF;">税后扣款</td>
        <td class="sorting" style="width:9em;background-color:#66CCFF;">工会会费</td>
        <td class="sorting" style="width:9em;background-color:#66CCFF;">实发工资</td>
    </tr>
    <!--<TR><TD colspan="2" align="center" style="font-weight:bold;border:3px double red">每页都有的表头</TD></TR>-->
    </THEAD>
    <TBODY style="text-align:center"">
    <foreach name="info" item="info">
    <tr style="page-break-after:always;">
        <td>{$info['account']['id']}</td>
        <td style="color:#3399FF;">{$info['account']['nickname']}</td>
        <td class="aaa">{$info['posts'][0]['post_name']}</td>
        <td>{$info['department'][0]['department']}</td>
        <td>&yen; {$info['salary'][0]['standard_salary']}</td>
        <td>&yen; <?PHP echo sprintf("%.2f",($info['salary'][0]['standard_salary']/10*$info['salary'][0]['basic_salary']));?></td>
        <td>&yen; <?php echo sprintf("%.2f",($info['attendance'][0]['withdrawing']));?></td>
        <td>&yen; <?PHP echo sprintf("%.2f",($info['salary'][0]['standard_salary']/10*$info['salary'][0]['performance_salary']));?></td>
        <td>&yen; <?PHP echo sprintf("%.2f",$info['Achievements']['count_money']);?></td>
        <td>&yen; <?PHP echo sprintf("%.2f",$info['Extract']['total']);?></td>


        <td>&yen; <?PHP echo sprintf("%.2f",$info['bonus'][0]['foreign_bonus']);?></td>
        <td>&yen; <?PHP echo sprintf("%.2f",$info['subsidy'][0]['housing_subsidy']);?></td>
        <td>&yen; <?PHP echo sprintf("%.2f",$info['Other']);?></td>
        <td>&yen; <?PHP echo sprintf("%.2f",$info['Should']);?></td>
        <td>&yen; <?PHP echo sprintf("%.3f",($info['insurance'][0]['medical_care_base']*$info['insurance'][0]['medical_care_ratio']+$info['insurance'][0]['big_price']));?></td>
        <td>&yen; <?PHP echo sprintf("%.3f",($info['insurance'][0]['pension_base']*$info['insurance'][0]['pension_ratio']));?></td>
        <td>&yen; <?PHP echo sprintf("%.3f",($info['insurance'][0]['unemployment_base']*$info['insurance'][0]['unemployment_ratio']));?></td>
        <td>&yen; <?PHP echo sprintf("%.2f",$info['accumulation']);?></td>
        <td>&yen; <?PHP echo sprintf("%.3f",$info['insurance_Total']);?></td>
        <td>&yen; <?PHP echo sprintf("%.2f",$info['tax_counting']);?></td>
        <td>&yen; <?PHP echo sprintf("%.2f",$info['personal_tax']);?></td>
        <td>&yen; <?PHP echo sprintf("%.2f",$info['summoney']);?></td>
        <td>&yen; <?PHP echo sprintf("%.2f",$info['labour']['Labour_money']);?></td>
        <td>&yen; <?PHP echo sprintf("%.2f",$info['real_wages']);?></td>
        <td style="display:none">{$info['salary'][0]['id']}</td>
        <td style="display:none">{$info['attendance'][0]['id']}</td>
        <td style="display:none">{$info['bonus'][0]['id']}</td>
        <td style="display:none">{$info['income'][0]['income_token']}</td>
        <td style="display:none">{$info['insurance'][0]['id']}</td>
        <td style="display:none">{$info['subsidy'][0]['id']}</td>
        <td style="display:none">{$info['withholding'][0]['token']}</td>
        <td style="display:none">{$info['Achievements']['total_score_show']}</td>
        <td style="display:none">{$info['Achievements']['show_qa_score']}</td>
        <td style="display:none">{$info['Achievements']['sum_total_score']}</td>
        <td style="display:none">{$info['Extract']['target']}</td>
        <td style="display:none">{$info['Extract']['complete']}</td>
        <td style="display:none">{$info['yearend']}</td>
        <td style="display:none">{$info['bonus'][0]['extract']}</td>
        <td style="display:none">{$info['welfare']}</td>
        <td style="display:none">{$info['labour']['id']}</td>
    </tr>
    </foreach>

    <foreach name="sum" item="sum">
        <tr class="excel_list_money2">
            <td class="bbb" colspan="3" style="text-align: center;">{$sum['name']}</td>
            <td>{$sum['department']}</td>
            <td>&yen; <?PHP echo sprintf("%.2f",$sum['standard_salary']);?></td>
            <td>&yen; <?PHP echo sprintf("%.2f",$sum['basic']);?></td>
            <td>&yen; <?php echo sprintf("%.2f",$sum['withdrawing']);?></td>
            <td>&yen; <?PHP echo sprintf("%.2f",$sum['performance_salary']);?></td>
            <td>&yen; <?PHP echo sprintf("%.2f",$sum['count_money']);?></td>
            <td>&yen; <?PHP echo sprintf("%.2f",$sum['total']);?></td>
            <td>&yen; <?PHP echo sprintf("%.2f",$sum['bonus']);?></td>
            <td>&yen; <?PHP echo sprintf("%.2f",$sum['housing_subsidy']);?></td>
            <td>&yen; <?PHP echo sprintf("%.2f",$sum['Other']);?></td>
            <td>&yen; <?PHP echo sprintf("%.2f",$sum['Should']);?></td>
            <td>&yen; <?PHP echo sprintf("%.3f",$sum['care']);?></td>
            <td>&yen; <?PHP echo sprintf("%.3f",$sum['pension']);?></td>
            <td>&yen; <?PHP echo sprintf("%.3f",$sum['unemployment']);?></td>
            <td>&yen; <?PHP echo sprintf("%.2f",$sum['accumulation']);?></td>
            <td>&yen; <?PHP echo sprintf("%.3f",$sum['insurance_Total']);?></td>
            <td>&yen; <?PHP echo sprintf("%.2f",$sum['tax_counting']);?></td>
            <td>&yen; <?PHP echo sprintf("%.2f",$sum['personal_tax']);?></td>
            <td>&yen; <?PHP echo sprintf("%.2f",$sum['summoney']);?></td>
            <td>&yen; <?PHP echo sprintf("%.2f",$sum['Labour']);?></td>
            <td>&yen; <?PHP echo sprintf("%.2f",$sum['real_wages']);?></td>
        </tr>
        <th class="list_salary_detail2" style="display: none">{$sum['id']}</th>
    </foreach>
    <tr class="excel_list_money3">
        <td class='ccc' colspan="4" style="text-align: center;">{$count['name']}</td>
        <td>&yen; <?PHP echo sprintf("%.2f",$count['standard_salary']);?></td>
        <td>&yen; <?PHP echo sprintf("%.2f",$count['basic']);?></td>
        <td>&yen; <?PHP echo sprintf("%.2f",$count['withdrawing']);?></td>
        <td>&yen; <?PHP echo sprintf("%.2f",$count['performance_salary']);?></td>
        <td>&yen; <?PHP echo sprintf("%.2f",$count['count_money']);?></td>
        <td>&yen; <?PHP echo sprintf("%.2f",$count['total']);?></td>
        <td>&yen; <?PHP echo sprintf("%.2f",$count['bonus']);?></td>
        <td>&yen; <?PHP echo sprintf("%.2f",$count['housing_subsidy']);?></td>
        <td>&yen; <?PHP echo sprintf("%.2f",$count['Other']);?></td>
        <td>&yen; <?PHP echo sprintf("%.2f",$count['Should']);?></td>
        <td>&yen; <?PHP echo sprintf("%.3f",$count['care']);?></td>
        <td>&yen; <?PHP echo sprintf("%.3f",$count['pension']);?></td>
        <td>&yen; <?PHP echo sprintf("%.3f",$count['unemployment']);?></td>
        <td>&yen; <?PHP echo sprintf("%.2f",$count['accumulation']);?></td>
        <td>&yen; <?PHP echo sprintf("%.3f",$count['insurance_Total']);?></td>
        <td>&yen; <?PHP echo sprintf("%.2f",$count['tax_counting']);?></td>
        <td>&yen; <?PHP echo sprintf("%.2f",$count['personal_tax']);?></td>
        <td>&yen; <?PHP echo sprintf("%.2f",$count['summoney']);?></td>
        <td>&yen; <?PHP echo sprintf("%.2f",$count['Labour']);?></td>
        <td>&yen; <?PHP echo sprintf("%.2f",$count['real_wages']);?></td>
    </tr>
    <th class="list_salary_datetime" style="display: none">{$count['datetime']}</th>
    <th class="list_salary_detail3" style="display: none">{$count['id']}</th>
    </TBODY>
    <TFOOT style="display:table-footer-group;font-weight:bold" >
    <tr>
        <td colspan="6" style="text-align: center;">
           提交人 : <img src="__HTML__/img/test.png" alt="" style="max-height: 50px">
        </td>
        <td colspan="6" style="text-align: center;">
            审核人 : <?php if (1>2){echo "<img src='__HTML__/img/test.png' alt='' style='max-height: 50px'>";}else{echo "暂未审核";} ?>
        </td>
        <td colspan="6" style="text-align: center;">
            批准人 : <?php if (1>2){echo "<img src='__HTML__/img/test.png' alt='' style='max-height: 50px'>";}else{echo "暂未批准";} ?>
        </td>
        <td class="ddd" colspan="6" style="text-align: center;">
            打印时间: <?php echo date("Y-m-d H:i:s",time()); ?>
        </td>
    </tr>
    </TFOOT>
</TABLE>
<!--<input type=button value=" 打 印 " onclick=javascript:window.print()>-->
<input type=button value=" 打 印 " onclick="print_aa()">
</body>
</html>

<script>
    function print_aa() {
       $('.aaa').hide();
        $(".bbb").attr("colspan",2);
        $(".ccc").attr("colspan",3);
        $(".ddd").attr("colspan",5);
        window.print();
    }
</script>