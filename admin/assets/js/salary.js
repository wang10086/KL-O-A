function salary_entry(obj){
    if(obj==1){
        $('#salary_entry').show();//入职
        $('#salary_formal').hide();//转正
        $('#salary_adjustment').hide();//调岗
        $('#salary_quit').hide();//离职
        $('#salary_change').hide();//调薪
    }
    if(obj==2){
        $('#salary_entry').hide();//入职
        $('#salary_formal').show();//转正
        $('#salary_adjustment').hide();//调岗
        $('#salary_quit').hide();//离职
        $('#salary_change').hide();//调薪
    }
    if(obj==3){
        $('#salary_entry').hide();//入职
        $('#salary_formal').hide();//转正
        $('#salary_adjustment').show();//调岗
        $('#salary_quit').hide();//离职
        $('#salary_change').hide();//调薪
    }
    if(obj==4){
        $('#salary_entry').hide();//入职
        $('#salary_formal').hide();//转正
        $('#salary_adjustment').hide();//调岗
        $('#salary_quit').show();//离职
        $('#salary_change').hide();//调薪
    }
    if(obj==5){
        $('#salary_entry').hide();//入职
        $('#salary_formal').hide();//转正
        $('#salary_adjustment').hide();//调岗
        $('#salary_quit').hide();//离职
        $('#salary_change').show();//调薪
    }
}

$('.salary_butt1').click(function(){

    var type = $(this).parents('td').find('.salary_type').val();
    var salary_aid = $(this).parents('tr').children('.salary_aid').text();//用户id
    var probation = $(this).parents('tr').find('input').val();//标准薪资
    var achievements = $(this).parents('tr').find('.salary_basic1').val();//基本薪资比
    var basic = $(this).parents('tr').find('.salary_basic2').val();//绩效薪资比
//        alert(type);alert(count);die;
    $.ajax({
        type: "post",
        url: "{:U('Salary/salary_add')}", //url
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

$('.salary_adjustment_butt4').click(function(){

    var type = $(this).parents('tr').find('.salary_status').val();//判断状态
    var aid = $(this).parents('tr').find('.salary_sid').val();//用户id
    if(type==3){
        var department = $(this).parents('tr').find('.salary_current_department').val();//部门
        var posts = $(this).parents('tr').find('.salary_present_post').val();//岗位
        var salary = $(this).parents('tr').find('.salary_present_salary').val();//岗位薪酬
        var basic1 = $(this).parents('tr').find('.salary_basic1').val();//岗位基本薪酬
        var basic2 = $(this).parents('tr').find('.salary_basic2').val();//岗位绩效薪酬

        $.ajax({
            type: "post",
            url: "{:U('Salary/salary_add')}", //url
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
            url: "{:U('Salary/salary_add')}", //url
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