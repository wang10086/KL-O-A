<include file="Index:header2" />

            <aside class="right-side">
                <!-- Content Header (Page header) -->
                <section class="content-header">
                    <h1>
                        人力资源数据录入
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
                                        <select name="some" class="btn btn-info btn-sm" style="margin:-3.5em 0em 0em 22em;" onchange="salary_entry($(this).val())">
                                            <option value="0">选择操作</option>
                                            <option value="1">入职</option>
                                            <option value="2">转正</option>
                                            <option value="3">调岗</option>
                                            <option value="4">离职</option>
                                            <option value="5">调薪</option>
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
                                                    <th class="sorting" data="op_id"  style="width:8em;">ID</th>
                                                    <th class="sorting" data="group_id" style="width:10em;">员工姓名</th>
                                                    <th class="sorting" data="group_id" style="width:10em;">员工编号</th>
                                                    <th class="sorting" data="group_id" style="width:10em;">员工部门</th>
                                                    <th class="sorting" data="project" style="width:10em;">员工岗位</th>
                                                    <th class="sorting" data="number" style="width:10em;">入职时间</th>
                                                    <th class="sorting" data="number" style="width:20em;">试用期岗位薪酬标准</th>
                                                    <th class="sorting" data="shouru" style="width:20em;">试用期基效比</th>
                                                    <th class="sorting" data="shouru" style="width:8em;">操作</th>
                                                    </if>

                                                </tr>
                                                <?php if(count($list)=="0" ||count($list)=="" ){?>
                                                    <tr>
                                                        <td></td>
                                                        <td></td>
                                                        <td></td>
                                                        <td></td>
                                                        <td></td>
                                                        <td></td>
                                                        <td>&nbsp;&nbsp;&nbsp;<input type="text"></td>
                                                        <td>&nbsp;&nbsp;&nbsp;<input type="text"></td>
                                                        <td>&nbsp;&nbsp;&nbsp;<input type="button" value="保存" style="background-color:#00acd6;font-size:1.5em;"></td>
                                                    </tr>
                                                <?php }?>

                                                <foreach name="list" item="row">
                                                    <tr>
                                                        <td>{$row.aid}</td>
                                                        <td>{$row.nickname}</td>
                                                        <td>{$row.employee_member}</td>
                                                        <td>{$row.department}</td>
                                                        <td>{$row.post_name}</td>
                                                        <td><?php echo date('Y-m-d',$row['entry_time'])?></td>
                                                        <td>&nbsp;&nbsp;&nbsp;<input type="text"></td>
                                                        <td>&nbsp;&nbsp;&nbsp;<input type="text"></td>
                                                        <td>&nbsp;&nbsp;&nbsp;<input type="button" value="保存" style="background-color:#00acd6;font-size:1.5em;"></td>
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
                                                    <th class="sorting" data="shouru" style="width:8em;">操作</th>
                                                    </if>

                                                </tr>
                                                <?php if(count($list)=="0" ||count($list)=="" ){?>
                                                    <tr>
                                                        <td></td>
                                                        <td></td>
                                                        <td></td>
                                                        <td></td>
                                                        <td></td>
                                                        <td></td>
                                                        <td></td>
                                                        <td></td>
                                                        <td>&nbsp;&nbsp;&nbsp;<input type="text"></td>
                                                        <td>&nbsp;&nbsp;&nbsp;<input type="text"></td>
                                                        <td>&nbsp;&nbsp;&nbsp;<input type="button" value="保存" style="background-color:#00acd6;font-size:1.5em;"></td>
                                                    </tr>
                                                <?php }?>
                                                <foreach name="list" item="row">
                                                    <tr>
                                                        <td>{$row.aid}</td>
                                                        <td>{$row.nickname}</td>
                                                        <td>{$row.employee_member}</td>
                                                        <td>{$row.department}</td>
                                                        <td>{$row.post_name}</td>
                                                        <td><?php echo date('Y-m-d',$row['entry_time'])?></td>
                                                        <td>{$row.aid}</td>
                                                        <td>{$row.aid}</td>
                                                        <td>&nbsp;&nbsp;&nbsp;<input type="text"></td>
                                                        <td>&nbsp;&nbsp;&nbsp;<input type="text"></td>
                                                        <td>&nbsp;&nbsp;&nbsp;<input type="button" value="保存" style="background-color:#00acd6;font-size:1.5em;"></td>
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
                                                <?php if(count($list)=="0" ||count($list)=="" ){?>
                                                <tr>
                                                    <td></td>
                                                    <td></td>
                                                    <td></td>
                                                    <td></td>
                                                    <td></td>
                                                    <td >&nbsp;&nbsp;&nbsp;<input type="text"></td>
                                                    <td>&nbsp;&nbsp;&nbsp;<input type="text"></td>
                                                    <td></td>
                                                    <td></td>
                                                    <td>&nbsp;&nbsp;&nbsp;<input type="text"></td>
                                                    <td>&nbsp;&nbsp;&nbsp;<input type="text"></td>
                                                    <td>&nbsp;&nbsp;&nbsp;<input type="button" value="保存" style="background-color:#00acd6;font-size:1.5em;"></td>
                                                </tr>
                                                <?php }?>
                                                <foreach name="list" item="row">
                                                    <tr>
                                                        <td>{$row.aid}</td>
                                                        <td>{$row.nickname}</td>
                                                        <td>{$row.employee_member}</td>
                                                        <td></td>
                                                        <td></td>
                                                        <td >&nbsp;&nbsp;&nbsp;<input type="text"></td>
                                                        <td>&nbsp;&nbsp;&nbsp;<input type="text"></td>
                                                        <td></td>
                                                        <td></td>
                                                        <td>&nbsp;&nbsp;&nbsp;<input type="text"></td>
                                                        <td>&nbsp;&nbsp;&nbsp;<input type="text"></td>
                                                        <td>&nbsp;&nbsp;&nbsp;<input type="button" value="保存" style="background-color:#00acd6;font-size:1.5em;"></td>
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
                                                <?php if(count($list)=="0" ||count($list)=="" ){?>
                                                    <tr>
                                                        <td></td>
                                                        <td></td>
                                                        <td></td>
                                                        <td></td>
                                                        <td></td>
                                                        <td></td>
                                                        <td></td>
                                                        <td>&nbsp;&nbsp;&nbsp;<input type="date"></td>
                                                        <td>&nbsp;&nbsp;&nbsp;<input type="button" value="保存" style="background-color:#00acd6;font-size:1.5em;"></td>
                                                    </tr>
                                                <?php }?>
                                                <foreach name="list" item="row">
                                                    <tr>
                                                        <td>{$row.aid}</td>
                                                        <td>{$row.nickname}</td>
                                                        <td>{$row.employee_member}</td>
                                                        <td>{$row.department}</td>
                                                        <td>{$row.post_name}</td>
                                                        <td></td>
                                                        <td></td>
                                                        <td>&nbsp;&nbsp;&nbsp;<input type="date"></td>
                                                        <td>&nbsp;&nbsp;&nbsp;<input type="button" value="保存" style="background-color:#00acd6;font-size:1.5em;"></td>
                                                    </tr>
                                                </foreach>


                                            </table>
                                        </div>
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
                                                <?php if(count($list)=="0" ||count($list)=="" ){?>
                                                    <tr>
                                                        <td></td>
                                                        <td></td>
                                                        <td></td>
                                                        <td></td>
                                                        <td></td>
                                                        <td></td>
                                                        <td></td>
                                                        <td>&nbsp;&nbsp;&nbsp;<input type="text"></td>
                                                        <td>&nbsp;&nbsp;&nbsp;<input type="text"></td>
                                                        <td>&nbsp;&nbsp;&nbsp;<input type="button" value="保存" style="background-color:#00acd6;font-size:1.5em;"></td>
                                                    </tr>
                                                <?php }?>
                                                <foreach name="list" item="row">
                                                    <tr>
                                                        <td>{$row.aid}</td>
                                                        <td>{$row.nickname}</td>
                                                        <td>{$row.employee_member}</td>
                                                        <td>{$row.department}</td>
                                                        <td>{$row.post_name}</td>
                                                        <td></td>
                                                        <td></td>
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

                            <form action="{:U('Salary/salary_add')}" method="post" id="searchform">

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
                                    <input type="hidden" class="form-control" name="type" value="salary">
                                    <input type="text" class="form-control" name="departmen" placeholder="部门">
                                </div>
                                <div class="form-group col-md-3">
                                    <input type="text" class="form-control" name="post" placeholder="岗位">
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
