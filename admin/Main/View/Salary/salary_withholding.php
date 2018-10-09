
<!--代扣代缴 -->
<div class="box">
    <div class="box-header">
        <div class="box-tools pull-left">
            <h3 style="color:blue"><b>&nbsp;&nbsp;&nbsp;代扣代缴</h3>
            <h4 style="margin:-1.8em 0em 0em 8em">变动事项</h4>
            <select name="some" class="btn btn-info btn-sm" style="margin:-3.5em 0em 0em 20em;width:11em;" id="salary_withholding_selected">
                <option value="0" <?php if($type==0|| $type=="" ){echo 'selected';}?>>选择操作</option>
                <option value="1" onclick="salary_withholding(1)" <?php if($type==13){echo 'selected';}?>>代扣代缴变动</option>
                <option value="3" onclick="salary_withholding(3)" <?php if($type==15){echo 'selected';}?>>工会会费</option>
                <option value="2" onclick="salary_withholding(2)" <?php if($type==14){echo 'selected';}?>>其他收入变动</option>
                <option value="4" onclick="salary_withholding(4)" <?php if($type==16){echo 'selected';}?>>合并计税</option>
            </select>
        </div>
    </div><!-- /.box-header -->
    <div class="box-body">
        <div class="btn-group" id="salary_add_withholding_backcolor"><br>



                <!-- 代扣代缴变动 -->
                <div id="salary_withholding1" class="salary_add_table">
                    <div style="float: left;margin-left: 2em;">

                            <label>选择人员：</label>
                            <a href="javascript:;" class="btn btn-info btn-sm" onclick="javascript:opensearch('searchtext_3',700,160);"><i class="fa fa-search"></i> 搜索</a> (提示: 选择不到人员或基本信息不完整、错误时，请在“员工管理”->"人员管理"页面添加或编辑信息)<br><br>

                        <foreach name="withholding" item="wit">
                            <div style="font-size:13px;">
                                <div class="form-group col-md-6 viwe">
                                    <p class="fom_id">ID ：{$wit.aid} </p>
                                </div>
                                <div class="form-group col-md-6 viwe">
                                    <p>姓名 ：{$wit.nickname}</p>
                                </div>
                                <div class="form-group col-md-6 viwe">
                                    <p>部门 ：{$wit.department}</p>
                                </div>
                                <div class="form-group col-md-6 viwe">
                                    <p>岗位 ：{$wit.post_name} </p>
                                </div>
                                <div class="form-group col-md-6 viwe">
                                    <p>员工编号 ：{$wit.employee_member}</p>
                                </div>
                                <div class="form-group col-md-6 viwe">
                                    <p>入职时间 ：<?php echo date('Y-m-d',$wit['entry_time'])?> </p>
                                </div>

                            </div>

                            <table class="table table-bordered" style="margin-top:10px;">
                                <tr role="row" class="orders" >
                                    <th class="sorting" data="number" style="width:18em;">代扣代缴项目</th>
                                    <th class="sorting" data="shouru" style="width:18em;">金额</th>
                                    <th class="sorting" data="shouru" style="width:8em;">操作</th>
                                </tr>
                                <input type="hidden"  class="form-control withholding_status" value="1" />
                                <foreach name="wit.withholding" item="w">
                                    <tr class="add_withholding_list">
                                        <td><input type="text"  class="form-control withholding_project_name" value="{$w.project_name}" /></td>
                                        <td><input type="text"  class="form-control withholding_money" value="{$w.money}" /></td>
                                        <input type="hidden"  class="form-control withholding_id" value="{$w.account_id}" />
                                        <td><input type="button"  style="background-color:#00acd6;font-size:1em;" class="form-control withholding_delete" onclick="withholding_delete()" value="删除项目" /></td>
                                    </tr>
                                </foreach>
                            </table>
                        </foreach>
                            <div style="text-align:center;background-color: lightgreen;margin-top:2px;font-size:2em;padding:0.1em;cursor:pointer;" class="withholding_click">
                                +<b style="font-size:0.7em;">添加项目</b>
                            </div><br>
                            <div style="width:12em;margin:1em auto 3em auto;">
                                <input type="button" class="form-control salary_withholding_butt" value="保 存" style="background-color:#00acd6;font-size:1.2em;height: 2.5em;" />
                            </div>

                    </div>
                </div>



                <!-- 其他收入变动-->
                <div id="salary_withholding2" class="salary_add_table" style="display: none">
                    <div style="float: left;margin-left: 2em;">

                        <label>选择人员：</label>
                        <a href="javascript:;" class="btn btn-info btn-sm" onclick="javascript:opensearch('searchtext_3',700,160);"><i class="fa fa-search"></i> 搜索</a> (提示: 选择不到人员或基本信息不完整、错误时，请在“员工管理”->"人员管理"页面添加或编辑信息)<br><br>

                        <foreach name="withholding" item="wit">
                            <div style="font-size:13px;">
                                <div class="form-group col-md-6 viwe">
                                    <p class="fom_id">ID ：{$wit.aid} </p>
                                </div>
                                <div class="form-group col-md-6 viwe">
                                    <p>姓名 ：{$wit.nickname}</p>
                                </div>
                                <div class="form-group col-md-6 viwe">
                                    <p>部门 ：{$wit.department}</p>
                                </div>
                                <div class="form-group col-md-6 viwe">
                                    <p>岗位 ：{$wit.post_name} </p>
                                </div>
                                <div class="form-group col-md-6 viwe">
                                    <p>员工编号 ：{$wit.employee_member}</p>
                                </div>
                                <div class="form-group col-md-6 viwe">
                                    <p>入职时间 ：<?php echo date('Y-m-d',$wit['entry_time'])?> </p>
                                </div>

                            </div>

                            <table class="table table-bordered" style="margin-top:10px;">
                                <tr role="row" class="orders" >
                                    <th class="sorting" data="number" style="width:18em;">其他收入来源</th>
                                    <th class="sorting" data="shouru" style="width:18em;">金额</th>
                                    <th class="sorting" data="shouru" style="width:8em;">操作</th>
                                    <input type="hidden"  class="form-control withholding_status" value="2" />
                                </tr>
                                <foreach name="wit.income" item="inc">
                                    <tr class="add_withholding_list">
                                        <td><input type="text"  class="form-control withholding_project_name" value="{$inc.income_name}" /></td>
                                        <td><input type="text"  class="form-control withholding_money" value="{$inc.income_money}" /></td>
                                        <input type="hidden"  class="form-control withholding_id" value="{$inc.account_id}" />
                                        <td><input type="button"  style="background-color:#00acd6;font-size:1em;" class="form-control withholding_delete" onclick="withholding_delete()" value="删除项目" /></td>
                                    </tr>
                                </foreach>
                            </table>
                        </foreach>
                        <div style="text-align:center;background-color: lightgreen;margin-top:2px;font-size:2em;padding:0.1em;cursor:pointer;" class="withholding_click">
                            +<b style="font-size:0.7em;">添加项目</b>
                        </div><br>
                        <div style="width:12em;margin:1em auto 3em auto;">
                            <input type="button" class="form-control salary_withholding_butt" value="保 存" style="background-color:#00acd6;font-size:1.2em;height: 2.5em;" />
                        </div>

                    </div>
                </div>

                <!-- 工会会费-->
            <div id="salary_withholding3" style="display:none">
                <div style="float: left;margin-left: 2em;">
                    <label>选择人员：</label>
                    <a href="javascript:;" class="btn btn-info btn-sm" onclick="javascript:opensearch('searchtext_4',700,160);"><i class="fa fa-search"></i> 搜索</a> (提示: 选择不到人员或基本信息不完整、错误时，请在“员工管理”->"人员管理"页面添加或编辑信息)<br><br>

                    <table class="table table-bordered dataTable fontmini" id="tablelist" style="margin-top:10px;">
                        <tr role="row" class="orders" >
                            <th class="sorting" data="op_id"  style="width:6em;">ID</th>
                            <th class="sorting" data="group_id" style="width:8em;">员工姓名</th>
                            <th class="sorting" data="group_id" style="width:8em;">员工编号</th>
                            <th class="sorting" data="group_id" style="width:10em;">部门</th>
                            <th class="sorting" data="project" style="width:12em;">岗位</th>
                            <th class="sorting" data="number" style="width:12em;">原工会会费</th>
                            <th class="sorting" data="shouru" style="width:12em;">现工会会费</th>
                            <th class="sorting" data="shouru" style="width:8em;">操作</th>
                            </if>

                        </tr>
                        <foreach name="withhold" item="inf">
                        <tr>
                            <td class="salary_aid" >{$inf.aid}</td>
                            <td>{$inf.nickname}</td>
                            <td>{$inf.employee_member}</td>
                            <td>{$inf.department}</td>
                            <td>{$inf.post_name}</td>
                            <td>{$inf['Labour']['Labour_money']}</td>
                            <td class="salary_basic">
                                <input type="text" class="form-control salary_basic2" value="" />
                            </td>
                            <td class="salary_entry">
                                <input type="button" class="form-control salary_button22" value="添加" style="background-color:#00acd6;font-size:1em;" />
                            </td>
                        </tr>
                        </foreach>

                    </table>

                </div>
            </div>


            <div id="salary_withholding4" style="display:none">
            <div style="float: left;margin-left: 2em;">
                <label>选择人员：</label>
                <a href="javascript:;" class="btn btn-info btn-sm" onclick="javascript:opensearch('searchtext_4',700,160);"><i class="fa fa-search"></i> 搜索</a> (提示: 选择不到人员或基本信息不完整、错误时，请在“员工管理”->"人员管理"页面添加或编辑信息)<br><br>

                <table class="table table-bordered dataTable fontmini" id="tablelist" style="margin-top:10px;">
                    <tr role="row" class="orders" >
                        <th class="sorting" data="op_id"  style="width:6em;">ID</th>
                        <th class="sorting" data="group_id" style="width:8em;">员工姓名</th>
                        <th class="sorting" data="group_id" style="width:8em;">员工编号</th>
                        <th class="sorting" data="group_id" style="width:10em;">部门</th>
                        <th class="sorting" data="project" style="width:12em;">岗位</th>
                        <th class="sorting" data="number" style="width:12em;">原工合并计税</th>
                        <th class="sorting" data="shouru" style="width:12em;">现工合并计税</th>
                        <th class="sorting" data="shouru" style="width:8em;">操作</th>
                        </if>

                    </tr>
                    <foreach name="withhold" item="inf">
                        <tr>
                            <td class="salary_aid" >{$inf.aid}</td>
                            <td>{$inf.nickname}</td>
                            <td>{$inf.employee_member}</td>
                            <td>{$inf.department}</td>
                            <td>{$inf.post_name}</td>
                            <td>{$inf['Labour']['merge_counting']}</td>
                            <td class="salary_basic">
                                <input type="text" class="form-control salary_basic2" value="" />
                            </td>
                            <input type="hidden" class="salary_basic3" value="1" />
                            <td class="salary_entry">
                                <input type="button" class="form-control salary_button22" value="添加" style="background-color:#00acd6;font-size:1em;" />
                            </td>
                        </tr>
                    </foreach>

                </table>

            </div>
        </div>


        </div><!-- /.box -->
    </div>
</div>
<script>
    var stat = <?php echo $stau;?>;
    if(stat==5){
        $('#salary_withholding3').show();
        $('#salary_withholding1').hide();
        $('#salary_withholding2').hide();
    }

</script>