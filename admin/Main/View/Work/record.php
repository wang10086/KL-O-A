<include file="Index:header2" />

            <aside class="right-side">
                <!-- Content Header (Page header) -->
                <section class="content-header">
                    <h1>工作记录</h1>
                    <ol class="breadcrumb">
                        <li><a href="{:U('Index/index')}"><i class="fa fa-home"></i> 首页</a></li>
                        <li class="active">{$_action_}</li>
                    </ol>
                </section>

                <!-- Main content -->
                <section class="content">

                    <div class="row">
                        <div class="col-xs-12">
                            <div class="box">
                                <div class="box-header">
                                    <h3 class="box-title">工作记录</h3>
                                    <div class="box-tools pull-right">
                                    	 <a href="javascript:;" class="btn btn-info btn-sm" onclick="javascript:opensearch('searchtext',800,160);"><i class="fa fa-search"></i> 搜索</a>
                                         <a href="{:U('Work/addrecord')}" class="btn btn-sm btn-danger"><i class="fa fa-plus"></i> 新记录</a>
                                    </div>
                                </div><!-- /.box-header -->
                                <div class="box-body">
                                
                               <div class="btn-group" id="catfont">
                               		<a href="{:U('Work/record',array('com'=>0))}" class="btn <?php if($com==0){ echo 'btn-info';}else{ echo 'btn-default';} ?>">所有人的</a>
                                    <a href="{:U('Work/record',array('com'=>1))}" class="btn <?php if($com==1){ echo 'btn-info';}else{ echo 'btn-default';} ?>">关于我的</a>
                                    <a href="{:U('Work/record',array('com'=>2))}" class="btn <?php if($com==2){ echo 'btn-info';}else{ echo 'btn-default';} ?>">我记录的</a>
                                </div>
                                
                                <table class="table table-bordered dataTable fontmini" id="tablelist" >
                                    <tr role="row" class="orders" >
                                        <th class="sorting" width="40" data="id">编号</th>
                                        <th class="sorting" data="month" width="80">工作月份</th>
                                        <th class="sorting" data="user_name" width="80">工作人员</th>
                                        <th class="sorting" data="dept_name">所在部门</th>
                                        <th class="sorting" data="title">标题</th>
                                        <th class="sorting" data="type"  width="100">类型</th>
                                        <th class="sorting" data="rec_time" width="120">发布时间</th>
                                        <th class="sorting" data="rec_user_name" width="80">记录人员</th>
                                        <th class="sorting" data="status" width="80">状态</th>
                                        <th width="40" class="taskOptions">撤销</th>
                                    </tr>
                                    <foreach name="lists" item="row"> 
                                    <tr>
                                        <td>{$row.id}</td>
                                        <td>{$row.month}</td>
                                        <td>{$row.user_name}</td>
                                        <td>{$row.dept_name}</td>
                                        <td><a href="javascript:;" onClick="opencontent('{$row.content}')">{$row.title}</a></td>
                                        <td>{$row.kinds}</td>
                                        <td>{$row.rec_time}</td>
                                        <td>{$row.rec_user_name}</td>
                                        <td>{$row.status}</td>
                                        
                                        <td class="taskOptions">
                                        <button onClick="javascript:ConfirmDel('{:U('Work/revoke',array('recid'=>$row['id']))}','您确定撤销该记录吗？')" title="删除" class="btn btn-warning btn-smsm"><i class="fa fa-times"></i></button>
                                        </td>
                                    </tr>
                                    </foreach>					
                                </table>
                                </div><!-- /.box-body -->
                                 <div class="box-footer clearfix">
                                	<div class="pagestyle">{$pages}</div>
                                </div>
                            </div><!-- /.box -->

                        </div><!-- /.col -->
                     </div>

                </section><!-- /.content -->
            </aside><!-- /.right-side -->
            
            
            <div id="searchtext">
                <form action="" method="get" id="searchform">
                <input type="hidden" name="m" value="Main">
                <input type="hidden" name="c" value="Work">
                <input type="hidden" name="a" value="record">
                
                <div class="form-group col-md-4">
                    <input type="text" class="form-control" name="title" placeholder="标题">
                </div>
                
                
                
                <div class="form-group col-md-4">
                    <select class="form-control" name="type">
                        <option value="0">选择类型</option>
                        <foreach name="kinds" item="v" key="k">
                        <option value="{$k}">{$v}</option>
                        </foreach>
                    </select>
                </div>
                
                <div class="form-group col-md-4">
                    <select class="form-control" name="status">
                        <option value="-1">状态</option>
                        <option value="0">正常</option>
                        <option value="1">已撤销</option>
                    </select>
                </div>
                
                <div class="form-group col-md-4">
                    <input type="text" class="form-control" name="month" placeholder="工作月份">
                </div>
                
                <div class="form-group col-md-4">
                    <input type="text" class="form-control" name="uname" placeholder="工作人员">
                </div>
                
                <div class="form-group col-md-4">
                    <input type="text" class="form-control" name="rname" placeholder="记录人员">
                </div>
                
                
                </form>
            </div>

<include file="Index:footer2" />
