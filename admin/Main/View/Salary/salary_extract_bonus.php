
<!--提成/奖金/补助-->
<div class="box">
    <div class="box-header">
        <div class="box-tools pull-left">
            <h3 style="color:blue"><b>提成/补助/奖金</h3>
            <h4 style="margin:-1.8em 0em 0em 11em">操作事项</h4>
            <select name="some" class="btn btn-info btn-sm" style="margin:-3.5em 0em 0em 23em;width:10em;" id="salary_id_hidden1" onchange="salary_hide($(this).val())">
                <option value="0" >选择操作</option>
                <option value="1" <?php if($type==6 || $type=="" || $type==0){echo 'selected';}?>>录入提成/奖金</option>
                <option value="2" <?php if($type==7){echo 'selected';}?>>变动各项补助</option>
            </select>

        </div>
    </div>
    <div class="box-body">
        <div class="btn-group"><br>

            <div id="table_salary_percentage1" >
                <div style="float: left;margin-left: 2em;">
                    <label>选择人员：</label>
                    <a href="javascript:;" class="btn btn-info btn-sm" onclick="javascript:opensearch('searchtext_1',700,180);"><i class="fa fa-search"></i> 搜索</a> (提示: 选择不到人员或基本信息不完整、错误时，请在“员工管理”->"人员管理"页面添加或编辑信息)<br><br>
                    <table class="table table-bordered"  style="margin-top:10px;">
                        <tr role="row" class="orders">
                            <th class="sorting" data="op_id"  style="width:8em;">ID</th>
                            <th class="sorting" data="group_id" style="width:12em;">员工姓名</th>
                            <th class="sorting" data="group_id" style="width:12em;">员工编号</th>
                            <th class="sorting" data="group_id" style="width:12em;">员工部门</th>
                            <th class="sorting" data="project" style="width:13em;">员工岗位</th>
                            <th class="sorting" data="number" style="width:12em;">带团补助</th>

                            <th class="sorting" data="number" style="width:12em;">其他人员提成</th>
                            <th class="sorting" data="number" style="width:12em;">奖金</th>
                            <th class="sorting" data="shouru" style="width:12em;">年终奖</th>
                            <th class="sorting" data="shouru" style="width:12em;">年终奖计税</th>
                            <th class="sorting" data="shouru" style="width:10em;">操作</th>
                        </tr>

                        <foreach name="rows" item="lst">
                            <tr>
                                <td class="salary_table_extract">{$lst.aid}</td>
                                <td>{$lst.nickname}</td>
                                <td>{$lst.employee_member}</td>
                                <td>{$lst.department}</td>
                                <td>{$lst.post_name}</td>
                                <td><input type="text" style="float:left;" class="form-control salary_bonus_extract" placeholder="带团补助" value="<?php if($lst['extract']==0 || $lst['extract']==""){echo 0;}else{echo $lst['extract'];}?>" readonly /></td>

                                <td><input type="text" style="float:left;" class="form-control salary_bonus_bonus" placeholder="其他人员提成" /></td>
                                <td><input type="text" style="float:left;" class="form-control salary_bonus1_bonus" placeholder="奖金" /></td>
                                <td><input type="text" style="float:left;" class="form-control salary_bonus_yearend" value="{$lst.annual_bonus}" /></td>
                                <td><input type="text" style="float:left;" class="form-control salary_bonus_yearendtax" value="{$lst.year_end_tax}" /></td>
                                <input type="hidden" class="status" value="1">

                                <td> <input type="button" class="form-control salary_subsidy_butt" value="添加" style="background-color:#00acd6;font-size:1em;" /></td>
                            </tr>
                        </foreach>
                    </table>
                    <div class="box-footer clearfix">
                        <div class="pagestyle">{$page2}</div>
                    </div>

                </div>
            </div>

            <div id="table_salary_percentage2" style="display:none;" >
                <div style="float: left;margin-left: 2em;">
                    <label>选择人员：</label>
                    <a href="javascript:;" class="btn btn-info btn-sm" onclick="javascript:opensearch('searchtext_1',700,180);"><i class="fa fa-search"></i> 搜索</a> (提示: 选择不到人员或基本信息不完整、错误时，请在“员工管理”->"人员管理"页面添加或编辑信息)<br><br>
                    <table class="table table-bordered" style="margin-top:10px;">
                        <tr role="row" class="orders">
                            <th class="sorting" data="op_id"  style="width:6em;">ID</th>
                            <th class="sorting" data="group_id" style="width:7em;">员工姓名</th>
                            <th class="sorting" data="group_id" style="width:7em;">员工编号</th>
                            <th class="sorting" data="group_id" style="width:7em;">员工部门</th>
                            <th class="sorting" data="project" style="width:8em;">员工岗位</th>
                            <th class="sorting" data="number" style="width:8em;">原住房补助</th>
                            <th class="sorting" data="number" style="width:11em;">现住房补助</th>
                            <th class="sorting" data="shouru" style="width:8em;">原外地补贴</th>
                            <th class="sorting" data="shouru" style="width:11em;">现外地补贴</th>
                            <th class="sorting" data="number" style="width:8em;">原电脑补贴</th>
                            <th class="sorting" data="number" style="width:12em;">现电脑补贴</th>
                            <th class="sorting" data="shouru" style="width:10em;">操作</th>

                        </tr>
                        <foreach name="rows" item="lst">
                            <tr>
                                <td class="salary_table_extract">{$lst.aid}</td>
                                <td>{$lst.nickname}</td>
                                <td>{$lst.employee_member}</td>
                                <td>{$lst.department}</td>
                                <td>{$lst.post_name}</td>
                                <td>{$lst.housing_subsidy}</td>
                                <td><input type="text" style="float:left;" class="form-control salary_bonus_extract" value="{$lst.housing_subsidy}" /></td>
                                <td>{$lst.foreign_subsidies}</td>
                                <td><input type="text" style="float:left;" class="form-control salary_bonus_bonus" value="{$lst.foreign_subsidies}" /></td>
                                <td>{$lst.computer_subsidy}</td>
                                <td><input type="text" style="float:left;" class="form-control salary_bonus_yearend" value="{$lst.computer_subsidy}" /></td>
                                <input type="hidden" class="status" value="2">
                                <td><input type="button" class="form-control salary_subsidy_butt" value="添加" style="background-color:#00acd6;font-size:1em;" /></td>
                            </tr>
                        </foreach>

                    </table>

                    <div class="box-footer clearfix">
                        <div class="pagestyle">{$page2}</div>
                    </div>

                </div>
            </div>

        </div>
    </div>
</div>