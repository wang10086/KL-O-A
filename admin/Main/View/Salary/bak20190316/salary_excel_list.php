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
                <div class="box" >
                    <div class="box-header" >
                        <h3 class="box-title">员工薪资列表</h3>
                        <a  class="btn btn-info" style="width:10em; margin: 0.5em 0em 0em 2em;"> <?php if($status=="" || $status==0 || $status==1){echo "待提交审核(人事)";}elseif($status==2){echo "待提交批准(财务)";}elseif($status==3){echo "待批准(总经理)";}elseif($status==4){echo "已批准";}?></a>
                        <a href="javascript:;" class="btn btn-info btn-sm" onclick="javascript:opensearch('searchtext',700,160);" style="margin: 0.7em 0em 0em 3em;" ><i class="fa fa-search"></i> 搜索</a>
                        <a  href="{:U('Salary/salary_exportExcel',array('datetime'=>$count['datetime'],'type'=>$type))}" class="btn btn-info btn-sm" style="margin:1em 0em 0em 3em;" />导出 Excel</a>
                        <a class="btn btn-default" onclick="salary2();" style="margin:0.8em 0em 0em 2em;color:#000000;background-color: lightgrey;"><i class="fa fa-print"></i> 打印</a>

                    </div><!-- /.box-header --><br>
                    <div class="box-body" style="height:40em;width:100%;float:left;overflow:auto;">
                        <div class="btn-group" id="catfont" >
<!--                            'month'=> $count['datetime']-->
                            <a href="{:U('Salary/salary_excel_list')}" class="btn <?php if($type=="" || $type==0){ echo 'btn-info';}else{ echo 'btn-default';} ?>">所有</a>
                            <a href="{:U('Salary/salary_excel_list',array('archives'=>1,'month'=>$count['datetime']))}" class="btn <?php if($type==1){ echo 'btn-info';}else{ echo 'btn-default';} ?>">中心</a>
                            <a href="{:U('Salary/salary_excel_list',array('archives'=>2,'month'=>$count['datetime']))}" class="btn <?php if($type==2){ echo 'btn-info';}else{ echo 'btn-default';} ?>">科旅</a>
                            <a href="{:U('Salary/salary_excel_list',array('archives'=>3,'month'=>$count['datetime']))}" class="btn <?php if($type==3){ echo 'btn-info';}else{ echo 'btn-default';} ?>">科行</a>
                            <a href="{:U('Salary/salary_excel_list',array('archives'=>4,'month'=>$count['datetime']))}" class="btn <?php if($type==4){ echo 'btn-info';}else{ echo 'btn-default';} ?>">行管局</a>
                        </div>

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
                                <foreach name="info" item="info">
                                    <tr class="excel_list_money1">
                                        <td>{$info['account']['id']}</td>
                                        <td style="color:#3399FF;">{$info['account']['nickname']}</td>
                                        <td>{$info['posts'][0]['post_name']}</td>
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
                                        <td>&yen; <?php echo sprintf('%.2f',$info['specialdeduction']); ?></td>
                                        <td>&yen; <?PHP echo sprintf("%.2f",$info['tax_counting']);?></td>
                                        <?php if($status==1 && ($userid== 77 || $userid== 11 || $userid== 1)){?>
                                            <td class="individual_tax" id="<?php echo$info['account']['id'];?> ">&yen; <?PHP echo sprintf("%.2f",$info['personal_tax']);?></td>
                                        <?php }else{?>
                                            <td>&yen; <?PHP echo sprintf("%.2f",$info['personal_tax']);?></td>
                                        <?php } ?>

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
                                        <td style="display:none">{$info['bonus'][0]['royalty']}</td>
                                        <td style="display:none">{$info['welfare']}</td>
                                        <td style="display:none">{$info['labour']['id']}</td>
                                        <td style="display:none">{$info['specialdeduction_id']}</td>

                                    </tr>
                                    <th class="list_salary_detail1" style="display: none">{$info['wages_mont_id']}</th>
                                </foreach>

                                <foreach name="sum" item="sum">
                                    <tr class="excel_list_money2">
                                        <td colspan="3" style="text-align: center;">{$sum['name']}</td>
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
                                        <td>&yen; <?PHP echo sprintf("%.3f",$sum['care']+$sum['big_price']);?></td>
                                        <td>&yen; <?PHP echo sprintf("%.3f",$sum['pension']);?></td>
                                        <td>&yen; <?PHP echo sprintf("%.3f",$sum['unemployment']);?></td>
                                        <td>&yen; <?PHP echo sprintf("%.2f",$sum['accumulation']);?></td>
                                        <td>&yen; <?PHP echo sprintf("%.3f",$sum['insurance_Total']);?></td>
                                        <td>&yen; <?php echo sprintf("%.2f",$sum['specialdeduction']); ?></td>
                                        <td>&yen; <?PHP echo sprintf("%.2f",$sum['tax_counting']);?></td>
                                        <td>&yen; <?PHP echo sprintf("%.2f",$sum['personal_tax']);?></td>
                                        <td>&yen; <?PHP echo sprintf("%.2f",$sum['summoney']);?></td>
                                        <td>&yen; <?PHP echo sprintf("%.2f",$sum['Labour']);?></td>
                                        <td>&yen; <?PHP echo sprintf("%.2f",$sum['real_wages']);?></td>
                                    </tr>
                                    <th class="list_salary_detail2" style="display: none">{$sum['id']}</th>
                                </foreach>
                                <tr class="excel_list_money3">
                                    <td colspan="4" style="text-align: center;">{$count['name']}</td>
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
                                    <td>&yen; <?PHP echo sprintf("%.3f",($count['care']+$count['big_price']));?></td>
                                    <td>&yen; <?PHP echo sprintf("%.3f",$count['pension']);?></td>
                                    <td>&yen; <?PHP echo sprintf("%.3f",$count['unemployment']);?></td>
                                    <td>&yen; <?PHP echo sprintf("%.2f",$count['accumulation']);?></td>
                                    <td>&yen; <?PHP echo sprintf("%.3f",$count['insurance_Total']);?></td>
                                    <td>&yen; <?php echo sprintf("%.2f",$count['specialdeduction']);?></td>
                                    <td>&yen; <?PHP echo sprintf("%.2f",$count['tax_counting']);?></td>
                                    <td>&yen; <?PHP echo sprintf("%.2f",$count['personal_tax']);?></td>
                                    <td>&yen; <?PHP echo sprintf("%.2f",$count['summoney']);?></td>
                                    <td>&yen; <?PHP echo sprintf("%.2f",$count['Labour']);?></td>
                                    <td>&yen; <?PHP echo sprintf("%.2f",$count['real_wages']);?></td>
                                </tr>
                                <th class="list_salary_datetime" style="display: none">{$count['datetime']}</th>
                                <th class="list_salary_detail3" style="display: none">{$count['id']}</th>
                                </TBODY>

                                <TFOOT style="display:table-footer-group;font-weight:bold;">
                                    <tr>
                                        <th colspan="6" style="text-align: center;">
                                            <b>提交人 : </b><?php if ($url1!==''){echo "<img src='{$url1}' alt='' style='max-height: 50px'>";}else{echo "暂未提交";} ?>
                                        </th>
                                        <th colspan="6" style="text-align: center;">
                                            <b>审核人 : </b><?php if ($url2!==''){echo "<img src='{$url2}' alt='' style='max-height: 50px'>";}else{echo "暂未审核";} ?>
                                        </th>
                                        <th colspan="6" style="text-align: center;">
                                            <b>批准人 : </b><?php if ($url3!==''){echo "<img src='{$url3}' alt='' style='max-height: 50px'>";}else{echo "暂未批准";} ?>
                                        </th>
                                        <th colspan="7" style="text-align: center;">
                                            <b>打印时间: </b><?php echo date("Y-m-d H:i:s",time()); ?>
                                        </th>
                                    </tr>
                                </TFOOT>
                            </table>
                        </div>
                    </div><!-- /.box-body -->

                    <div style="margin-top:2em;text-align:center;" id="shr_qianzi"><br><br><br><br>
                        <?php if($status==1 && $userid== 77){?>
                            <a  class="btn btn-info salary_excel1_submit" style="width:10em;margin-top:2em;" onclick="show_qianzi(0)">提交审核</a>
                        <?php }?>
                        <?php if($status==2 && $userid == 55){?>
                            <a  class="btn btn-info salary_excel1_submit1" style="width:10em;margin-top:2em;" onclick="show_qianzi(1)">提交批准</a>
                            <a  class="btn btn-info salary_excel1_submit2" style="width:10em;margin-top:2em;" onclick="show_qianzi(2)">驳回</a>
                        <?php }?>
                        <?php if($status==3 && $userid == 11){?>
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

        <div class="form-group col-md-5" style="margin:1em 0em 0em 10em;">
            <input type="text" name="month" class="form-control monthly" placeholder="搜索工资表年月格式 : 201806" style="text-align: center;"/>
            <br>
            <input type="text" name="name" class="form-control" placeholder="搜索员工姓名" style="text-align: center;"/>
            <!--                    <input type="date" class="form-control" name="salary_time" placeholder="年月" id="nowTime">-->
        </div>

    </form>
</div>

<include file="Index:footer2" />
<script>

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
        var datetime    = <?php echo $count['datetime'];?>;
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
                if (data.sum == 1) {
                    if(obj == 0){
                        salary_excel1_submit();
                    }else if(obj == 1){
                        salary_excel1_submit1();
                    }else if(obj == 2){
                        salary_excel1_submit2();
                    }else if(obj == 3){
                        salary_excel1_submit3();
                    }
                }
                if (data.sum == 0) {
                    alert("签字密码或用户错误！请重新提交输入！");
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
            $(this).empty();
            var h  = '<input type="text" class="form-control individual_tax_update'+id+'" value="'+money+'" />';
            $(this).append(h);
            $('.individual_tax_update'+id).focus();

            //个税鼠标移动事件
            $('.individual_tax_update'+id).mouseleave(function(){
                var content = $(this).val();//个人计税金额
                content = content.replace('¥ ','');//将¥ 字符替换为空字符
                var curl = "index.php?m=Main&c=Ajax&a=get_salary_content";
                var datetime = <?php echo $count['datetime'];?>;
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


    //    提交审核数据
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
       var datetime = <?php echo $count['datetime'];?>;
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
    }
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
