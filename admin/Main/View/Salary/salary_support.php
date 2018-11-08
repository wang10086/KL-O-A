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
                                            <a href="{:U('Salary/salary_query')}" class="btn btn-sm btn-danger"><i class="fa fa-plus"></i> 添加扶植信息</a>
                                        </if>

                                        <a href="javascript:;" class="btn btn-info btn-sm" onclick="javascript:opensearch('searchtext',700,160);"><i class="fa fa-search"></i> 搜索</a>
                                    </div>
                                </div><!-- /.box-header -->
                                <div class="box-body">


                                    <table class="table table-bordered dataTable fontmini" id="tablelist" style="margin-top:8px;">
                                        <tr role="row" class="orders" >
                                            <th class="sorting" data="op_id">ID</th>
                                            <th class="sorting" data="group_id">员工姓名</th>
                                            <th class="sorting" data="group_id">员工编码</th>
                                            <th class="sorting" data="group_id">员工岗位</th>
                                            <th class="sorting" data="group_id">员工部门</th>
                                            <th class="sorting" data="group_id">扶植开始时间</th>
                                            <th class="sorting" data="group_id">扶植结束时间</th>

                                        </tr>
                                        <!--                                        <foreach name="info" item="info">-->
                                        <tr>
                                            <td></td>
                                            <td></td>
                                            <td></td>
                                            <td></td>
                                            <td></td>
                                            <td><input type="text"></td>
                                            <td></td>

                                        </tr>
                                        <!--                                        </foreach>-->
                                    </table>
<!--                                -->
<!--                                    <table class="table table-bordered dataTable fontmini" id="tablelist" style="margin-top:8px;">-->
<!--                                        <tr role="row" class="orders" >-->
<!--                                            <th class="sorting" data="op_id">ID</th>-->
<!--                                            <th class="sorting" data="group_id">员工姓名</th>-->
<!--                                            <th class="sorting" data="group_id">员工编码</th>-->
<!--                                            <th class="sorting" data="group_id">员工岗位</th>-->
<!--                                            <th class="sorting" data="group_id">员工部门</th>-->
<!--                                            <th class="sorting" data="group_id">扶植开始时间</th>-->
<!--                                            <th class="sorting" data="group_id">扶植结束时间</th>-->
<!--                                            -->
<!--                                        </tr>-->
<!---->
<!--<!--                                        <foreach name="info" item="info">-->-->
<!---->
<!--                                            <tr>-->
<!--                                                <td></td>-->
<!--                                                <td></td>-->
<!--                                                <td></td>-->
<!--                                                <td></td>-->
<!--                                                <td></td>-->
<!--                                                <td></td>-->
<!--                                                <td></td>-->
<!---->
<!--                                            </tr>-->
<!--<!--                                        </foreach>-->-->
<!--                                    </table>-->

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

                <form action="{:U('Salary/salaryindex')}" method="post" id="searchform">
                <div class="form-group col-md-3">
                    <input type="text" class="form-control" name="id" placeholder="ID编号">
                </div>
                    <div class="form-group col-md-3">
                        <input type="text" class="form-control" name="employee_member" placeholder="部门">
                    </div>

                <div class="form-group col-md-3">
                    <input type="text" class="form-control" name="name" placeholder="员工姓名">
                </div>
                </form>
            </div>



<include file="Index:footer2" />


<script>



</script>