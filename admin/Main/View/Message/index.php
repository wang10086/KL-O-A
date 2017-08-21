		<include file="Index:header2" />
        
        <div class="wrapper row-offcanvas row-offcanvas-left">
           
            <include file="Index:menu" />

            <!-- Right side column. Contains the navbar and content of the page -->
            <aside class="right-side">
                <!-- Content Header (Page header) -->
                <section class="content-header">
                    <h1>系统消息</h1>
                    <ol class="breadcrumb">
                        <li><a href="{:U('Index/index')}"><i class="fa fa-home"></i> 首页</a></li>
                        <li><a href="{:U('Message/index')}">系统消息</a></li>
                    </ol>
                </section>

                <!-- Main content -->
                <section class="content">

                   

                    <!-- Main row -->
                    <div class="row">
                        <!-- Left col -->
                         <div class="col-md-12">
                            <div class="box">
                                <div class="box-header">
                                    <h3 class="box-title">系统消息</h3>
                                    <div class="pull-right box-tools">
                                        <button class="btn btn-info btn-sm" onclick="javascript:opensearch('searchtext',300,80);"><i class="fa fa-search"></i></button>
                                    </div>
                                </div><!-- /.box-header -->
                                <div class="box-body">
                                    <div class="btn-group" id="catfont">
                                        <a href="{:U('Message/index',array('type'=>0))}" class="btn <?php if($type==0){ echo 'btn-info';}else{ echo 'btn-default'; } ?>">未读</a>
                                        <a href="{:U('Message/index',array('type'=>1))}" class="btn <?php if($type==1){ echo 'btn-info';}else{ echo 'btn-default'; } ?>">已读</a>
                                    </div>
                                             
                                    <table class="table table-bordered dataTable fontmini" id="tablelist" style="margin-top:10px;">
                                        <tr role="row" class="orders" >
                                            <th class="sorting" data="m.id" width="60">编号</th>
                                            <th class="sorting" data="m.send_user" width="120">发送</th>
                                            <th class="sorting" data="m.title">标题</th>
                                            <th class="sorting" data="r.read_time" width="120">状态</th>
                                            <th class="sorting" data="m.send_time" width="120">发送时间</th>
                                            <th width="60" class="taskOptions">查看</th>
                                            <th width="60" class="taskOptions">删除</th>
                                            <!--
                                            <if condition="rolemenu('Delete/pro')">
                                            <th width="60" class="taskOptions">删除</th>
                                            </if>
                                            -->
                                        </tr>
                                        <foreach name="datalist" item="row">
                                        <tr>
                                        	 
                                            <td>{$row.id}</td>
                                            <td>{$row.send_user}</td>
                                            <td>{$row.title}</td>
                                            <td><?php if($row['read_time']){ echo '已读';}else{ echo '<span class="red">未读</span>';} ?></td>
                                            <td><if condition="$row['send_time']">{$row.send_time|date='y-m-d H:i',###}</if></td>
                                            
                                            <td class="taskOptions">
                                            <button onClick="msg_info({$row.id})" title="查看" class="btn btn-success btn-smsm"><i class="fa fa-calendar"></i></button>
                                            </td>
                                           
                                            <td class="taskOptions">
                                            <button onClick="javascript:ConfirmDel('{:U('Message/del',array('id'=>$row['id']))}');" title="删除" class="btn btn-warning btn-smsm"><i class="fa fa-times"></i></button>
                                            </td>
                                        </tr>
                                        </foreach>		
                                        
                                    </table>
                                </div><!-- /.box-body -->
                                <div class="box-footer clearfix">
                                	<div class="pagestyle">{$pages}</div>
                                </div>
                            </div><!-- /.box -->

                            
                        </div><!-- right col -->
                    </div><!-- /.row (main row) -->

                </section><!-- /.content -->
            </aside><!-- /.right-side -->
        </div><!-- ./wrapper -->

        <!-- add new calendar event modal -->
		
        <div id="searchtext">
            <form action="" method="get" id="searchform">
            <input type="hidden" name="m" value="Main">
            <input type="hidden" name="c" value="Pro">
            <input type="hidden" name="a" value="index">
            
            <div class="form-group">
                <input type="text" name="key" placeholder="关键字" class="form-control">
            </div>
            
            </form>
        </div>

        <include file="footer2" />
        
        