
<!--岗位薪酬变动 -->
<div class="box box-warning">
    <div class="box-header">
        <div class="box-tools pull-left">
            <h3 style="color:blue"><b>岗位薪酬变动</h3>
            <h4 style="margin:-1.8em 0em 0em 10em">变动事项</h4>
            <select name="some" class="btn btn-info btn-sm" style="margin:-3.5em 0em 0em 22em;width:11em;" id="salary_id_hidden" onchange="salary_entry($(this).val())">
                <option value="0" >选择操作</option>
                <option value="1" <?php if($type==1 || $type==0 || $type==""){echo 'selected';}?>>入职</option>
                <option value="2" <?php if($type==2){echo 'selected';}?>>转正</option>
                <option value="3" <?php if($type==3){echo 'selected';}?>>调岗</option>
                <option value="4" <?php if($type==4){echo 'selected';}?>>离职</option>
                <option value="5"  <?php if($type==5){echo 'selected';}?>>调薪</option>
            </select>

        </div>
    </div><!-- /.box-header -->
    <div class="box-body">
        <div class="btn-group" id="salary_add_backcolor"><br>

            <!-- 引用 入职 转正 调岗 离职 调薪 -->

            <!-- 入职 -->
            <div id="salary_entry" >
                <div style="float: left;margin-left: 2em;">
                    <label>选择人员：</label>
                    <a href="javascript:;" class="btn btn-info btn-sm" onclick="javascript:opensearch('searchtext',700,180);autocomp('nickname');"><i class="fa fa-search"></i> 搜索</a> (提示: 选择不到人员或基本信息不完整、错误时，请在“员工管理”->"人员管理"页面添加或编辑信息)<br><br>

                    <table class="table table-bordered dataTable fontmini" id="tablelist" style="margin-top:10px;">
                        <tr role="row" class="orders">
                            <th class="sorting" data="op_id"  style="width:6em;">ID</th>
                            <th class="sorting" data="group_id" style="width:10em;">员工姓名</th>
                            <th class="sorting" data="group_id" style="width:10em;">员工编号</th>
                            <th class="sorting" data="group_id" style="width:10em;">员工部门</th>
                            <th class="sorting" data="project" style="width:12em;">员工岗位</th>
                            <th class="sorting" data="number" style="width:8em;">入职时间</th>
                            <th class="sorting" data="number" style="width:10em;">试用期岗位薪酬标准</th>
                            <th class="sorting" data="shouru" style="width:16em;">试用期基效比</th>
                            <th class="sorting" data="shouru" style="width:8em;">操作</th>
                            </if>
                        </tr>

                        <foreach name="lists" item="row">
                            <tr>
                                <td class="salary_aid">{$row.aid}</td>
                                <td>{$row.nickname}</td>
                                <td>{$row.employee_member}</td>
                                <td>{$row.department}</td>
                                <td>{$row.post_name}</td>
                                <td><?php echo date('Y-m-d',$row['entry_time'])?></td>
                                <td class="salary_probation"><input type="text" class="form-control" value="{$row.standard_salary}" /></td>
                                <td class="salary_basic" style="text-align: center">
                                    <input type="text" style="width:5em;float:left;" class="form-control salary_basic1" value="{$row.basic_salary}" placeholder="例 : 7"/>
                                    :
                                    <input type="text" style="width:5em;float:right;" class="form-control salary_basic2" value="{$row.performance_salary}" placeholder="例 : 3" />
                                </td>
                                <td class="salary_entry">
                                    <input type="hidden" class="salary_type" value="1" />
                                    <input type="button" class="form-control salary_butt1" value="添加" style="background-color:#00acd6;font-size:1em;" />
                                </td>
                            </tr>
                        </foreach>
                    </table>
                    <div class="box-footer clearfix">
                        <div class="pagestyle">{$pages}</div>
                    </div>
                </div>
            </div>



            <!--转正-->

            <div id="salary_formal" style="display:none">
                <div style="float: left;margin-left: 2em;">
                    <label>选择人员：</label>
                    <a href="javascript:;" class="btn btn-info btn-sm" onclick="javascript:opensearch('searchtext',700,180);autocomp('nickname');"><i class="fa fa-search"></i> 搜索</a> (提示: 选择不到人员或基本信息不完整、错误时，请在“员工管理”->"人员管理"页面添加或编辑信息)<br><br>

                    <table class="table table-bordered dataTable fontmini" id="tablelist" style="margin-top:10px;">
                        <tr role="row" class="orders" >
                            <th class="sorting" data="op_id"  style="width:5em;">ID</th>
                            <th class="sorting" data="group_id" style="width:6em;">员工姓名</th>
                            <th class="sorting" data="group_id" style="width:6em;">员工编号</th>
                            <th class="sorting" data="group_id" style="width:6em;">员工部门</th>
                            <th class="sorting" data="project" style="width:8em;">员工岗位</th>
                            <th class="sorting" data="number" style="width:6em;">入职时间</th>
                            <th class="sorting" data="number" style="width:12em;">试用期岗位薪酬标准</th>
                            <th class="sorting" data="shouru" style="width:10em;">试用期基效比</th>
                            <th class="sorting" data="shouru" style="width:12em;">转正后期岗位薪酬标准</th>
                            <th class="sorting" data="shouru" style="width:16em;">转正后期基效比</th>
                            <th class="sorting" data="shouru" style="width:8em;">操作</th>
                            </if>

                        </tr>

                        <foreach name="lists" item="row">
                            <tr>
                                <td class="salary_aid">{$row.aid}</td>
                                <td>{$row.nickname}</td>
                                <td>{$row.employee_member}</td>
                                <td>{$row.department}</td>
                                <td>{$row.post_name}</td>
                                <td><?php echo date('Y-m-d',$row['entry_time'])?></td>
                                <td>{$row.standard_salary}</td>
                                <td>{$row.basic_salary} <?php if(!empty($row['basic_salary'])){echo ":";} ?> {$row.performance_salary} </td>
                                <td><input type="text" name="name" class="form-control" /></td>
                                <td class="salary_basic" style="text-align: center">
                                    <input type="text" style="width:5em;float:left;" class="form-control salary_basic1" value="{$row.basic_salary}" />
                                    :
                                    <input type="text" style="width:5em;float:right;" class="form-control salary_basic2" value="{$row.performance_salary}" />
                                </td>
                                <td class="salary_entry">
                                    <input type="hidden" class="salary_type" value="2"/>
                                    <input type="button" class="form-control salary_butt1" value="添加" style="background-color:#00acd6;font-size:1em;" />
                                </td>
                            </tr>
                        </foreach>

                    </table>
                    <div class="box-footer clearfix">
                        <div class="pagestyle">{$pages}</div>
                    </div>
                </div>
            </div>


            <!--调岗-->
            <div id="salary_adjustment" style="display:none">
                <div style="float: left;margin-left: 2em;">
                    <label>选择人员：</label>
                    <a href="javascript:;" class="btn btn-info btn-sm" onclick="javascript:opensearch('searchtext',700,180);autocomp('nickname');"><i class="fa fa-search"></i> 搜索</a> (提示: 选择不到人员或基本信息不完整、错误时，请在“员工管理”->"人员管理"页面添加或编辑信息)<br><br>

                    <table class="table table-bordered dataTable fontmini" id="tablelist" style="margin-top:10px;">
                        <tr role="row" class="orders" >
                            <th class="sorting" data="op_id"  style="width:5em;">ID</th>
                            <th class="sorting" data="group_id" style="width:6em;">员工姓名</th>
                            <th class="sorting" data="group_id" style="width:5em;">员工编号</th>
                            <th class="sorting" data="group_id" style="width:6em;">原部门</th>
                            <th class="sorting" data="project" style="width:8em;">原岗位</th>
                            <th class="sorting" data="number" style="width:12em;">现部门</th>
                            <th class="sorting" data="number" style="width:12em;">现岗位</th>
                            <th class="sorting" data="shouru" style="width:8em;">原岗位薪酬标准</th>
                            <th class="sorting" data="shouru" style="width:8em;">原基效比</th>
                            <th class="sorting" data="shouru" style="width:10em;">现岗位薪酬标准</th>
                            <th class="sorting" data="shouru" style="width:18em;">现基效比</th>
                            <th class="sorting" data="shouru" style="width:8em;">操作</th>
                            </if>

                        </tr>
                        <foreach name="lists" item="row">
                            <tr>
                                <td id ="salary_adjustment_<?php echo $row['aid'];?>">{$row.aid}</td>
                                <td>{$row.nickname}</td>
                                <td>{$row.employee_member}</td>
                                <td>{$row.department}</td>
                                <td>{$row.post_name}</td>
                                <input type="hidden" name="aid" class="form-control salary_sid" value="{$row.aid}"/>
                                <td>
                                    <select class="form-control salary_current_department">
                                        <foreach name="department" item="dep">
                                            <option value ="{$dep.id}" <?php if ($dep['department']==$row['department']) echo 'selected'; ?>>{$dep.department}</option>
                                        </foreach>
                                    </select>
                                </td>
                                <td>
                                    <select class="form-control salary_present_post">
                                        <foreach name="posts" item="p">
                                            <option value ="{$p.id}" <?php if ($p['post_name']==$row['post_name']) echo 'selected'; ?>>{$p.post_name}</option>
                                        </foreach>
                                    </select>
                                </td>
                                <td>{$row.standard_salary}</td>
                                <td>{$row.basic_salary} <?php if(!empty($row['basic_salary'])){echo ":";} ?> {$row.performance_salary} </td>
                                <td><input type="text" class="form-control salary_present_salary" /></td>
                                <td class="salary_basic" style="text-align: center">
                                    <input type="text" style="width:5em;float:left;" class="form-control salary_basic1" value="{$row.basic_salary}" />
                                    :
                                    <input type="text" style="width:5em;float:right;" class="form-control salary_basic2" value="{$row.performance_salary}" />
                                </td>
                                <td class="salary_entry">
                                    <input type="hidden" class="salary_status" value="3"/>
                                    <input type="button" class="form-control salary_adjustment_butt4" value="添加" style="background-color:#00acd6;font-size:1em;" />
                                </td>
                            </tr>
                        </foreach>
                    </table>
                    <div class="box-footer clearfix">
                        <div class="pagestyle">{$pages}</div>
                    </div>
                </div>
            </div>


            <!--离职-->

            <div id="salary_quit" style="display:none">
                <div style="float: left;margin-left: 2em;">
                    <label>选择人员：</label>
                    <a href="javascript:;" class="btn btn-info btn-sm" onclick="javascript:opensearch('searchtext',700,180);autocomp('nickname');"><i class="fa fa-search"></i> 搜索</a> (提示: 选择不到人员或基本信息不完整、错误时，请在“员工管理”->"人员管理"页面添加或编辑信息)<br><br>

                    <table class="table table-bordered dataTable fontmini" id="tablelist" style="margin-top:10px;">
                        <tr role="row" class="orders" >
                            <th class="sorting" data="op_id"  style="width:9em;">ID</th>
                            <th class="sorting" data="group_id" style="width:12em;">员工姓名</th>
                            <th class="sorting" data="group_id" style="width:12em;">员工编号</th>
                            <th class="sorting" data="group_id" style="width:12em;">部门</th>
                            <th class="sorting" data="project" style="width:12em;">岗位</th>
                            <th class="sorting" data="number" style="width:12em;">岗位薪酬标准</th>
                            <th class="sorting" data="number" style="width:16em;">基效比</th>
                            <th class="sorting" data="shouru" style="width:10em;">离职日期</th>
                            <th class="sorting" data="shouru" style="width:9em;">操作</th>

                        </tr>

                        <foreach name="lists" item="row">
                            <tr>
                                <td>{$row.aid}</td>
                                <td>{$row.nickname}</td>
                                <td>{$row.employee_member}</td>
                                <td>{$row.department}</td>
                                <td>{$row.post_name}</td>
                                <td>{$row.standard_salary}</td>
                                <td>{$row.basic_salary} <?php if(!empty($row['basic_salary'])){echo ":";} ?> {$row.performance_salary} </td>
                                <td> <input type="date" name="month" class="form-control salary_monthly" placeholder="月份" style="width:16em; margin-right:10px;"/></td>
                                <input type="hidden" name="aid" class="form-control salary_sid" value="{$row.aid}"/>
                                <input type="hidden" class="salary_status" value="4"/>
                                <td><input type="button" class="form-control salary_adjustment_butt4" value="添加" style="background-color:#00acd6;font-size:1em;" /></td>
                            </tr>
                        </foreach>

                    </table>
                    <div class="box-footer clearfix">
                        <div class="pagestyle">{$pages}</div>
                    </div>
                </div>
            </div>


            <!--调薪-->

            <div id="salary_change" style="display:none">
                <div style="float: left;margin-left: 2em;">
                    <label>选择人员：</label>
                    <a href="javascript:;" class="btn btn-info btn-sm" onclick="javascript:opensearch('searchtext',700,180);autocomp('nickname');"><i class="fa fa-search"></i> 搜索</a> (提示: 选择不到人员或基本信息不完整、错误时，请在“员工管理”->"人员管理"页面添加或编辑信息)<br><br>

                    <table class="table table-bordered dataTable fontmini" id="tablelist" style="margin-top:10px;">
                        <tr role="row" class="orders" >
                            <th class="sorting" data="op_id"  style="width:6em;">ID</th>
                            <th class="sorting" data="group_id" style="width:8em;">员工姓名</th>
                            <th class="sorting" data="group_id" style="width:8em;">员工编号</th>
                            <th class="sorting" data="group_id" style="width:10em;">部门</th>
                            <th class="sorting" data="project" style="width:12em;">岗位</th>
                            <th class="sorting" data="number" style="width:12em;">原岗位薪酬标准</th>
                            <th class="sorting" data="number" style="width:8em;">原基效比</th>
                            <th class="sorting" data="shouru" style="width:12em;">现岗位薪酬标准</th>
                            <th class="sorting" data="number" style="width:16em;">现基效比</th>
                            <th class="sorting" data="shouru" style="width:8em;">操作</th>
                            </if>

                        </tr>

                        <foreach name="lists" item="row">
                            <tr>
                                <td class="salary_aid" >{$row.aid}</td>
                                <td>{$row.nickname}</td>
                                <td>{$row.employee_member}</td>
                                <td>{$row.department}</td>
                                <td>{$row.post_name}</td>
                                <td>{$row.standard_salary}</td>
                                <td>{$row.basic_salary} <?php if(!empty($row['basic_salary'])){echo ":";} ?> {$row.performance_salary} </td>
                                <td class="salary_probation"><input type="text" class="form-control" value="{$row.standard_salary}" /></td>
                                <td class="salary_basic" style="text-align: center">
                                    <input type="text" style="width:5em;float:left;" class="form-control salary_basic1" value="{$row.basic_salary}" />
                                    :
                                    <input type="text" style="width:5em;float:right;" class="form-control salary_basic2" value="{$row.performance_salary}" />
                                </td>
                                <td class="salary_entry">
                                    <input type="hidden" class="salary_type" value="5"/>
                                    <input type="button" class="form-control salary_butt1" value="添加" style="background-color:#00acd6;font-size:1em;" />
                                </td>
                            </tr>
                        </foreach>

                    </table>
                    <div class="box-footer clearfix">
                        <div class="pagestyle">{$pages}</div>
                    </div>
                </div>
            </div>


        </div><!-- /.box -->
    </div>
</div>
<script>
    var count1 =0;
    $('.salary_basic2').click(function(){
        count1++;
        if((count1%2) ==1){
            var html = '<div><h6 style="color:red;width:40em;" class="add111"><b>第一个空格是基本工资比率; 第二空格是绩效工资比率;总共10;例如 7:3</b></h6></div>';
            $(this).parents('table').after(html);
        }else{
            $('.add111').remove();
        }

    })
    $('.salary_basic1').click(function(){
        count1++;
        if((count1%2) ==1){
            var html = '<div><h6 style="color:red;width:40em;" class="add111"><b>第一个空格是基本工资比率; 第二空格是绩效工资比率;总共10;例如 7:3</b></h6></div>';
            $(this).parents('table').after(html);
        }else{
            $('.add111').remove();
        }

    })
</script>
