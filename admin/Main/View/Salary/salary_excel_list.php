<include file="Index:header" />

<style>
    #bordorcolor{
        border:1px solid rgb(0,0,0);
    }
    @media print{
        INPUT {display:none}
    }
    th{
       border=1px solid #000000;
    }
    td{
         border=1px solid #000000;
     }


</style>
<script src="__HTML__/js/public.js?v=1.0.6" type="text/javascript"></script>
<aside class="right-side">
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <h1>工资表</h1>
        <ol class="breadcrumb">
            <li><a href="{:U('Index/index')}"><i class="fa fa-home"></i> 首页</a></li>
            <li><a href="{:U('Salary/salaryindex')}"><i class="fa fa-gift"></i>人力管理</a></li>
            <li class="active">生成工资表</li>
        </ol>

    </section>

    <!-- Main content -->
    <section class="content" >

        <div class="row">
            <div class="col-xs-12" >
                <div class="box box-warning" >
                    <div class="box-header" >
                        <h3 class="box-title">员工薪资列表</h3>
                        <a href="javascript:;" class="btn btn-info btn-sm" onclick="javascript:opensearch('searchtext',500,160);" style="margin: 0.7em 0em 0em 3em;" ><i class="fa fa-search"></i> 搜索</a>
                        <a  href="{:U('Salary/salary_exportExcel',array('datetime'=>$datetime,'type'=>$type))}" class="btn btn-info btn-sm" style="margin:1em 0em 0em 3em;" />导出 Excel</a>
                        <a class="btn btn-default" onclick="salary2();" style="margin:0.8em 0em 0em 2em;color:#000000;background-color: lightgrey;"><i class="fa fa-print"></i> 打印</a>

                        <h3 class="box-title pull-right" style="font-weight:normal; color:#333333;">
                           状态：<?php if(!$status || $status==1){echo "<span class='red'>待人事提交</span>";}elseif($status==2){echo "<span class='yellow'>待财务审核</span>";}elseif($status==3){echo "<span class='yellow'>待总经理批准</span>";}elseif($status==4){echo "<span class='green'>已批准</span>";}?> &emsp;
                        </h3>
                    </div><!-- /.box-header --><br>
                    <div class="box-body" style="height:40em;width:100%;float:left;overflow:auto;">
                        <div class="btn-group" id="catfont" >
                            <a href="{:U('Salary/salary_excel_list',array('archives'=>0,'datetime'=>$datetime))}" class="btn <?php if(!$archives){ echo 'btn-info';}else{ echo 'btn-default';} ?>">所有</a>
                            <a href="{:U('Salary/salary_excel_list',array('archives'=>1,'datetime'=>$datetime))}" class="btn <?php if($archives==1){ echo 'btn-info';}else{ echo 'btn-default';} ?>">中心</a>
                            <a href="{:U('Salary/salary_excel_list',array('archives'=>2,'datetime'=>$datetime))}" class="btn <?php if($archives==2){ echo 'btn-info';}else{ echo 'btn-default';} ?>">科旅</a>
                            <a href="{:U('Salary/salary_excel_list',array('archives'=>3,'datetime'=>$datetime))}" class="btn <?php if($archives==3){ echo 'btn-info';}else{ echo 'btn-default';} ?>">科行</a>
                            <a href="{:U('Salary/salary_excel_list',array('archives'=>4,'datetime'=>$datetime))}" class="btn <?php if($archives==4){ echo 'btn-info';}else{ echo 'btn-default';} ?>">行管局</a>
                        </div>

                        <script type="text/javascript">
                            /*$('.individual_tax').click(function(){
                                var id = $(this).attr('id');//用户id
                                alert(id);
                                alert('aaaa');
                                return false;
                                if($('.individual_tax_update'+id).length <= 0) {
                                    var money = $(this).text();
                                    $(this).empty();
                                    var h  = '<input type="text" class="form-control individual_tax_update'+id+'" value="'+money+'" />';
                                    $(this).append(h);
                                    $('.individual_tax_update'+id).focus();

                                    //个税鼠标移动事件
                                    $('.individual_tax_update'+id).mouseleave(function(){
                                        var content = $(this).val();//个人计税金额
                                        content = content.replace('¥ ','');//将¥ 字符替换为空字符
                                        var curl = "index.php?m=Main&c=Ajax&a=get_salary_content";
                                        $.ajax({
                                            type: "POST",
                                            url: curl,
                                            data: {'individual_tax':content, 'uid':id,'datetime':datetime},
                                            dataType: "json", //数据格式
                                            success: function (data) {
                                                if (data.sum == 1) {alert("恭喜您保存成功！");return false;}
                                                if (data.sum == 0) {alert("保存失败！请您重新保存！");return false;}
                                            }
                                        });
                                    });
                                }
                            });*/

                            /*function aaa(account_id) {
                                alert(account_id);
                                return false;
                            }*/
                        </script>

                        <br><br>
                        <div class="btn-group" style="height:100%;width:195em;" id="salary_archives_list">
                            <table class="table table-bordered dataTablev">
                                <!--       表头    -->
                                <THEAD style="display:table-header-group;font-weight:bold;>
                                <tr role="row" class="orders">
                                    <th class="sorting" style="width:5em;background-color:#66CCFF;">ID</th>
                                    <th class="sorting" style="width:10em;background-color:#66CCFF;">员工姓名</th>
                                    <th class="sorting" style="width:12em;background-color:#66CCFF;">岗位名称</th>
                                    <th class="sorting" style="width:10em;background-color:#66CCFF;">所属部门</th>
                                    <th class="sorting" style="width:10em;background-color:#66CCFF;">岗位薪酬标准</th>
                                    <th class="sorting" style="width:12em;background-color:#66CCFF;">其中基本工资标准</th>
                                    <th class="sorting" style="width:10em;background-color:#66CCFF;">考勤扣款</th>
                                    <th class="sorting" style="width:12em;background-color:#66CCFF;">其中绩效工资标准</th>
                                    <th class="sorting" style="width:10em;background-color:#66CCFF;">绩效增减</th>
                                    <th class="sorting" style="width:10em;background-color:#66CCFF;">带团补助</th>
                                    <th class="sorting" style="width:10em;background-color:#66CCFF;">业绩提成</th>
                                    <th class="sorting" style="width:10em;background-color:#66CCFF;">奖金</th>
                                    <th class="sorting" style="width:10em;background-color:#66CCFF;">住房补贴</th>
                                    <th class="sorting" style="width:10em;background-color:#66CCFF;">其他补款</th>
                                    <th class="sorting" style="width:10em;background-color:#66CCFF;">应发工资</th>
                                    <th class="sorting" style="width:10em;background-color:#66CCFF;">医疗保险</th>
                                    <th class="sorting" style="width:10em;background-color:#66CCFF;">养老保险</th>
                                    <th class="sorting" style="width:10em;background-color:#66CCFF;">失业保险</th>
                                    <th class="sorting" style="width:10em;background-color:#66CCFF;">公积金</th>
                                    <th class="sorting" style="width:10em;background-color:#66CCFF;">个人保险合计</th>
                                    <th class="sorting" style="width:10em;background-color:#66CCFF;">专项扣除</th>
                                    <th class="sorting" style="width:10em;background-color:#66CCFF;">计税工资</th>
                                    <th class="sorting" style="width:10em;background-color:#66CCFF;">个人所得税</th>
                                    <th class="sorting" style="width:10em;background-color:#66CCFF;">税后扣款</th>
                                    <th class="sorting" style="width:10em;background-color:#66CCFF;">工会会费</th>
                                    <th class="sorting" style="width:10em;background-color:#66CCFF;">实发工资</th>
                                </tr>
                                </THEAD>
                                <TBODY style="text-align:center">
                                <foreach name="personWagesLists" item="info">
                                    <tr class="excel_list_money1">
                                        <td>{$info['account_id']}</td>
                                        <td style="color:#3399FF;">{$info['user_name']}</td>
                                        <td>{$info['post_name']}</td>
                                        <td>{$info['department']}</td>
                                        <td>&yen; {$info['standard']}</td>
                                        <td>&yen; {$info['basic_salary']}</td>
                                        <td>&yen; {$info['withdrawing']}</td>
                                        <td>&yen; {$info['performance_salary']}</td>
                                        <td>&yen; {$info['Achievements_withdrawing']}</td>
                                        <td>&yen; {$info['Subsidy']}</td>
                                        <td>&yen; {$info['total']}</td>
                                        <td>&yen; <?php echo $info['bonus'] + $info['welfare']?$info['bonus'] + $info['welfare']:'0.00'; ?></td><!--奖金+年终奖-->
                                        <td>&yen; {$info['housing_subsidy']}</td>
                                        <td>&yen; {$info['Other']}</td>
                                        <td>&yen; {$info['Should_distributed']}</td>
                                        <td>&yen; {$info['medical_care']}</td>
                                        <td>&yen; {$info['pension_ratio']}</td>
                                        <td>&yen; {$info['unemployment']}</td>
                                        <td>&yen; {$info['accumulation_fund']}</td>
                                        <td>&yen; {$info['insurance_Total']}</td>
                                        <td>&yen; {$info['specialdeduction']}</td>
                                        <td>&yen; {$info['tax_counting']}</td>
                                        <td class="individual_tax" id="{$info['account_id']}">&yen; {$info['personal_tax']}</td>
                                        <td>&yen; {$info['summoney']}</td>
                                        <td>&yen; {$info['Labour']}</td>
                                        <td>&yen; {$info['real_wages']}</td>
                                    </tr>
                                </foreach>

                                <foreach name="departmentWagesLists" item="list">
                                    <tr class="excel_list_money2">
                                        <td colspan="3">{$list['name']}</td>
                                        <td>{$list['department']}</td>
                                        <td>&yen; {$list['standard']}</td>
                                        <td>&yen; {$list['basic_salary']}</td>
                                        <td>&yen; {$list['withdrawing']}</td>
                                        <td>&yen; {$list['performance_salary']}</td>
                                        <td>&yen; {$list['Achievements_withdrawing']}</td>
                                        <td>&yen; {$list['Subsidy']}</td>
                                        <td>&yen; {$list['total']}</td>
                                        <td>&yen; <?php echo $list['bonus'] + $list['welfare']?$list['bonus'] + $list['welfare']:'0.00'; ?></td><!--奖金+年终奖-->
                                        <td>&yen; {$list['housing_subsidy']}</td>
                                        <td>&yen; {$list['Other']}</td>
                                        <td>&yen; {$list['Should_distributed']}</td>
                                        <td>&yen; {$list['medical_care']}</td>
                                        <td>&yen; {$list['pension_ratio']}</td>
                                        <td>&yen; {$list['unemployment']}</td>
                                        <td>&yen; {$list['accumulation_fund']}</td>
                                        <td>&yen; {$list['insurance_Total']}</td>
                                        <td>&yen; {$list['specialdeduction']}</td>
                                        <td>&yen; {$list['tax_counting']}</td>
                                        <td>&yen; {$list['personal_tax']}</td>
                                        <td>&yen; {$list['summoney']}</td>
                                        <td>&yen; {$list['Labour']}</td>
                                        <td>&yen; {$list['real_wages']}</td>
                                    </tr>
                                </foreach>
                                <tr class="excel_list_money3">
                                    <td colspan="4">{$companyWagesLists['name']}</td>
                                    <td>&yen; {$companyWagesLists['standard']}</td>
                                    <td>&yen; {$companyWagesLists['basic_salary']}</td>
                                    <td>&yen; {$companyWagesLists['withdrawing']}</td>
                                    <td>&yen; {$companyWagesLists['performance_salary']}</td>
                                    <td>&yen; {$companyWagesLists['Achievements_withdrawing']}</td>
                                    <td>&yen; {$companyWagesLists['Subsidy']}</td>
                                    <td>&yen; {$companyWagesLists['total']}</td>
                                    <td>&yen; <?php echo $companyWagesLists['bonus'] + $companyWagesLists['welfare']?$companyWagesLists['bonus'] + $companyWagesLists['welfare']:'0.00'; ?></td><!--奖金+年终奖-->
                                    <td>&yen; {$companyWagesLists['housing_subsidy']}</td>
                                    <td>&yen; {$companyWagesLists['Other']}</td>
                                    <td>&yen; {$companyWagesLists['Should_distributed']}</td>
                                    <td>&yen; {$companyWagesLists['medical_care']}</td>
                                    <td>&yen; {$companyWagesLists['pension_ratio']}</td>
                                    <td>&yen; {$companyWagesLists['unemployment']}</td>
                                    <td>&yen; {$companyWagesLists['accumulation_fund']}</td>
                                    <td>&yen; {$companyWagesLists['insurance_Total']}</td>
                                    <td>&yen; {$companyWagesLists['specialdeduction']}</td>
                                    <td>&yen; {$companyWagesLists['tax_counting']}</td>
                                    <td>&yen; {$companyWagesLists['personal_tax']}</td>
                                    <td>&yen; {$companyWagesLists['summoney']}</td>
                                    <td>&yen; {$companyWagesLists['Labour']}</td>
                                    <td>&yen; {$companyWagesLists['real_wages']}</td>
                                </tr>
                                <th class="list_salary_datetime" style="display: none">{$count['datetime']}</th>
                                <th class="list_salary_detail3" style="display: none">{$count['id']}</th>
                                </TBODY>

                                <TFOOT style="display:table-footer-group;font-weight:bold;">
                                    <tr>
                                        <th colspan="6" style="text-align: center;">
                                            <b>提交人 : </b><?php if ($sign_url['url1']){echo "<img src='{$sign_url['url1']}' alt='' style='max-height: 50px'>";}else{echo "暂未提交";} ?>
                                        </th>
                                        <th colspan="6" style="text-align: center;">
                                            <b>审核人 : </b><?php if ($sign_url['url2']){echo "<img src='{$sign_url['url2']}' alt='' style='max-height: 50px'>";}else{echo "暂未审核";} ?>
                                        </th>
                                        <th colspan="6" style="text-align: center;">
                                            <b>批准人 : </b><?php if ($sign_url['url3']){echo "<img src='{$sign_url['url3']}' alt='' style='max-height: 50px'>";}else{echo "暂未批准";} ?>
                                        </th>
                                        <th colspan="8" style="text-align: center;">
                                            <b>打印时间: </b><?php echo date("Y-m-d H:i:s",time()); ?>
                                        </th>
                                    </tr>
                                </TFOOT>
                            </table>
                        </div>
                    </div><!-- /.box-body -->

                    <div style="margin-top:2em;text-align:center;" id="shr_qianzi"><br><br><br><br>
                        <?php if($status==1 && session('userid')== 77){?>
                            <a  class="btn btn-info salary_excel1_submit" style="width:10em;margin-top:2em;" onclick="show_qianzi(0)">提交审核</a>
                        <?php }?>
                        <?php if($status==2 && session('userid') == 55){?>
                            <a  class="btn btn-info salary_excel1_submit1" style="width:10em;margin-top:2em;" onclick="show_qianzi(1)">提交批准</a>
                            <a  class="btn btn-info salary_excel1_submit2" style="width:10em;margin-top:2em;" onclick="show_qianzi(2)">驳回</a>
                        <?php }?>
                        <?php if($status==3 && session('userid') == 11){?>
                            <a  class="btn btn-info salary_excel1_submit3" style="width:10em;margin-top:2em;" onclick="show_qianzi(3)">批准</a>
                            <a  class="btn btn-info salary_excel1_submit2" style="width:10em;margin-top:2em;" onclick="show_qianzi(2)">驳回</a>
                        <?php }?>
                    </div><br><br>
                </div><!-- /.box -->

            </div><!-- /.col -->
        </div>

    </section><!-- /.content -->
</aside><!-- /.right-side -->

<div id="searchtext">

    <form action="{:U('Salary/salary_excel_list')}" method="post" id="searchform">
        <input type="hidden" name="datetime" value="{$datetime}">
        <div class="form-group col-md-12">
            <input type="text" class="form-control" name="datetime" placeholder="年月">
        </div>
        <div class="form-group col-md-12">
            <input type="text" class="form-control" name="name" placeholder="姓名">
        </div>
    </form>
</div>

<include file="Index:footer2" />
<script>
    var datetime        = {$datetime};
    function show_qianzi(obj) {
        var html = '';
            html += '<label style="margin-top:2em;font-size:1.2em;">签字：</label>'+
            '<input type="password" name="password" class="" style="margin-top:2em;height:2.3em;" placeholder="请输入签字密码" />&emsp;'+
            '<input type="button" value="确定" onclick="check_pwd('+obj+')" style="margin-top:2em;font-size:1.2em;background-color:#00acd6;">';
        $('#shr_qianzi').html(html);
    }
    function check_pwd(obj) {
        var curl        = "index.php?m=Main&c=Ajax&a=Ajax_salary_sign";
        var pwd         = $('input[name="password"]').val();
        var status      = obj;
        $.ajax({
            type: "POST",
            url: curl,
            data: {
                'pwd'       :pwd,
                'status'    :status,
                'datetime'  :datetime,
            },
            dataType: "json", //数据格式
            success: function (data) {
                if (data == 1) {
                    if(obj == 0){
                        salary_excel1_submit();
                    }else if(obj == 1){
                        salary_excel1_submit1();
                    }else if(obj == 2){
                        salary_excel1_submit2();
                    }else if(obj == 3){
                        salary_excel1_submit3();
                    }
                }else{
                    alert("签字密码或数据错误！请重新提交输入！");
                    return false;
                }
            }
        });
    }

    //个税点击变输入框
    $('.individual_tax').click(function(){
        var id = $(this).attr('id');//用户id
        if($('.individual_tax_update'+id).length <= 0) {
            var money = $(this).text();
            console.log(money);
            alert(money);
            $(this).empty();
            var h  = '<input type="text" class="form-control individual_tax_update'+id+'" value="'+money+'" />';
            $(this).append(h);
            $('.individual_tax_update'+id).focus();

            //个税鼠标移动事件
            $('.individual_tax_update'+id).mouseleave(function(){
                var content = $(this).val();//个人计税金额
                content = content.replace('¥ ','');//将¥ 字符替换为空字符
                var curl = "index.php?m=Main&c=Ajax&a=get_salary_content";
                $.ajax({
                    type: "POST",
                    url: curl,
                    data: {'individual_tax':content, 'uid':id,'datetime':datetime},
                    dataType: "json", //数据格式
                    success: function (data) {
                        if (data.sum == 1) {alert("恭喜您保存成功！");return false;}
                        if (data.sum == 0) {alert("保存失败！请您重新保存！");return false;}
                    }
                });
            });
        }
    });

    /*************************************start*******************************************************/
    //人事提交审核数据
    function salary_excel1_submit(){
        var personWagesLists            = `<?php echo json_encode($personWagesLists); ?>`;
        var departmentWagesLists        = `<?php echo json_encode($departmentWagesLists); ?>`;
        var companyWagesLists           = `<?php echo json_encode($companyWagesLists); ?>`;
        var url                         = "index.php?m=Main&c=Ajax&a=Ajax_salary_details_add";

        $.ajax({
            type: "POST",
            url: url, //url
            data: {
                'personLists'           :personWagesLists,
                'departmentLists'       :departmentWagesLists,
                'companyLists'          :companyWagesLists,
                'datetime'              :datetime,
            },
            dataType: "json", //数据格式
            success: function (data) {
                if (data.num == 1) {
                    alert(data.msg);
                    window.location.reload();
                    return false;
                }
                if (data.sum == 0) {
                    art_show_msg(data.msg,5);
                    return false;
                }
            }
        });
    }

    //财务审核通过
    function salary_excel1_submit1(){
        $.ajax({
            type: "POST",
            url:  "index.php?m=Main&c=Ajax&a=Ajax_salary_details_upgrade",
            data: {
                'datetime' : datetime,
                'status':3
            },
            dataType: "json", //数据格式
            success: function (data) {
                alert(data.msg);
                if (data.num == 1) {
                    window.location.reload();
                }
                return false;
            }
        });
    }

    //总经理批准
    function salary_excel1_submit3(){
        $.ajax({
            type: "POST",
            url:  "index.php?m=Main&c=Ajax&a=Ajax_salary_details_upgrade",
            data: {
                'datetime':datetime,
                'status':4
            },
            dataType: "json", //数据格式
            success: function (data) {
                alert(data.msg);
                if (data.num == 1) {
                    window.location.reload();
                }
                return false;
            }
        });
    }
    //驳回
    function salary_excel1_submit2(){
        $.ajax({
            type: "POST",
            url:  "index.php?m=Main&c=Ajax&a=post_error",
            data: {
                'datetime' : datetime,
                'status':1,
            },
            dataType: "json", //数据格式
            success: function (data) {
                alert(data.msg);
                if (data.num == 1) {
                    window.location.reload();
                }
                return false;
            }
        });
    }
    /***************************************end*******************************************************/

    /*//    提交审核数据
    function salary_excel1_submit(){
        var count           = new Array();
        var content         = new Array();
        var totals_num      = new Array();
        var url             = "index.php?m=Main&c=Ajax&a=Ajax_salary_details_add";
        $('.excel_list_money1').each(function(){
            $(this).children('td').each(function(){
                var cont    = $(this).text();
                count       += cont + ',';
            });
        });
        $('.excel_list_money2').each(function(){
            $(this).children('td').each(function(){
                var sum    = $(this).text();
                content    += sum + ',';
            });
        });
        $('.excel_list_money3').each(function(){
            $(this).children('td').each(function(){
                var num    = $(this).text();
                totals_num += num + ',';
            });
        });

        $.ajax({
            type: "POST",
            url: url, //url
            data: {
                'content'       :count,
                'datetime'      :"<?php echo $time;?>",
                'coutdepartment':content,
                'totals_num'    :totals_num,
            },
            dataType: "json", //数据格式
            success: function (data) {
                if (data.sum == 1) {
                    alert('提交审核成功！');
                    window.location.reload();
                    return false;
                }
                if (data.sum == 0) {
                    alert('提交审核失败！');
                    return false;
                }
            }
        });
    }

    //提交批准
    function salary_excel1_submit1(){
        var wages_month_id ="";
        var departmen_id ="";
        $('.list_salary_detail1').each(function(){
            var text = $(this).text();
            wages_month_id +=text+',';
        });
        $('.list_salary_detail2').each(function(){
            var txt = $(this).text();
            departmen_id +=txt+',';
        });
        var count_money_id = $('.list_salary_detail3').text();
        $.ajax({
            type: "POST",
            url:  "index.php?m=Main&c=Ajax&a=Ajax_salary_details_upgrade",
            data: {
                'wages_month_id' : wages_month_id,
                'departmen_id' : departmen_id,
                'count_money_id' : count_money_id,
                'status':3,
            },
            dataType: "json", //数据格式
            success: function (data) {
                if (data.sum == 1) {
                    alert('提交批准成功!');
                    window.location.reload();
                    return false;
                }
                if (data.sum == 0) {
                    alert('提交批准失败!');
                    return false;
                }
            }
        });
    }

    //批准
    function salary_excel1_submit3(){
        var wages_month_id ="";
        var departmen_id ="";
        $('.list_salary_detail1').each(function(){
            var text = $(this).text();
            wages_month_id +=text+',';
        });
        $('.list_salary_detail2').each(function(){
            var txt = $(this).text();
            departmen_id +=txt+',';
        });
        var count_money_id = $('.list_salary_detail3').text();
        $.ajax({
            type: "POST",
            url:  "index.php?m=Main&c=Ajax&a=Ajax_salary_details_upgrade",
            data: {
                'wages_month_id' : wages_month_id,
                'departmen_id' : departmen_id,
                'count_money_id' : count_money_id,
                'status':4,
            },
            dataType: "json", //数据格式
            success: function (data) {
                if (data.sum == 1) {
                    alert('批准成功!');
                    window.location.reload();
                    return false;
                }
                if (data.sum == 0) {
                    alert('批准失败!');
                    return false;
                }
            }
        });
    }
    //驳回
    function salary_excel1_submit2(){
        $.ajax({
            type: "POST",
            url:  "index.php?m=Main&c=Ajax&a=post_error",
            data: {
                'datetime' : datetime,
                'status':1,
            },
            dataType: "json", //数据格式
            success: function (data) {
                if (data.sum == 1) {
                    alert('驳回成功!');
                    window.location.reload();
                    return false;
                }
                if (data.sum == 0) {
                    alert('驳回失败!');
                    return false;
                }
            }
        });
    }*/


    //表格单双变色
    function excel_list_color(){
        $('.excel_list_money3').css("background","#66CCFF");
        $(".excel_list_money2:odd").css("background","#F8F8F8");
        $(".excel_list_money2:even").css("background","#FFFFFF");
        $(".excel_list_money1:odd").css("background","#F8F8F8");
        $(".excel_list_money1:even").css("background","#FFFFFF");

    }

    //横向内容点击变色
    var  cum = 0;
    var  cun = 0;
    $('tr').click(function(){
        cum++;
        var m = $("table tr").index(this);
        excel_list_color();
        if(cum%2==1 || cun!==m){
            if(cum%2==1 && cun==m){
                $(this).css("background","#CC0033");
            }else{
                $(this).css("background","#CC0033");
            }
            cun = m;
        }else{
            if(cun!==m){
                $(this).css("background","#CC0033");
            }
        }
    });

    //纵向内容点击变色
    var cont    = 0;
    var num     = 0;
    $('table tr th').click(function(){
        cont++;
        var index = $("table tr th").index(this);
        if(cont%2==1 || num!==index){
            $("tr").each(function(){
                var clas =  $(this).prop('class');
                if(clas == 'excel_list_money2'){
                    if(index>0){
                        if(index ==1 || index == 2){
                            num =null;
                        }else{
                            num = index-2;
                        }
                    }
                }else{
                    if(clas == 'excel_list_money3'){
                        if(index>0){
                            if(index==1 || index==2 || index==3){
                                num=null;
                            }else{
                                num = index-3;
                            }
                        }
                    }else{
                        num = index;
                    }
                }
                $(this).children('td').css('background','none');
                $(this).children('td:eq('+num+')').css('background',"rgba(0,0,255,0.3)");
                if(cont%2==0 && mun==index){alert();
                    $("tr").each(function(){
                        $(this).children('td').css('background','none');
                    });
                }
            });
        }else{
            $("tr").each(function(){
                $(this).children('td').css('background','none');
            });
        }
    });

    function salary2() { //打印
        $('td').css('border','1px solid #000000');
        $('th').css('border','1px solid #000000');
        var add = "工资表";
            add += "<?php if($type==1){echo ' (中心)'; }elseif($type==2){echo ' (科旅)';}elseif($type==3){echo ' (科行)';}elseif($type==4){echo ' (行管局)';} ?>";
        var dat = "<?php echo $date;?>";
            $("title").html(dat+add);
        var id  = $('#salary_archives_list').attr('id');//当前要打印的id
        ('tr')
        // $('tr').css('border','1px solid #000000');

        print_view(id);
    }


    excel_list_color();
</script>
