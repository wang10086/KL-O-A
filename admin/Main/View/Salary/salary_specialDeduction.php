
<!--专项附加扣除 -->
<div class="box box-warning">
    <div class="box-header">
        <div class="box-header">
            <h3 class="box-title"><b>专项附加扣除</b></h3>
        </div>
    </div><!-- /.box-header -->
    <div class="box-body">
        <!-- 专项附加扣除-->
        <div class="content" id="salary_withholding3">
            <label>选择人员：</label>
            <a href="javascript:;" class="btn btn-info btn-sm" onclick="javascript:opensearch('searchtext',500,180);autocomp('nickname');"><i class="fa fa-search"></i> 搜索</a> (提示: 选择不到人员或基本信息不完整、错误时，请在“员工管理”->"人员管理"页面添加或编辑信息)<br><br>

            <table class="table table-bordered dataTable fontmini" id="tablelist" style="margin-top:10px;">
                <tr role="row" class="orders" >
                    <!--<th class="sorting" data="op_id"  width="40">ID</th>-->
                    <th class="sorting" rowspan="2" data="" width="40">编号</th>
                    <th class="sorting" rowspan="2" data="" width="60">员工姓名</th>
                    <!--<th class="sorting" rowspan="2" data="" width="">岗位</th>-->
                    <th class="taskOptions" colspan="2" width="14%">子女教育</th>
                    <th class="taskOptions" colspan="2" width="14%">继续教育</th>
                    <th class="taskOptions" colspan="2" width="14%">大病医疗</th>
                    <th class="taskOptions" colspan="2" width="14%">购房贷款</th>
                    <th class="taskOptions" colspan="2" width="14%">住房租金</th>
                    <th class="taskOptions" colspan="2" width="14%">赡养老人</th>
                    <th class="taskOptions" rowspan="2">操作</th>
                </tr>
                <tr>
                    <th class="taskOptions">原金额</th>
                    <th class="taskOptions">现金额</th>
                    <th class="taskOptions">原金额</th>
                    <th class="taskOptions">现金额</th>
                    <th class="taskOptions">原金额</th>
                    <th class="taskOptions">现金额</th>
                    <th class="taskOptions">原金额</th>
                    <th class="taskOptions">现金额</th>
                    <th class="taskOptions">原金额</th>
                    <th class="taskOptions">现金额</th>
                    <th class="taskOptions">原金额</th>
                    <th class="taskOptions">现金额</th>
                </tr>

                <foreach name="lists" item="v">
                    <tr>
                        <form method="post" action="{:U('salary/save_spacialDeduction')}" id="sd_{$v.aid}">
                            <input type="hidden" name="uid" value="{$v.aid}">
                            <input type="hidden" name="nickname" value="{$v.nickname}">
                            <td>{$v.employee_member}</td>
                            <td>{$v.nickname}</td>
                            <!--<td>{$v.post_name}</td>-->
                            <td width="6%"  class="taskOptions">{$v.children_education}</td>
                            <td width="8%"><input type="text" name="info[children_education]" class="form-control salary-special-deduction-input" placeholder="请输入抵扣金额"></td>
                            <td width="6%"  class="taskOptions">{$v.continue_education}</td>
                            <td width="8%"><input type="text" name="info[continue_education]" class="form-control salary-special-deduction-input" placeholder="请输入抵扣金额"></td>
                            <td width="6%"  class="taskOptions">{$v.health}</td>
                            <td width="8%"><input type="text" name="info[health]" class="form-control salary-special-deduction-input" placeholder="请输入抵扣金额"></td>
                            <td width="6%"  class="taskOptions">{$v.buy_house}</td>
                            <td width="8%"><input type="text" name="info[buy_house]" class="form-control salary-special-deduction-input" placeholder="请输入抵扣金额"></td>
                            <td width="6%"  class="taskOptions">{$v.rent_house}</td>
                            <td width="8%"><input type="text" name="info[rent_house]" class="form-control salary-special-deduction-input" placeholder="请输入抵扣金额"></td>
                            <td width="6%"  class="taskOptions">{$v.support_older}</td>
                            <td width="8%"><input type="text" name="info[support_older]" class="form-control salary-special-deduction-input" placeholder="请输入抵扣金额"></td>
                            <td width="30" class="taskOptions">
                                <a href="javascript:;" onclick="save('sd_{$v.aid}','<?php echo U('Salary/save_spacialDeduction'); ?>')" title="保存" class="btn btn-info btn-smsm"><i class="fa fa-check"></i></a>
                            </td>
                        </form>
                    </tr>
                </foreach>
            </table>
        </div>
        <div class="box-footer clearfix">
            <div class="pagestyle">{$pages}</div>
        </div>
    </div><!-- /.box -->

</div>

<script>
    artDialog.alert = function (content, status) {
        return artDialog({
            id: 'Alert',
            icon: status,
            width:300,
            height:120,
            fixed: true,
            lock: true,
            time: 1,
            content: content,
            ok: true
        });
    };


    //保存信息
    function save(id,url){
        $.ajax({
            type: "POST",
            url: url,
            dataType:'json',
            data: $('#'+id).serialize(),
            success:function(data){
                if(parseInt(data)>0){
                    art.dialog.alert('保存成功','success');
                }else{
                    art.dialog.alert('保存失败','warning');
                }
            }
        });

        setTimeout("history.go(0)",1000);
    }

</script>

