		<include file="Index:header" />
        
        <div class="wrapper row-offcanvas row-offcanvas-left">
           
            <include file="Index:menu" />

            <!-- Right side column. Contains the navbar and content of the page -->
            <aside class="right-side">
                <!-- Content Header (Page header) -->
                <section class="content-header">
                    <h1>培训记录</h1>
                    <ol class="breadcrumb">
                        <li><a href="{:U('Index/index')}"><i class="fa fa-home"></i> 首页</a></li>
                        <li><a href="{:U('Cour/pptlist')}">培训记录</a></li>
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
                                    <h3 class="box-title">培训记录</h3>
                                    <div class="pull-right box-tools">
                                        <button class="btn btn-info btn-sm" onclick="javascript:opensearch('searchtext',500,160);"><i class="fa fa-search"></i> 搜索</button>
                                        <button onClick="javascript:window.location.href='{:U('Cour/ppt_add')}';" class="btn btn-danger btn-sm"><i class="fa fa-plus"></i> 新增记录</button>
                                    </div>
                                </div><!-- /.box-header -->
                                <div class="box-body">
                                    <table class="table table-bordered dataTable fontmini" id="tablelist">
                                        <tr role="row" class="orders" >
                                        	<th class="sorting" data="id" width="60">编号</th>
                                            <th class="sorting" data="ppt_title">标题</th>
                                            <th class="sorting" data="lecture_date" width="100">培训日期</th>
                                            <th class="sorting" data="lecturer_uname" width="100">培训者</th>
                                            
                                            <th class="sorting" data="create_time" width="110">创建时间</th>
                                            <if condition="rolemenu(array('Cour/ppt_edit'))">
                                            <th width="60" class="taskOptions">编辑</th>
                                            </if> 
                                            <if condition="rolemenu(array('Cour/delppt'))">
                                            <th width="60" class="taskOptions">删除</th>
                                            </if> 
                                        </tr>
                                        <foreach name="datalist" item="row">
                                        
                                        <tr>
                                            <td>{$row.id}</td>
                                            <!--<td><a href="{:U('Cour/info',array('id'=>$row['id']))}">{$row.ppt_title}</a></td>-->
                                            <td><a href="javascript:;">{$row.ppt_title}</a></td>
                                            <td><?php echo $row['lecture_date'] ? date('Y-m-d',$row['lecture_date']) : ''; ?></td>
                                            <td>{$row.lecturer_uname}</td>
                                            <td><if condition="$row['create_time']">{$row.create_time|date='y-m-d H:i',###}</if></td>
                                            <if condition="rolemenu(array('Cour/ppt_edit'))">
                                            <td class="taskOptions">
                                            <a href="{:U('Cour/ppt_edit',array('id'=>$row['id']))}" title="修改" class="btn btn-info btn-smsm"><i class="fa fa-pencil"></i></a>
                                            </td>
                                            </if>
                                            
                                            <if condition="rolemenu(array('Cour/delppt'))">
                                            <td class="taskOptions">
                                            <a href="JavaScript:;"  onClick="javascript:ConfirmDel('{:U('Cour/delppt',array('id'=>$row['id']))}');" title="删除" class="btn btn-danger btn-smsm"><i class="fa fa-times"></i></a>
                                            </td>
                                            </if>
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
            <input type="hidden" name="c" value="Cour">
            <input type="hidden" name="a" value="pptlist">
            
            <div class="form-group col-md-12">
                 <input type="text" name="keywords" placeholder="关键字" class="form-control">
            </div>
            
            </form>
        </div>

        <include file="Index:footer" />
        
        