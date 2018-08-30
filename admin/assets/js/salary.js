$(function(){

    <!--默认打开调用页面  岗位薪酬变动-->
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
    var num = $('#salary_id_hidden').val();
    var cont = $('#salary_id_hidden1').val();
    if (num < 6){
        salary_entry(num);
    }
    if (5<cont<8) {
        salary_hide(cont);
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


//岗位薪酬变动
function salary_entry(obj){
    if(obj==1){
        $('#salary_entry').show().attr("lang");//入职
        $('#salary_formal').hide();//转正
        $('#salary_adjustment').hide();//调岗
        $('#salary_quit').hide();//离职
        $('#salary_change').hide();//调薪
    }
    if(obj==2){
        $('#salary_entry').hide();//入职
        $('#salary_formal').show().attr("lang");//转正
        $('#salary_adjustment').hide();//调岗
        $('#salary_quit').hide();//离职
        $('#salary_change').hide();//调薪
    }
    if(obj==3){
        $('#salary_entry').hide();//入职
        $('#salary_formal').hide();//转正
        $('#salary_adjustment').show().attr("lang");//调岗
        $('#salary_quit').hide();//离职
        $('#salary_change').hide();//调薪
    }
    if(obj==4){
        $('#salary_entry').hide();//入职
        $('#salary_formal').hide();//转正
        $('#salary_adjustment').hide();//调岗
        $('#salary_quit').show().attr("lang");//离职
        $('#salary_change').hide();//调薪
    }
    if(obj==5){
        $('#salary_entry').hide();//入职
        $('#salary_formal').hide();//转正
        $('#salary_adjustment').hide();//调岗
        $('#salary_quit').hide();//离职
        $('#salary_change').show().attr("lang");//调薪
    }
    $('#salary_hidden_show1').closest("div").remove();
    var html  = '<div class="form-group col-md-3">';
        html += '<input type="hidden" name="typeval" value="'+obj+'" id="salary_hidden_show1">';
        html += '</div>';
    $(' #searchform').append(html);

}

//岗位薪酬变动 保存信息
$('.salary_butt1').click(function(){
    var url ="index.php?m=Main&c=Ajax&a=salary_add";
    var type = $(this).parents('td').find('.salary_type').val();
    var salary_aid = $(this).parents('tr').children('.salary_aid').text();//用户id
    var probation = $(this).parents('tr').find('input').val();//标准薪资
    var achievements = $(this).parents('tr').find('.salary_basic1').val();//基本薪资比
    var basic = $(this).parents('tr').find('.salary_basic2').val();//绩效薪资比
//        alert(type);alert(count);die;
    $.ajax({
        type: "post",
        url: url, //url
        data: {'account_id':salary_aid,'standard_salary':probation,'basic_salary':achievements,'performance_salary':basic,'type':type},
        dataType: "json", //数据格式
        success: function (data) {
            if(data.sum==1){
                alert(data.msg);die;

            }
            if(data.sum==0){
                alert(data.msg);die;
            }
        }
    });
});

//岗位薪酬变动 保存信息
$('.salary_adjustment_butt4').click(function(){

    var type = $(this).parents('tr').find('.salary_status').val();//判断状态
    var aid = $(this).parents('tr').find('.salary_sid').val();//用户id
    var url ="index.php?m=Main&c=Ajax&a=salary_add";
    if(type==3){
        var department = $(this).parents('tr').find('.salary_current_department').val();//部门
        var posts = $(this).parents('tr').find('.salary_present_post').val();//岗位
        var salary = $(this).parents('tr').find('.salary_present_salary').val();//岗位薪酬
        var basic1 = $(this).parents('tr').find('.salary_basic1').val();//岗位基本薪酬
        var basic2 = $(this).parents('tr').find('.salary_basic2').val();//岗位绩效薪酬
        $.ajax({
            type: "post",
            url: url, //url
            data: {'account_id':aid,'department':department,'posts':posts,'standard_salary':salary,'basic_salary':basic1,'performance_salary':basic2,'type':type},
            dataType: "json", //数据格式
            success: function (data) {
                if(data.sum==1){
                    alert(data.msg);die;
                }
                if(data.sum==0){
                    alert(data.msg);die;
                }
            }
        });
    }
    if(type==4){
        var data  = $(this).parents('tr').find('.salary_monthly').val();//时间
        $.ajax({
            type: "post",
            url: url, //url
            data: {'account_id':aid,'type':type,'data':data},
            dataType: "json", //数据格式
            success: function (data) {
                if(data.sum==1){
                    alert(data.msg);die;
                }
                if(data.sum==0){
                    alert(data.msg);die;
                }
            }
        });
    }
});

/**
 * 提成/补助/奖金 显示 隐藏
 */
function salary_hide(number){
    if(number==1){
        $('#table_salary_percentage1').show();
        $('#table_salary_percentage2').hide();
        $('#table_salary_percentag1').show();
        $('#table_salary_percentag2').hide();
    }
    if(number==2){
        $('#table_salary_percentage1').hide();
        $('#table_salary_percentage2').show();
        $('#table_salary_percentag2').show();
        $('#table_salary_percentag1').hide();
    }
    $('#salary_hidden_show2').closest("div").remove();
    var ty = number+5;
    var html  = '<div class="form-group col-md-3">';
        html += '<input type="hidden" name="typeval" value="'+ty+'" id="salary_hidden_show2">';
        html += '</div>';
    $('#searchform1').append(html);
}

/**
 * 录入提成/补助/奖金 保存
 */
$('.salary_bonus_butt1').click(function (){
    var url = "index.php?m=Main&c=Ajax&a=Ajax_Bonus_Query";
    var account_id  = $(this).parents('tr').find('.salary_table_extract').text();//用户id
    var extract     = $(this).parents('tr').find('.salary_bonus_extract').val();//提成
    var bonus_bonus = $(this).parents('tr').find('.salary_bonus_bonus').val();//奖金
    var yearend     = $(this).parents('tr').find('.salary_bonus_yearend').val();//年终
    $.ajax({
        type: "post",
        url: url, //url
        data: {'account_id':account_id,'extract':extract,'bonus_bonus':bonus_bonus,'yearend':yearend},
        dataType: "json", //数据格式
        success: function (data) {
            if(data.sum==1){
                alert(data.msg);die;
            }
            if(data.sum==0){
                alert(data.msg);die;
            }
        }
    });

})

/**
 * 变动各项补助
 */

$('.salary_subsidy_butt1').click(function (){
    var url                 = "index.php?m=Main&c=Ajax&a=Ajax_subsidy_Query";
    var account_id          = $(this).parents('tr').find('.salary_table_extract1').text();//用户id
    var housing_subsidy     = $(this).parents('tr').find('.salary_subsidy_housingt').val();//住房补贴
    var foreign_subsidies   = $(this).parents('tr').find('.salary_subsidy_foreign').val();//外地补贴
    var computer_subsidy    = $(this).parents('tr').find('.salary_subsidy_computer').val();//电脑补贴
    $.ajax({
        type: "post",
        url: url, //url
        data: {'account_id':account_id,'housing_subsidy':housing_subsidy,'foreign_subsidies':foreign_subsidies,'computer_subsidy':computer_subsidy},
        dataType: "json", //数据格式
        success: function (data) {
            if(data.sum==1){
                alert(data.msg);die;
            }
            if(data.sum==0){
                alert(data.msg);die;
            }
        }
    });

})

