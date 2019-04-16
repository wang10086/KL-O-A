<include file="Index:header2" />
<aside class="right-side">

    <section class="content-header">
        <h1><?php if ($type==5){ echo $year."年年度预算录入"; }else{ echo $year.'年季度预算录入'; } ?></h1>
        <ol class="breadcrumb">
            <li><a href="{:U('Index/index')}"><i class="fa fa-home"></i> 首页</a></li>
            <li><a href="{:U('Manage/Manage_year')}"><i class="fa fa-gift"></i> 经营管理</a></li>
        </ol>
    </section>

    <!-- Main content -->
    <section class="content">

        <div class="row">
            <!-- right column -->
            <div class="col-md-12">

                <div class="box box-warning">
                    <div class="box-header">
                        <?php if($type==5){ ?>
                        <h3 class="box-title">{$year}年年度预算录入</h3>
                        <?php }else{ ?>
                        <h3 class="box-title">第<?php if($type==1){echo "一";}elseif($type==2){echo "二";}elseif($type==3){echo "三";}elseif($type==4){echo "四";}?>季度预算录入</h3>
                        <?php } ?>
                    </div><!-- /.box-header -->
                    <div class="box-body">

                        <table class="table table-bordered dataTable fontmini" id="tablecenter">
                            <tr role="row" class="orders" >
                                <th class="black" style="width:10em;" >项目</th>
                                <foreach name="department" item="v">
                                    <th class="black" style="width:10em;" >{$v}</th>
                                </foreach>
                            </tr>

                            <tr role="row" class="orders">
                                <th>员工人数</th>
                                <foreach name="department" item="v">
                                    <td>
                                        <?php foreach ($lists as $value){
                                            if ($value['logged_department'] == $v){
                                                echo $value['employees_number'].' 人';
                                            }
                                        } ?>
                                    </td>
                                </foreach>
                            </tr>
                            <tr role="row" class="orders">
                                <td>营业收入</td>
                                <foreach name="department" item="v">
                                    <td>
                                        <?php foreach ($lists as $value){
                                            if ($value['logged_department'] == $v){
                                                echo '&yen;'.$value['logged_income'];
                                            }
                                        } ?>
                                    </td>
                                </foreach>
                            </tr>
                            <tr role="row" class="orders">
                                <td>营业毛利</td>
                                <foreach name="department" item="v">
                                    <td>
                                        <?php foreach ($lists as $value){
                                            if ($value['logged_department'] == $v){
                                                echo '&yen;'.$value['logged_profit'];
                                            }
                                        } ?>
                                    </td>
                                </foreach>
                            </tr>
                            <tr role="row" class="orders">
                                <td>营业毛利率(%)</td>
                                <foreach name="department" item="v">
                                    <td>
                                        <?php foreach ($lists as $value){
                                            if ($value['logged_department'] == $v){
                                                echo $value['logged_rate'].'%';
                                            }
                                        } ?>
                                    </td>
                                </foreach>
                            </tr>
                            <tr role="row" class="orders">
                                <td>人力资源成本</td>
                                <foreach name="department" item="v">
                                    <td>
                                        <?php foreach ($lists as $value){
                                            if ($value['logged_department'] == $v){
                                                echo '&yen;'.$value['manpower_cost'];
                                            }
                                        } ?>
                                    </td>
                                </foreach>
                            <tr role="row" class="orders">
                                <td>其他费用</td>
                                <foreach name="department" item="v">
                                    <td>
                                        <?php foreach ($lists as $value){
                                            if ($value['logged_department'] == $v){
                                                echo '&yen;'.$value['other_expenses'];
                                            }
                                        } ?>
                                    </td>
                                </foreach>
                            </tr>
                            <tr role="row" class="orders">
                                <td>利润总额</td>
                                <foreach name="department" item="v">
                                    <td>
                                        <?php foreach ($lists as $value){
                                            if ($value['logged_department'] == $v){
                                                echo '&yen;'.$value['total_profit'];
                                            }
                                        } ?>
                                    </td>
                                </foreach>
                            </tr>
                            <tr role="row" class="orders">
                                <th>目标利润</th>
                                <foreach name="department" item="v">
                                    <td>
                                        <?php foreach ($lists as $value){
                                            if ($value['logged_department'] == $v){
                                                echo '&yen;'.$value['target_profit'];
                                            }
                                        } ?>
                                    </td>
                                </foreach>
                            </tr>
                            <tr role="row" class="orders">
                                <td>人事费用率(%)</td>
                                <foreach name="department" item="v">
                                    <td>
                                        <?php foreach ($lists as $value){
                                            if ($value['logged_department'] == $v){
                                                echo $value['personnel_cost_rate'].'%';
                                            }
                                        } ?>
                                    </td>
                                </foreach>
                            </tr>
                            <tr role="row" class="orders">
                                <td>状态</td>
                                <foreach name="department" item="v">
                                    <td>
                                        <?php foreach ($lists as $value){
                                            if ($value['logged_department'] == $v){
                                                echo $value['stu'];
                                            }
                                        } ?>
                                    </td>
                                </foreach>
                            </tr>
                        </table><br><br>


                        <?php if(rolemenu(array('Manage/Manage_save'))){ ?>
                            <table class="table table-bordered dataTable fontmini" id="tablecenter1">
                                <tr role="row" class="orders" >
                                    <th>部门</th>
                                    <th>员工人数</th>
                                    <th>营业收入</th>
                                    <th>营业毛利</th>
                                    <th>营业毛利率(%)</th>
                                    <th>人力资源成本</th>
                                    <th>其他费用</th>
                                    <th>利润总额</th>
                                    <th>目标利润</th>
                                    <th>人事费用率(%)</th>
                                    <th>状态</th>
                                </tr>
                                <tr role="row" class="orders">
                                    <form action="{:U('Manage/Manage_save')}" method="post" id="saveManage">
                                        <input type="hidden" name="year" value="{$year}">
                                        <input type="hidden" name="type" value="{$type}">
                                        <td>
                                            <select name="department" class="form-control" onchange="get_plans_manage($(this).val())">
                                                <option value="" selected disabled>请选择</option>
                                                <foreach name="upd_department" item="v">
                                                    <option value="{$v}">{$v}</option>
                                                </foreach>
                                            </select>
                                        </td>
                                        <td><input type="text" name="number" class="form-control" placeholder="例如：50 或 50.29"></td>
                                        <td><input type="text" name="income" class="form-control manage_num1" placeholder="例如：500.23 或 500"></td>
                                        <td><input type="text" name="profit" class="form-control manage_num2" placeholder="例如：500.23 或 500"></td>
                                        <td><input type="text" name="rate" class="form-control manage_num3" placeholder="例如：25.23 或 25"></td>
                                        <td><input type="text" name="cost" class="form-control manage_num4"  placeholder="例如：500.23 或 500"></td>
                                        <td><input type="text" name="other" class="form-control manage_num5" placeholder="例如：500.23 或 500"></td>
                                        <td><input type="text" name="total" class="form-control manage_num6" placeholder="例如：500.23 或 500"></td>
                                        <td><input type="text" name="target_profit" class="form-control manage_num8" placeholder="例如：500.23 或 500"></td>
                                        <td><input type="text" name="personnel" class="form-control manage_num7" placeholder="例如：50.23 或 50"></td>
                                        <td>
                                            <!--<input type="submit" value="保存" style="background-color:#00acd6;font-size:1.5em;">-->
                                            <a  href="javascript:;" class="btn btn-info btn-sm" onClick="javascript:save('saveManage','<?php echo U('Manage/Manage_save'); ?>');">保存</a>
                                        </td>
                                    </form>
                                </tr>

                            </table><br><br>
                        <?php } ?>

                        <div style="text-align:center;" id="shr_qianzi">
                            <?php  if(rolemenu(array('Manage/quarter_submit')) && $check_data){ ?>
                                <form action="{:U('Manage/quarter_submit')}" method="post" >
                                    <p class="red">(请确认本部门预算数据无误后点击 <b>"提交审核"</b>,提交后不可更改!)</p>
                                    <input type="hidden" name="year" value="{$year}">
                                    <input type="hidden" name="type" value="{$type}">
                                    <a  href="javascript:;" class="btn btn-info" onClick="javascript:save('saveManage','<?php echo U('Manage/quarter_submit'); ?>');">提交审核</a>
                                </form>
                            <?php } ?>

                            <?php if (rolemenu(array('Manage/quarter_approve')) && in_array(session('userid'),array(1,11)) && $show_check){ ?>
                                <div class="mt20" >
                                    <a href="{:U('Manage/quarter_approve',array('year'=>$year,'type'=>$type,'statu'=>4))}" class="btn btn-info" style="width:10em;">批准</a>
                                    <a href="{:U('Manage/quarter_approve',array('year'=>$year,'type'=>$type,'statu'=>3))}"  class="btn btn-info" style="width:10em;">驳回</a>
                                </div>
                            <?php } ?>

                        </div><br><br>

                    </div><!-- /.box-body -->

                </div><!-- /.box -->

            </div><!--/.col (right) -->

        </div>   <!-- /.row -->

    </section><!-- /.content -->

</aside><!-- /.right-side -->

<include file="Index:footer2" />

<script>

    $("input").mouseleave(function (){
        var num1    = $(".manage_num1").val();//营业收入
        var num2    = $(".manage_num2").val();//营业毛利
        var num4    = $(".manage_num4").val();//人力资源成本
        var num5    = $(".manage_num5").val();//其他费用
        var num3    = (num2*100/num1).toFixed(2);//营业毛利率
        var number  = $(".manage_num3").val(num3);
        var contetn = num2-num4-num5;//利润总额
        var num6    = $(".manage_num6").val(contetn);
        var port    = (num4*100/num1).toFixed(2);//人事费用率
        var num7    = $(".manage_num7").val(port);

    });

    function get_plans_manage(department) {
        var year        = {$year};
        var type        = {$type};
        if (!year || !type || !department){ art_show_msg('数据错误'); return false; }
        $.ajax({
            type: 'POST',
            url: "{:U('Ajax/get_plans_manage')}",
            dataType: 'JSON',
            data: {year:year,type:type,department:department},
            success:function (msg) {
                if (msg){
                    $("input[name='number']").val(msg.employees_number);
                    $("input[name='income']").val(msg.logged_income);
                    $("input[name='profit']").val(msg.logged_profit);
                    $("input[name='rate']").val(msg.logged_rate);
                    $("input[name='cost']").val(msg.manpower_cost);
                    $("input[name='other']").val(msg.other_expenses);
                    $("input[name='total']").val(msg.total_profit);
                    $("input[name='target_profit']").val(msg.target_profit);
                    $("input[name='personnel']").val(msg.personnel_cost_rate);
                }
            }
        })

    }

    artDialog.alert = function (content, status,time) {
        return artDialog({
            id: 'Alert',
            icon: status,
            width:300,
            height:120,
            fixed: true,
            lock: true,
            time: time,
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
                var stu     = data.stu;
                if(parseInt(stu)>0){
                    art.dialog.alert(data.msg,'success',1);
                }else{
                    art.dialog.alert(data.msg,'warning',3);
                }
            }
        });

        setTimeout("history.go(0)",2000);
    }

</script>