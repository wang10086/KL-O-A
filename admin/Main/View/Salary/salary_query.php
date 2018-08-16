<include file="Index:header2" />

            <aside class="right-side">
                <!-- Content Header (Page header) -->
                <section class="content-header">
                    <h1>
                        数据录入
                    </h1>

                    <ol class="breadcrumb">
                        <li><a href="{:U('Index/index')}"><i class="fa fa-home"></i> 首页</a></li>
                        <li><a href="{:U('Salary/salaryindex')}"><i class="fa fa-gift"></i> 人力资源</a></li>
                        <li class="active">岗位薪酬变动</li>
                    </ol>

                </section>

                <!-- Main content -->
                <section class="content">
                    <div class="row">
                        <div class="col-xs-12">
                            <div class="box">
                                <div class="box-header">

                                    <div class="box-tools pull-left">
                                       <h3 style="color:blue"><b>岗位薪酬变动</h3>
                                        <h4 style="margin:-1.8em 0em 0em 10em">变动事项</h4>
                                       <select name="some" class="btn btn-info btn-sm" style="margin:-3.5em 0em 0em 22em;" id=""salary_id>
                                            <option value="0">选择操作</option>
                                            <option value="1" onclick="salary_entry(1)">入职</option>
                                            <option value="2" onclick="salary_entry(2)">转正</option>
                                            <option value="3" onclick="salary_entry(3)">调岗</option>
                                            <option value="4" onclick="salary_entry(4)">离职</option>
                                            <option value="5" onclick="salary_entry(5)">调薪</option>
                                        </select>
                    
                                    </div>
                                </div><!-- /.box-header -->
                                <div class="box-body">
                                <div class="btn-group" id="salary_add_backcolor">
                                    <br>


                                    <!-- 入职 -->

                                    <div id="salary_entry" >
                                        <div style="float: left;margin-left: 2em;">
                                            <label>选择人员：</label>
                                            <a href="javascript:;" class="btn btn-info btn-sm" onclick="javascript:opensearch('searchtext',700,160);"><i class="fa fa-search"></i> 搜索</a> (提示: 选择不到人员或基本信息不完整、错误时，请在“员工管理”->"人员管理"页面添加或编辑信息)<br><br>

                                            <table class="table table-bordered dataTable fontmini" id="tablelist" style="margin-top:10px;">
                                                <tr role="row" class="orders" >
                                                    <th class="sorting" data="op_id"  style="width:6em;">ID</th>
                                                    <th class="sorting" data="group_id" style="width:12em;">员工姓名</th>
                                                    <th class="sorting" data="group_id" style="width:12em;">员工编号</th>
                                                    <th class="sorting" data="group_id" style="width:12em;">员工部门</th>
                                                    <th class="sorting" data="project" style="width:12em;">员工岗位</th>
                                                    <th class="sorting" data="number" style="width:12em;">入职时间</th>
                                                    <th class="sorting" data="number" style="width:16em;">试用期岗位薪酬标准</th>
                                                    <th class="sorting" data="shouru" style="width:16em;">试用期基效比</th>
                                                    <th class="sorting" data="shouru" style="width:12em;">操作</th>
                                                    </if>

                                                </tr>

                                                <foreach name="list" item="row">
                                                    <tr>
                                                        <td class="salary_aid" id="{$row.aid}">{$row.aid}</td>
                                                        <td>{$row.nickname}</td>
                                                        <td>{$row.employee_member}</td>
                                                        <td>{$row.department}</td>
                                                        <td>{$row.post_name}</td>
                                                        <td><?php echo date('Y-m-d',$row['entry_time'])?></td>
                                                        <td class="salary_probation"><input type="text" class="form-control" value="{$row.standard_salary}" /></td>
                                                        <td class="salary_basic">
                                                            <input type="text" style="width:5em" class="salary_basic1" value="{$row.basic_salary}" /> :
                                                            <input type="text" style="width:5em" class="salary_basic2" value="{$row.performance_salary}" />
                                                        </td>
                                                        <td class="salary_entry">
                                                            <input type="hidden" class="salary_type" value="1"/>
                                                            <input type="button" value="保存" style="background-color:#00acd6;font-size:1em;" class="salary_butt1 salary_butt3"> |
                                                            <input type="button" value="编辑" style="background-color:#00acd6;font-size:1em;" class="salary_butt1 salary_butt2">
                                                        </td>
                                                    </tr>
                                                </foreach>
                                            </table>
                                        </div>
                                    </div>



                                    <!--转正-->

                                    <div id="salary_formal" style="display:none">
                                        <div style="float: left;margin-left: 2em;">
                                            <label>选择人员：</label>
                                            <a href="javascript:;" class="btn btn-info btn-sm" onclick="javascript:opensearch('searchtext',700,160);"><i class="fa fa-search"></i> 搜索</a> (提示: 选择不到人员或基本信息不完整、错误时，请在“员工管理”->"人员管理"页面添加或编辑信息)<br><br>

                                            <table class="table table-bordered dataTable fontmini" id="tablelist" style="margin-top:10px;">
                                                <tr role="row" class="orders" >
                                                    <th class="sorting" data="op_id"  style="width:8em;">ID</th>
                                                    <th class="sorting" data="group_id" style="width:8em;">员工姓名</th>
                                                    <th class="sorting" data="group_id" style="width:8em;">员工编号</th>
                                                    <th class="sorting" data="group_id" style="width:8em;">员工部门</th>
                                                    <th class="sorting" data="project" style="width:8em;">员工岗位</th>
                                                    <th class="sorting" data="number" style="width:8em;">入职时间</th>
                                                    <th class="sorting" data="number" style="width:14em;">试用期岗位薪酬标准</th>
                                                    <th class="sorting" data="shouru" style="width:14em;">试用期基效比</th>
                                                    <th class="sorting" data="shouru" style="width:14em;">转正后期岗位薪酬标准</th>
                                                    <th class="sorting" data="shouru" style="width:14em;">转正后期基效比</th>
                                                    <th class="sorting" data="shouru" style="width:6em;">操作</th>
                                                    </if>

                                                </tr>

                                                <foreach name="list" item="row">
                                                    <tr>
                                                        <td class="salary_aid {$row.aid}">{$row.aid}</td>
                                                        <td>{$row.nickname}</td>
                                                        <td>{$row.employee_member}</td>
                                                        <td>{$row.department}</td>
                                                        <td>{$row.post_name}</td>
                                                        <td><?php echo date('Y-m-d',$row['entry_time'])?></td>
                                                        <td>{$row.standard_salary}</td>
                                                        <td>{$row.basic_salary} <?php if(!empty($row['basic_salary'])){echo ":";} ?> {$row.performance_salary} </td>
                                                        <td><input type="text" name="name" class="form-control" /></td>
                                                        <td class="salary_basic">
                                                            <input type="text" style="width:5em" class="salary_basic1" /> :
                                                            <input type="text" style="width:5em" class="salary_basic2" />
                                                        </td>
                                                        <td class="salary_entry">
                                                            <input type="hidden" class="salary_type" value="2"/>
                                                            <input type="button" value="保存" style="background-color:#00acd6;font-size:1em;" class="salary_butt1 salary_butt2">
                                                        </td>
                                                    </tr>
                                                </foreach>

                                            </table>
                                        </div>
                                    </div>



                                    <!--调岗-->
                                    <div id="salary_adjustment" style="display:none">
                                        <div style="float: left;margin-left: 2em;">
                                            <label>选择人员：</label>
                                            <a href="javascript:;" class="btn btn-info btn-sm" onclick="javascript:opensearch('searchtext',700,160);"><i class="fa fa-search"></i> 搜索</a> (提示: 选择不到人员或基本信息不完整、错误时，请在“员工管理”->"人员管理"页面添加或编辑信息)<br><br>

                                            <table class="table table-bordered dataTable fontmini" id="tablelist" style="margin-top:10px;">
                                                <tr role="row" class="orders" >
                                                    <th class="sorting" data="op_id"  style="width:8em;">ID</th>
                                                    <th class="sorting" data="group_id" style="width:10em;">员工姓名</th>
                                                    <th class="sorting" data="group_id" style="width:10em;">员工编号</th>
                                                    <th class="sorting" data="group_id" style="width:10em;">原部门</th>
                                                    <th class="sorting" data="project" style="width:10em;">原岗位</th>
                                                    <th class="sorting" data="number" style="width:10em;">现部门</th>
                                                    <th class="sorting" data="number" style="width:15em;">现岗位</th>
                                                    <th class="sorting" data="shouru" style="width:15em;">原岗位薪酬标准</th>
                                                    <th class="sorting" data="shouru" style="width:15em;">原基效比</th>
                                                    <th class="sorting" data="shouru" style="width:15em;">现岗位薪酬标准</th>
                                                    <th class="sorting" data="shouru" style="width:15em;">现基效比</th>
                                                    <th class="sorting" data="shouru" style="width:8em;">操作</th>
                                                    </if>

                                                </tr>
                                                <foreach name="list" item="row">
                                                    <tr>
                                                        <td>{$row.aid}</td>
                                                        <td>{$row.nickname}</td>
                                                        <td>{$row.employee_member}</td>
                                                        <td>{$row.department}</td>
                                                        <td>{$row.post_name}</td>
                                                        <input type="hidden" name="aid" class="form-control salary_sid" value="{$row.aid}"/>
                                                        <td ><input type="text" name="department" class="form-control salary_current_department" /></td>
                                                        <td><input type="text" name="name" class="form-control salary_present_post" /></td>
                                                        <td>{$row.standard_salary}</td>
                                                        <td>{$row.basic_salary} <?php if(!empty($row['basic_salary'])){echo ":";} ?> {$row.performance_salary} </td>
                                                        <td><input type="text" name="name" class="form-control salary_present_salary" /></td>
                                                        <td class="salary_basic">
                                                            <input type="text" style="width:5em" class="salary_basic1" /> :
                                                            <input type="text" style="width:5em" class="salary_basic2" />
                                                        </td>
                                                        <td class="salary_entry">
                                                            <input type="hidden" class="salary_type" value="2"/>
                                                            <input type="hidden" class="salary_status" value="2"/>
                                                            <input type="button" value="保存" style="background-color:#00acd6;font-size:1em;" class="salary_butt4">
                                                        </td>
                                                    </tr>
                                                </foreach>
                                            </table>
                                        </div>
                                    </div>


                                    <!--离职-->

                                    <div id="salary_quit" style="display:none">
                                        <div style="float: left;margin-left: 2em;">
                                            <label>选择人员：</label>
                                            <a href="javascript:;" class="btn btn-info btn-sm" onclick="javascript:opensearch('searchtext',700,160);"><i class="fa fa-search"></i> 搜索</a> (提示: 选择不到人员或基本信息不完整、错误时，请在“员工管理”->"人员管理"页面添加或编辑信息)<br><br>

                                            <table class="table table-bordered dataTable fontmini" id="tablelist" style="margin-top:10px;">
                                                <tr role="row" class="orders" >
                                                    <th class="sorting" data="op_id"  style="width:9em;">ID</th>
                                                    <th class="sorting" data="group_id" style="width:12em;">员工姓名</th>
                                                    <th class="sorting" data="group_id" style="width:12em;">员工编号</th>
                                                    <th class="sorting" data="group_id" style="width:12em;">部门</th>
                                                    <th class="sorting" data="project" style="width:12em;">岗位</th>
                                                    <th class="sorting" data="number" style="width:12em;">岗位薪酬标准</th>
                                                    <th class="sorting" data="number" style="width:16em;">基效比</th>
                                                    <th class="sorting" data="shouru" style="width:16em;">离职日期</th>
                                                    <th class="sorting" data="shouru" style="width:9em;">操作</th>
                                                    </if>

                                                </tr>

                                                <foreach name="list" item="row">
                                                    <tr>
                                                        <td>{$row.aid}</td>
                                                        <td>{$row.nickname}</td>
                                                        <td>{$row.employee_member}</td>
                                                        <td>{$row.department}</td>
                                                        <td>{$row.post_name}</td>
                                                        <td>{$row.standard_salary}</td>
                                                        <td>{$row.basic_salary} <?php if(!empty($row['basic_salary'])){echo ":";} ?> {$row.performance_salary} </td>
                                                        <td>&nbsp;&nbsp;&nbsp;<input type="date"></td>
                                                        <td>&nbsp;&nbsp;&nbsp;<input type="button" value="保存" style="background-color:#00acd6;font-size:1.5em;"></td>
                                                    </tr>
                                                </foreach>


                                            </table>
                                        </div>
                                    </div>


                                    <!--调薪-->

                                    <div id="salary_change" style="display:none">
                                        <div style="float: left;margin-left: 2em;">
                                            <label>选择人员：</label>
                                            <a href="javascript:;" class="btn btn-info btn-sm" onclick="javascript:opensearch('searchtext',700,160);"><i class="fa fa-search"></i> 搜索</a> (提示: 选择不到人员或基本信息不完整、错误时，请在“员工管理”->"人员管理"页面添加或编辑信息)<br><br>

                                            <table class="table table-bordered dataTable fontmini" id="tablelist" style="margin-top:10px;">
                                                <tr role="row" class="orders" >
                                                    <th class="sorting" data="op_id"  style="width:9em;">ID</th>
                                                    <th class="sorting" data="group_id" style="width:12em;">员工姓名</th>
                                                    <th class="sorting" data="group_id" style="width:12em;">员工编号</th>
                                                    <th class="sorting" data="group_id" style="width:12em;">部门</th>
                                                    <th class="sorting" data="project" style="width:12em;">岗位</th>
                                                    <th class="sorting" data="number" style="width:12em;">原岗位薪酬标准</th>
                                                    <th class="sorting" data="number" style="width:15em;">原基效比</th>
                                                    <th class="sorting" data="shouru" style="width:15em;">现岗位薪酬标准</th>
                                                    <th class="sorting" data="number" style="width:15em;">现岗位薪酬标准</th>
                                                    <th class="sorting" data="shouru" style="width:9em;">操作</th>
                                                    </if>

                                                </tr>

                                                <foreach name="list" item="row">
                                                    <tr>
                                                        <td>{$row.aid}</td>
                                                        <td>{$row.nickname}</td>
                                                        <td>{$row.employee_member}</td>
                                                        <td>{$row.department}</td>
                                                        <td>{$row.post_name}</td>
                                                        <td>{$row.standard_salary}</td>
                                                        <td>{$row.basic_salary} <?php if(!empty($row['basic_salary'])){echo ":";} ?> {$row.performance_salary} </td>
                                                        <td>&nbsp;&nbsp;&nbsp;<input type="text"></td>
                                                        <td>&nbsp;&nbsp;&nbsp;<input type="text"></td>
                                                        <td>&nbsp;&nbsp;&nbsp;<input type="button" value="保存" style="background-color:#00acd6;font-size:1.5em;"></td>
                                                    </tr>
                                                </foreach>

                                            </table>
                                        </div>
                                    </div>

                                </div><!-- /.box -->

                        </div><!-- /.col -->
                     </div>

                        <div id="searchtext">
                            <script src="__HTML__/js/public.js?v=1.0.6" type="text/javascript"></script>

                            <form action="{:U('Salary/salary_query')}" method="post" id="searchform">

                                <div class="form-group col-md-3">
                                    <input type="text" class="form-control" name="id" placeholder="ID编号">
                                </div>
                                <div class="form-group col-md-3">
                                    <input type="text" class="form-control" name="employee_member" placeholder="员工编号">
                                </div>

                                <div class="form-group col-md-3">
                                    <input type="text" class="form-control" name="nickname" placeholder="员工姓名">
                                </div>
                                <div class="form-group col-md-3">
                                    <input type="text" class="form-control" name="departmen" placeholder="部门">
                                </div>
                                <div class="form-group col-md-3">
                                    <input type="text" class="form-control" name="posts" placeholder="岗位">
                                </div>
                                <div class="form-group col-md-3">
                                    <input type="text" class="form-control" name="all" placeholder="输入'所有' 查询所有">
                                </div>

                            </form>
                        </div>
<br><br><br>
                </section><!-- /.content -->
                <!--   操作历史 -->
                <include file="record_list" />
            </aside><!-- /.right-side -->


<include file="Index:footer2" />
<script>
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

        if(($(this).val()=='保存' && type == 1) || $(this).val()=='保存'){
            var count = 1;
        }
        if($(this).val()=='编辑' || (type == 2 && $(this).val()=='保存')){
            var count = 2;
        }

        var salary_aid = $(this).parents('tr').children('.salary_aid').text();//用户id
        var probation = $(this).parents('tr').find('input').val();//标准薪资
        var achievements = $(this).parents('tr').find('.salary_basic1').val();//基本薪资比
        var basic = $(this).parents('tr').find('.salary_basic2').val();//绩效薪资比
        $.ajax({
            type: "post",
            url: "{:U('Salary/salary_add')}", //url
            data: {'account_id':salary_aid,'standard_salary':probation,'basic_salary':achievements,'performance_salary':basic,'status':count,'type':type},
            dataType: "json", //数据格式
            success: function (data) {
               if(data.sum==1){
                   alert(data.msg);
                   if(count==2 && type == 2){
                       $('.'+salary_aid).parent('tr').find('.salary_butt2').val("已保存");
                       $('.'+salary_aid).parent('tr').find('.salary_butt2').css('background-color','#00FF66');
                       $('.'+salary_aid).parent('tr').find('.salary_butt2').addClass('salary_butt1 salary_butt2');
                   }
                   if(count==1){
                       $('#'+salary_aid).parent('tr').find('.salary_butt3').val("已保存");
                       $('#'+salary_aid).parent('tr').find('.salary_butt3').css('background-color','#00FF66');
                       $('#'+salary_aid).parent('tr').find('.salary_butt3').addClass('salary_butt1 salary_butt3');
                   }
                   if(count==2){
                       $('#'+salary_aid).parent('tr').find('.salary_butt2').val("已编辑");
                       $('#'+salary_aid).parent('tr').find('.salary_butt2').css('background-color','#00FF66');
                       $('#'+salary_aid).parent('tr').find('.salary_butt2').addClass('salary_butt1 salary_butt2');
                   }
               }
               if(data.sum==0){
                   alert(data.msg);
               }
            }
        });
    })

    $('.salary_butt4').click(function(){
        var type = $(this).parents('tr').find('.salary_type').val();//状态s
        var status = $(this).parents('tr').find('.salary_statu').val();//判断状态
    })

</script>
