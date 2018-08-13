<include file="Index:header2" />

            <aside class="right-side">
                <!-- Content Header (Page header) -->
                <section class="content-header">
                    <h1>
                       员工考勤
                    </h1>
                    <ol class="breadcrumb">
                        <li><a href="{:U('Index/index')}"><i class="fa fa-home"></i> 首页</a></li>
                        <li><a href="{:U('ScienceRes/res')}"><i class="fa fa-gift"></i> 人力资源</a></li>
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
                                    	 <a href="javascript:;" class="btn btn-info btn-sm" onclick="javascript:opensearch('searchtext',600,160);"><i class="fa fa-search"></i> 搜索</a>
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
                                            <th>操作</th>
                                        </tr>
                                        <tr>
                                            <td>1</td>
                                            <td>风萧萧</td>
                                            <td>Z001</td>
                                            <td>2018-06</td>
                                            <td>2</td>
                                            <td>2</td>
                                            <td>3</td>
                                            <td>1.5</td>
                                            <td>2.5</td>
                                            <td>330.00</td>
                                            <td><a href="">编辑</a></td>
                                        </tr>
                                        <foreach name="list" item="row">
                                        <tr>
                                            <td>{$row.sid}</td>
                                            <td>{$row.nickname}</td>
                                            <td>{$row.employee_member}</td>
                                            <td><?php echo date('Y-m',$row['grant_time']) ?></td>
                                            <td>{$row.late1}</td>
                                            <td>{$row.late2}</td>
                                            <td>{$row.leave_absence}</td>
                                            <td>{$row.sick_leave}</td>
                                            <td>{$row.absenteeism}</td>
                                            <td>{$row.withdrawing}</td>
                                            <td><a id="attendance_edito" class="($row.sid)">编辑</a></td>
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

        <include file="Index:footer2" />
        
        <div id="searchtext">
            <form action="" method="get" id="searchform">
            <input type="hidden" name="m" value="Main">
            <input type="hidden" name="c" value="ScienceRes">
            <input type="hidden" name="a" value="res">
            <div class="form-group col-md-4">
                <input type="text" class="form-control" name="key" placeholder="关键字">
            </div>
            
           
            
            <div class="form-group col-md-4">
                <select class="form-control" name="type">
                    <option value="0">资源类型</option>
                    <foreach name="reskind" key="k" item="v">
                    <option value="{$k}">{$v}</option>
                    </foreach>
                </select>
            </div>
            
            <div class="form-group col-md-4">
                    <select class="form-control" name="pro">
                        <option value="0">适用业务类型</option>
                        <foreach name="kinds" key="k" item="v">
                        <option value="{$k}">{$v}</option>
                        </foreach>
                    </select>
                </div>
            
            </form>
        </div>

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



                 $('#attendance_edito').click(function(){

                        var html = "<div style='color:red'>这是测试的弹窗</div>";
                        var html .="";
//                     $(this).dialog(html);
                        var button ="<input type='button' value='确定' /><input type='button' value='取消' />";
                        var win = new Window({

                            width : 400, //宽度
                            height : 300, //高度
                            title : '测试弹窗', //标题
                            content : html, //内容
                            isMask : false, //是否遮罩
                            buttons : button, //按钮
                            isDrag:true, //是否移动

                    })
                });

        </script>