
<!--岗位薪酬变动 -->
<div class="box">
    <div class="box-header">
        <div class="box-tools pull-left">
            <h3 style="color:blue"><b>代扣代缴</h3>
            <h4 style="margin:-1.8em 0em 0em 10em">变动事项</h4>
            <select name="some" class="btn btn-info btn-sm" style="margin:-3.5em 0em 0em 22em;width:10em;width:11em;" id="salary_withholding_selected">
                <option value="0" <?php if($type==0|| $type=="" ){echo 'selected';}?>>选择操作</option>
                <option value="1" onclick="salary_withholding(1)" <?php if($type==13){echo 'selected';}?>>代扣代缴变动</option>
                <option value="2" onclick="salary_withholding(2)" <?php if($type==14){echo 'selected';}?>>其他收入变动</option>
            </select>
        </div>
    </div><!-- /.box-header -->
    <div class="box-body">
        <div class="btn-group" id="salary_add_backcolor"><br>


            <!-- 代扣代缴变动 -->
            <div id="salary_withholding1" >
                <div style="float: left;margin-left: 2em;">
                    <label>选择人员：</label>
                    <a href="javascript:;" class="btn btn-info btn-sm" onclick="javascript:opensearch('searchtext_3',700,160);"><i class="fa fa-search"></i> 搜索</a> (提示: 选择不到人员或基本信息不完整、错误时，请在“员工管理”->"人员管理"页面添加或编辑信息)<br><br>

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

                        <foreach name="withholding" item="row">
                            <tr>
                                <td class="salary_aid">{$row.aid}</td>
                                <td>{$row.nickname}</td>
                                <td>{$row.employee_member}</td>
                                <td>{$row.department}</td>
                                <td>{$row.post_name}</td>
                                <td><?php echo date('Y-m-d',$row['entry_time'])?></td>
                                <td class="salary_probation"><input type="text" class="form-control" value="{$row.standard_salary}" /></td>
                                <td class="salary_basic" style="text-align: center">
                                    <input type="text" style="width:5em;float:left;" class="form-control salary_basic1" value="{$row.basic_salary}" />
                                    :
                                    <input type="text" style="width:5em;float:right;" class="form-control salary_basic2" value="{$row.performance_salary}" />
                                </td>
                                <td class="salary_entry">
                                    <input type="hidden" class="salary_type" value="1"/>
                                    <input type="button" class="form-control salary_butt1" value="添加" style="background-color:#00acd6;font-size:1em;" />
                                </td>
                            </tr>
                        </foreach>
                    </table>
                    <div class="box-footer clearfix">
                        <div class="pagestyle">{$page4}</div>
                    </div>
                </div>
            </div>



            <!--其他收入变动-->

            <div id="salary_withholding2" style="display:none">
                <div style="float: left;margin-left: 2em;">
                    <label>选择人员：</label>
                    <a href="javascript:;" class="btn btn-info btn-sm" onclick="javascript:opensearch('searchtext_3',700,160);"><i class="fa fa-search"></i> 搜索</a> (提示: 选择不到人员或基本信息不完整、错误时，请在“员工管理”->"人员管理"页面添加或编辑信息)<br><br>

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

                        <foreach name="withholding" item="row">
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
                        <div class="pagestyle">{$page4}</div>
                    </div>
                </div>
            </div>




        </div><!-- /.box -->
    </div>
</div>

