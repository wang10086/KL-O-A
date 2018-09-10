$(function(){

    <!--默认打开调用页面  列表显示div-->
    var url ="index.php?m=Main&c=Salary&a=salary_list";
    $.ajax({
        url:url,
        type:"GET",
        data:{'status':11},
        dataType:"html",
        success:function(result){
            $('#salary_history_page1').html(result);
        }
    });
    var num  = $('#salary_id_hidden').val();
    var cont = $('#salary_id_hidden1').val();
    var sum  = $('#salary_insurance').val();
    var number  = $('#salary_withholding_selected').val();
    if (num < 6 && num>0){//岗位
        salary_entry(num);
    }else{
        $('#salary_entry').show();
    }
    if (cont<3 && cont>0 ) {//提成
        salary_hide(cont);
    }else{
        $('#table_salary_percentage1').show();
    }
    if (sum<6 && sum>0) {//五险
        salary_insurance(sum);
    }else{
        $('#table_salary_insurance1').show();
    }
    if(number<3 && number>0 ){//代扣代缴
        salary_withholding(number);
    }else{
        $('#salary_withholding1').show();
    }


})
function salary_list(page){//ajax 分页效果(岗位薪酬变动)
    var url ="index.php?m=Main&c=Salary&a=salary_list";
    $.ajax({
        url:url,
        type:"GET",
        data:{'status':11,'page':page},
        dataType:"html",
        success:function(result){
            $('#salary_history_page1').html(result);
        }
    });
}


    //岗位薪酬变动 显示|隐藏
    function salary_entry(obj) {
        $('#salary_entry').hide();
        $('#salary_entry').siblings().hide();
        if (obj == 1) {
            $('#salary_entry').show();//入职
        }
        if (obj == 2) {
            $('#salary_formal').show();//转正
        }
        if (obj == 3) {
            $('#salary_adjustment').show()//调岗
        }
        if (obj == 4) {
            $('#salary_quit').show();//离职
        }
        if (obj == 5) {
            $('#salary_change').show();//调薪
        }
        $('#salary_hidden_show1').closest("div").remove();
        var html = '<div class="form-group col-md-3">';
        html += '<input type="hidden" name="typeval" value="' + obj + '" id="salary_hidden_show1">';
        html += '</div>';
        $(' #searchform').append(html);

        }

//岗位薪酬变动 保存信息
    $('.salary_butt1').click(function () {
        var url = "index.php?m=Main&c=Ajax&a=salary_add";
        var type = $(this).parents('td').find('.salary_type').val();
        var salary_aid = $(this).parents('tr').children('.salary_aid').text();//用户id
        var probation = $(this).parents('tr').find('input').val();//标准薪资
        var achievements = $(this).parents('tr').find('.salary_basic1').val();//基本薪资比
        var basic = $(this).parents('tr').find('.salary_basic2').val();//绩效薪资比
//        alert(type);alert(count);die;
        $.ajax({
            type: "post",
            url: url, //url
            data: {
                'account_id': salary_aid,
                'standard_salary': probation,
                'basic_salary': achievements,
                'performance_salary': basic,
                'type': type
            },
            dataType: "json", //数据格式
            success: function (data) {
                if (data.sum == 1) {
                    alert(data.msg);
                    return false;

                }
                if (data.sum == 0) {
                    alert(data.msg);
                    return false;
                }
            }
        });
    });

//岗位薪酬变动 保存信息
    $('.salary_adjustment_butt4').click(function () {

        var type = $(this).parents('tr').find('.salary_status').val();//判断状态
        var aid = $(this).parents('tr').find('.salary_sid').val();//用户id
        var url = "index.php?m=Main&c=Ajax&a=salary_add";
        if (type == 3) {
            var department = $(this).parents('tr').find('.salary_current_department').val();//部门
            var posts = $(this).parents('tr').find('.salary_present_post').val();//岗位
            var salary = $(this).parents('tr').find('.salary_present_salary').val();//岗位薪酬
            var basic1 = $(this).parents('tr').find('.salary_basic1').val();//岗位基本薪酬
            var basic2 = $(this).parents('tr').find('.salary_basic2').val();//岗位绩效薪酬
            $.ajax({
                type: "post",
                url: url, //url
                data: {
                    'account_id': aid,
                    'department': department,
                    'posts': posts,
                    'standard_salary': salary,
                    'basic_salary': basic1,
                    'performance_salary': basic2,
                    'type': type,
                },
                dataType: "json", //数据格式
                success: function (data) {
                    if (data.sum == 1) {
                        alert(data.msg);
                        return false;
                    }
                    if (data.sum == 0) {
                        alert(data.msg);
                        return false;
                    }
                }
            });
        }
        if (type == 4) {
            var data = $(this).parents('tr').find('.salary_monthly').val();//时间
            $.ajax({
                type: "post",
                url: url, //url
                data: {'account_id': aid, 'type': type, 'data': data},
                dataType: "json", //数据格式
                success: function (data) {
                    if (data.sum == 1) {
                        alert(data.msg);
                        return false;
                    }
                    if (data.sum == 0) {
                        alert(data.msg);
                        return false;
                    }
                }
            });
        }
    });

    /**
     * 提成/补助/奖金 显示 隐藏
     */
    function salary_hide(number) {
        if (number == 1) {
            $('#table_salary_percentage1').show();
            $('#table_salary_percentage2').hide();
            $('#table_salary_percentag1').show();
            $('#table_salary_percentag2').hide();
        }
        if (number == 2) {
            $('#table_salary_percentage1').hide();
            $('#table_salary_percentage2').show();
            $('#table_salary_percentag2').show();
            $('#table_salary_percentag1').hide();
        }
        $('#salary_hidden_show2').closest("div").remove();
        var ty = number + 5;

        var html = '<div class="form-group col-md-3">';
        html += '<input type="hidden" name="typeval" value="' + ty + '" id="salary_hidden_show2">';
        html += '</div>';
        $('#searchform1').append(html);
    }

    /**
     * 变动各项补助 | 提成/奖金/年终
     */

    $('.salary_subsidy_butt').click(function () {
        var url = "index.php?m=Main&c=Ajax&a=Ajax_subsidy_Query";
        var statu = $(this).parents('tr').find('.status').val();//状态 1 提成奖金 2 补贴
        var account_id = $(this).parents('tr').find('.salary_table_extract').text();//用户id
        var housing_subsidy = $(this).parents('tr').find('.salary_bonus_extract').val();//住房补贴  | 提成
        var foreign_subsidies = $(this).parents('tr').find('.salary_bonus_bonus').val();//外地补贴 | 奖金
        var computer_subsidy = $(this).parents('tr').find('.salary_bonus_yearend').val();//电脑补贴 | 年终
        $.ajax({
            type: "post",
            url: url, //url
            data: {
                'account_id': account_id,
                'housing_subsidy': housing_subsidy,
                'foreign_subsidies': foreign_subsidies,
                'computer_subsidy': computer_subsidy,
                'statu':statu,
            },
            dataType: "json", //数据格式
            success: function (data) {
                if (data.sum == 1) {
                    alert(data.msg);
                    return false;
                }
                if (data.sum == 0) {
                    alert(data.msg);
                    return false;
                }
            }
        });
    })

    function salary_insurance(obj) {// 添加搜索提交状态
        $('#table_salary_insurance1').hide();
        $('#table_salary_insurance1').siblings().hide();
        $('#table_salary_insurance' + obj).show();

        $('#salary_hidden_show3').closest("div").remove();
        var count = obj + 7;
        var html = '<div class="form-group col-md-3">';
            html += '<input type="hidden" name="typeval" value="' + count + '" id="salary_hidden_show3">';
            html += '</div>';
        $('#searchform2').append(html);
        return false;
    }

    $('.salary_insurance_butt').click(function(){//添加数据 五险一金
        var url         = "index.php?m=Main&c=Ajax&a=Ajax_Insurance_Query";
        var account_id  = $(this).parents('tr').find('.salary_table_insurance').text();//uid
        var injury      = $(this).parents('tr').find('.salary_insurance_injury').val();//生育/工伤/医疗 基数
        var pension     = $(this).parents('tr').find('.salary_insurance_pension').val();//养老/失业 基数
        var ratio       = $(this).parents('tr').find('.salary_insurance_ratio').val();//公积金 基数
        var stat        = $(this).parents('tr').find('.status').val();//状态
        var big_price       = $(this).parents('tr').find('.salary_insurance_price').val();//大额医疗
        $.ajax({
            type: "post",
            url: url, //url
            data: {
                'account_id': account_id,
                'injury_base': injury,
                'pension_base': pension,
                'accumulation_fund_base': ratio,
                'statu':stat,
                'big_price':big_price,
            },
            dataType: "json", //数据格式
            success: function (data) {
                if (data.sum == 1) {
                    alert(data.msg);
                    return false;
                }
                if (data.sum == 0) {
                    alert(data.msg);
                    return false;
                }
            }
        });
    })
function salary_withholding(obj) {//显示隐藏代扣代缴
    $('#salary_withholding1').hide();
    $('#salary_withholding1').siblings().hide();
    $('#salary_withholding'+obj).show();
    $('#salary_withholding_show').closest("div").remove();
    var count = obj+12;
    var html = '<div class="form-group col-md-3">';
        html += '<input type="hidden" name="typeval" value="' + count + '" id="salary_withholding_show">';
        html += '</div>';
    $('#salary_withholding_num').append(html);
    return false;
}

$('.withholding_click').click(function(){//添加新项目
   var aid = $(this).parents('.salary_add_table').find('.fom_id').text();
    if(isNaN(aid.substring(4))){//判断有无用户
        alert("请先添加用户!");return false;
    }
    var id = aid.substring(4);
    var htm =  '<tr class="add_withholding_list">';
        htm += '<td><input type="text" name="name" class="form-control withholding_project_name" /></td>';
        htm += '<td><input type="text" name="money" class="form-control withholding_money" /></td>';
        htm += '<input type="hidden"  class="form-control withholding_id" value="'+id+'" />';
        htm += '<td><input type="button" class="form-control withholding_delete" value="删除项目" style="background-color:#00acd6;font-size:1em;" /></td>';
        htm += '</tr>';
    $(this).parents('.salary_add_table').find('.table-bordered').append(htm);
    withholding_delete();
    return false;
});

$('.withholding_delete').click(function(){//删除无用的项目 前期自动添加项目
    $(this).parents('.add_withholding_list').remove();
});
function withholding_delete() {
    $('.withholding_delete').click(function(){//删除无用的项目 后期手动添加项目
        $(this).parents('.add_withholding_list').remove();
    });
}


$('.salary_withholding_butt').click(function(){
    var url = "index.php?m=Main&c=Ajax&a=Ajax_withholding_income";
    var arr = new Array();
    $(this).parents('.salary_add_table').find('.add_withholding_list').each(function(){
        var name = $(this).find('.withholding_project_name').val();//项目名称
        var money = $(this).find('.withholding_money').val();//金额
        var id = $(this).find('.withholding_id').val();//用户id
        arr += name+",";
        arr += money+",";
        arr += id+","+"|";
    });
    var status = $(this).parents('.salary_add_table').find('.withholding_status').val();//状态
    $.ajax({
        type: "POST",
        url: url, //url
        data: {
            'status': status,
            'arr': arr,
        },
        dataType: "json", //数据格式
        success: function (data) {
            if (data.sum == 1) {
                alert(data.msg);
                return false;
            }
            if (data.sum == 0) {
                alert(data.msg);
                return false;
            }
        }
    });
});