<include file="Index:header2" />
<script src="__HTML__/js/public.js?v=1.0.6" type="text/javascript"></script>
            <aside class="right-side">
                <!-- Content Header (Page header) -->
                <section class="content-header">
                    <h1>扶植人员信息</h1>
                    <ol class="breadcrumb">
                        <li><a href="{:U('Index/index')}"><i class="fa fa-home"></i> 首页</a></li>
                        <li><a href="{:U('Salary/salaryindex')}"><i class="fa fa-gift"></i>人力管理</a></li>
                        <li class="active">扶植人员列表</li>
                    </ol>

                </section>

                <!-- Main content -->
                <section class="content" >

                    <div class="row">
                        <div class="col-xs-12">
                            <div class="box">
                                <div class="box-header">
                                    <h3 class="box-title">扶植人员列表</h3>
                                    <div class="box-tools pull-right">
                                        <if condition="rolemenu(array('Salary/salary_query'))">
                                            <a  class="btn btn-sm btn-danger supportadd"><i class="fa fa-plus"></i> 添加扶植信息</a>
                                        </if>

                                        <a href="javascript:;" class="btn btn-info btn-sm" onclick="javascript:opensearch('searchtext',700,160);"><i class="fa fa-search"></i> 搜索</a>
                                    </div>
                                </div><!-- /.box-header -->
                                <div class="box-body">

                                    <table class="table table-bordered dataTable fontmini" id="supportlist1" style="margin-top:8px;text-align:center;<?php if($status==1 || $status==""){echo 'display:none;';}?>">
                                        <tr role="row" class="orders"  >
                                            <th class="sorting" data="group_id"> <center>ID</center></th>
                                            <th class="sorting" data="group_id"><center>员工姓名</center></th>
                                            <th class="sorting" data="group_id"><center>员工编码</center></th>
                                            <th class="sorting" data="group_id"><center>员工部门</center></th>
                                            <th class="sorting" data="group_id"><center>员工岗位</center></th>
                                            <th class="sorting" data="group_id"><center>修改扶植开始时间</center></th>
                                            <th class="sorting" data="group_id"><center>修改扶植结束时间</center></th>
                                            <th class="sorting" data="group_id"><center>操作</center></th>
                                        </tr>

                                        <foreach name="userinfo" item="user">
                                            <form action="{:U('Salary/salary_support')}" method="post">
                                                <tr>
                                                    <td>{$user['info']['id']}</td>
                                                    <td>{$user['info']['nickname']}</td>
                                                    <td>{$user['info']['employee_member']}</td>
                                                    <td>{$user['department']['department']}</td>
                                                    <td>{$user['posts']['post_name']}</td>
                                                    <td><center><input type="text" name="starttime" class="form-control inputdate" value="<?php if($user['support']['starttime']==""){echo "";}else{echo date('Y/m/d',$user['support']['starttime']);}?>" style="width:16em;"/></center></td>
                                                    <td><center><input type="text" name="endtime" class="form-control inputdate" value="<?php if($user['support']['endtime']==""){echo "";}else{echo date('Y/m/d',$user['support']['endtime']);}?>" style="width:16em;"/></center></td>
                                                    <input type="hidden" name="userid" value="{$user['info']['id']}">
                                                    <input type="hidden" name="type" value="1">
                                                    <td><input type="submit" value="添加扶植人员" style="font-weight:bold;background-color:#00acd6;color:#FFFFFF;padding:0.3em;font-size: 1.2em;" /> </td>
                                                </tr>
                                            </form>
                                        </foreach>
                                    </table>

                                    <table class="table table-bordered dataTable fontmini" id="supportlist2" style="margin-top:8px;<?php if($status==2){echo 'display:none;';}?>">
                                        <tr role="row" class="orders" >
                                            <th class="sorting" data="op_id">ID</th>
                                            <th class="sorting" data="group_id">员工姓名</th>
                                            <th class="sorting" data="group_id">员工编码</th>
                                            <th class="sorting" data="group_id">员工岗位</th>
                                            <th class="sorting" data="group_id">员工部门</th>
                                            <th class="sorting" data="group_id">扶植开始时间</th>
                                            <th class="sorting" data="group_id">扶植结束时间</th>

                                        </tr>

                                        <foreach name="userinfo" item="info">
                                        <tr>
                                            <td>{$info['info']['id']}</td>
                                            <td>{$info['info']['nickname']}</td>
                                            <td>{$info['info']['employee_member']}</td>
                                            <td>{$info['department']['department']}</td>
                                            <td>{$info['posts']['post_name']}</td>
                                            <td><?php if($info['support']['starttime']==""){echo "";}else{echo date('Y/m/d',$info['support']['starttime']);}?></td>
                                            <td><?php if($info['support']['endtime']==""){echo "";}else{echo date('Y/m/d',$info['support']['endtime']);}?></td>
                                        </tr>
                                      </foreach>
                                    </table>

                                    <?php if($userinfo==""){?>
                                        <br><br>
                                        <div style="font-size:2em;text-align:center;">
                                            暂无扶植人员信息
                                        </div> <br>  <br>
                                    <?php } ?>
                                </div><!-- /.box-body -->
                                 <div class="box-footer clearfix">
                                	<div class="pagestyle">{$page}</div>
                                </div>
                            </div><!-- /.box -->

                        </div><!-- /.col -->
                     </div>

                </section><!-- /.content -->
            </aside><!-- /.right-side -->


            <div id="searchtext">
                <script src="__HTML__/js/public.js?v=1.0.6" type="text/javascript"></script>

                <form action="{:U('Salary/salary_support')}" method="post" id="searchform">
                <div class="form-group col-md-3">
                    <input type="text" class="form-control" name="id" placeholder="ID编号">
                </div>
                    <div class="form-group col-md-3">
                        <input type="text" class="form-control" name="employee_member" placeholder="部门">
                    </div>

                <div class="form-group col-md-3">
                    <input type="text" class="form-control" name="name" placeholder="员工姓名">
                </div>
                <div class="form-group col-md-3" id="support_add_input">
                    <input type="hidden" class="form-control"  name="status" value="1">
                </div>
                </form>
            </div>




<include file="Index:footer2" />


<script>
    $(function(){
        var ststus   = <?php echo (int)$status;?>;
        $('#support_add_input').remove(); //清除上一次添加弹框
        if(ststus==1){
            var type = 1;
        }else if(ststus==2){
            var type = 2;
        }else if(ststus==''){
            var type = 1;
        }
        var html = '<div class="form-group col-md-3" id="support_add_input">';
            html += '<input type="hidden" class="form-control support_add_input" name="status" value="'+type+'">';
            html +='</div>';
        $('#searchform').append(html);

    });

    //添加扶植人信息  点击事件
$('.supportadd').click(function(){
    $('#support_add_input').remove(); //清除上一次添加弹框
    $('#supportlist1').toggle(); //显示隐藏
    $('#supportlist2').toggle();//显示隐藏
    if($('#supportlist1').css('display')=='none'){ //添加显示
        var type = 1;
    }else if($('#supportlist2').css('display')=='none'){ //列表显示
       var type  = 2;
    }
    var html = '<div class="form-group col-md-3" id="support_add_input">';
        html += '<input type="hidden" class="form-control support_add_input" name="status" value="'+type+'">';
        html +='</div>';
    $('#searchform').append(html);//添加弹框div
});


</script>