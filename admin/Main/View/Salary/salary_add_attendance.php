<include file="Index:header2" />

            <aside class="right-side">
                <!-- Content Header (Page header) -->
                <section class="content-header">
                    <h1>
                        考勤数据录入
                    </h1>

                    <ol class="breadcrumb">
                        <li><a href="{:U('Index/index')}"><i class="fa fa-home"></i> 首页</a></li>
                        <li><a href="{:U('Salary/salaryindex')}"><i class="fa fa-gift"></i> 人力资源</a></li>
                        <li class="active">考勤数据录入</li>
                    </ol>

                </section>

                <!-- Main content -->
                <section class="content">
                    <div class="row">
                        <div class="col-xs-12">
                            <div class="box">
                                <div class="box-header">

                                    <div class="box-tools pull-left">
                                       <h4>考勤数据添加</h4>
                    
                                    </div>
                                </div><!-- /.box-header -->
                                <div class="box-body">
                                <div class="btn-group" id="salary_add_backcolor">
                                    <!-- 数据添加 -->
                                    <div style="float: left;margin-left: 2em;">
                                        <label>选择人员：</label>
                                        <a href="javascript:;" class="btn btn-info btn-sm" onclick="javascript:opensearch('searchtext',700,160);"><i class="fa fa-search"></i> 搜索</a> (提示: 选择不到人员或基本信息不完整、错误时，请在“员工管理”->"人员管理"页面添加或编辑信息)<br><br>

                                        <table class="table table-bordered dataTable fontmini" id="tablelist" style="margin-top:10px;">
                                            <tr role="row" class="orders" >
                                                <th class="sorting" data="op_id"  style="width:5em;">ID</th>
                                                <th class="sorting" data="group_id" style="width:8em;">员工姓名</th>
                                                <th class="sorting" data="group_id" style="width:8em;">员工编号</th>
                                                <th class="sorting" data="group_id" style="width:8em;">员工部门</th>
                                                <th class="sorting" data="project" style="width:8em;">员工岗位</th>
                                                <th class="sorting" data="number" style="width:8em;">入职时间</th>
                                                <th class="sorting" data="number" style="width:12em;">迟到/早退(15分钟)</th>
                                                <th class="sorting" data="number" style="width:12em;">迟到/早退(30分钟)</th>
                                                <th class="sorting" data="shouru" style="width:8em;">事假</th>
                                                <th class="sorting" data="shouru" style="width:8em;">病假</th>
                                                <th class="sorting" data="shouru" style="width:8em;">旷工</th>
                                                <th class="sorting" data="shouru" style="width:8em;">扣款</th>
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
                                                    <td><?php echo date('Y-m-d',$row['entry_time'])?></td>
                                                    <td>&nbsp;&nbsp;&nbsp;<input type="text"></td>
                                                    <td>&nbsp;&nbsp;&nbsp;<input type="text"></td>
                                                    <td>&nbsp;&nbsp;&nbsp;<input type="text"></td>
                                                    <td>&nbsp;&nbsp;&nbsp;<input type="text"></td>
                                                    <td>&nbsp;&nbsp;&nbsp;<input type="text"></td>
                                                    <td>&nbsp;&nbsp;&nbsp;</td>
                                                    <td>&nbsp;&nbsp;&nbsp;<input type="button" value="保存" style="background-color:#00acd6;font-size:1.5em;"></td>
                                                </tr>
                                            </foreach>
                                        </table>
                                    </div>
                                </div><!-- /.box -->
                        </div><!-- /.col -->
                     </div>

                        <div id="searchtext">
                            <script src="__HTML__/js/public.js?v=1.0.6" type="text/javascript"></script>

                            <form action="{:U('Salary/salary_add_attendance')}" method="post" id="searchform">

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
<script> var h = 1;
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

</script>
