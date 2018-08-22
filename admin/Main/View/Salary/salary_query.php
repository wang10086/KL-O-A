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
                                <div class="btn-group" id="salary_add_backcolor"><br>

                                    <!-- 引用 入职 转正 调岗 离职 调薪 -->
                                    <include file="salary_include1" />

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
