<include file="Index:header2" />
<style>
    #btn-default_1{
        background-color:#00acd6;
    }
    th{
        text-align:center;
    }
    td input{
        text-align:center;
    }
</style>
<aside class="right-side">

    <section class="content-header">
        <h1><?php echo $year;?>{$datetime['year']}年季度预算录入</h1>
        <ol class="breadcrumb">
            <li><a href="{:U('Index/index')}"><i class="fa fa-home"></i> 首页</a></li>
            <li><a href="{:U('Manage/Manage_year')}"><i class="fa fa-gift"></i> {$datetime['year']}年季度预算报表</a></li>
        </ol>
    </section>

    <!-- Main content -->
    <section class="content">

        <div class="row">
            <!-- right column -->
            <div class="col-md-12">

                <div class="box box-warning">
                    <div class="box-header">
                        <h3 class="box-title">第<?php if($type==1){echo "一";}elseif($type==2){echo "二";}elseif($type==3){echo "三";}elseif($type==4){echo "四";}?>季度预算录入</h3>

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
                                                if ($value['statu']==1){ echo "待提交审核"; }
                                                elseif ($value['statu']==2){ echo "待提交批准"; }
                                                elseif ($value['statu']==3){ echo "待批准"; }
                                            }
                                        } ?>
                                    </td>
                                </foreach>
                            </tr>
                        </table><br><br>


                        <?php if(!$not_upd){ ?>
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
                                            <select name="department" class="form-control">
                                                <foreach name="department" item="v">
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
                            <?php  if(rolemenu(array('Manage/quarter_submit'))){ ?>
                                <form action="{:U('Manage/quarter_submit')}" method="post" style="<?php if($type==1){echo "";}else{echo "display:none;";}?>">
                                    <p style="color:red;">(请确认自己部门数据预算后点击 <b>"提交审核"</b>,提交后不可更改!)</p>
                                    <input type="hidden" name="status" value="1">
                                    <input type="submit" value="提交审核" class="btn btn-info" style="width:10em;">
                                </form>
                            <?php } ?>
<!--                            <if condition="rolemenu(array('Manage/quarter_paprova'))" class="{:on('Manage/quarter_paprova')}">-->
<!--                                <div style="--><?php //if($type==2){echo "";}else{echo "display:none;";}?><!--">-->
<!--                                    <a href="{:U('Manage/quarter_paprova',array('status'=>2))}" class="btn btn-info" style="width:10em;">提交批准</a>-->
<!--                                    <a href="{:U('Manage/quarter_paprova',array('type'=>1))}"  class="btn btn-info" style="width:10em;">驳回</a>-->
<!--                                </div>-->
<!--                            </if>-->
                            <if condition="rolemenu(array('Manage/quarter_approve'))" class="{:on('Manage/quarter_approve')}">
                                <div style="<?php if($type==3){echo "";}else{echo "display:none;";}?>" >
                                    <a href="{:U('Manage/quarter_approve',array('status'=>3))}" class="btn btn-info" style="width:10em;">批准</a>
                                    <a href="{:U('Manage/quarter_approve',array('type'=>1))}"  class="btn btn-info" style="width:10em;">驳回</a>
                                </div>
                            </if>

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