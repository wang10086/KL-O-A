<include file="Index:header2" />

            <aside class="right-side">
                <!-- Content Header (Page header) -->
                <section class="content-header">
                    <h1>
                       员工考勤
                    </h1>
                    <ol class="breadcrumb">
                        <li><a href="{:U('Index/index')}"><i class="fa fa-home"></i> 首页</a></li>
                        <li><a href="{:U('Salary/salaryindex')}"><i class="fa fa-gift"></i> 人力资源</a></li>
                        <li class="active">员工考勤</li>
                    </ol>
                </section>

                <!-- Main content -->
                <section class="content">

                    <div class="row">
                        <div class="col-xs-12">
                            <div class="box">
                                <div class="box-header">
                                    <h3 class="box-title">考勤列表</h3>
                                    <div class="box-tools pull-right">
                                        <a href="{:U('Salary/salary_add_attendance')}" class="btn btn-sm btn-danger"><i class="fa fa-plus"></i> 考勤数据录入</a>
                                        <a href="javascript:;" class="btn btn-info btn-sm" onclick="javascript:opensearch('searchtext',700,160);"><i class="fa fa-search"></i> 搜索</a>
                                    </div>
                                </div><!-- /.box-header -->
                                <div class="box-body">
                                	<table class="table table-bordered dataTable fontmini" id="tablelist">
                                        <tr role="row" class="orders" >
                                        	<th>ID</th>
                                            <th>员工姓名</th>
                                            <th>员工编号</th>
                                            <th>考勤月份</th>
                                            <th>迟到/早退(15min以内次数)</th>
                                            <th>迟到/早退(15min以上次数)</th>
                                            <th>事假(天)</th>
                                            <th>病假(天)</th>
                                            <th>旷工(天)</th>
                                            <th>考勤扣款(元)</th>
                                        </tr>

                                        <foreach name="list" item="row">
                                        <tr id="salary_edtior">
                                            <td>{$row.aid}</td>
                                            <td>{$row.nickname}</td>
                                            <td>{$row.employee_member}</td>
                                            <td><?php echo date('Y-m',$row['grant_time']) ?></td>
                                            <td>{$row.late1}</td>
                                            <td>{$row.late2}</td>
                                            <td>{$row.leave_absence}</td>
                                            <td>{$row.sick_leave}</td>
                                            <td>{$row.absenteeism}</td>
                                            <td>{$row.withdrawing}</td>

                                        </tr>
                                        </foreach>		
                                        
                                    </table>
                                
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

            <form action="{:U('Salary/salary_attendance')}" method="post" id="searchform">

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
                    <input type="date" name="grant_time" class="form-control monthly" placeholder="月份" style="width:100px; margin-right:10px;"/>
                    <!--                    <input type="date" class="form-control" name="salary_time" placeholder="年月" id="nowTime">-->
                </div>

            </form>
        </div>

        <include file="Index:footer2" />


        <script type="text/javascript">
                function openform(obj){
                    art.dialog.open(obj,{
                        lock:true,
                        id:'respriv',
                        title: '权限分配',
                        width:600,
                        height:300,
                        okValue: '提交',
                        ok: function () {
                            this.iframe.contentWindow.myform.submit();
                            return false;
                        },
                        cancelValue:'取消',
                        cancel: function () {
                        }
                    });	
                }


        </script>