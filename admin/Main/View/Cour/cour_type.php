		<include file="Index:header" />
        
        <div class="wrapper row-offcanvas row-offcanvas-left">
           
            <include file="Index:menu" />

            <!-- Right side column. Contains the navbar and content of the page -->
            <aside class="right-side">
                <!-- Content Header (Page header) -->
                <section class="content-header">
                    <h1>课件类型</h1>
                    <ol class="breadcrumb">
                        <li><a href="{:U('Index/index')}"><i class="fa fa-home"></i> 首页</a></li>
                        <li><a href="{:U('Cour/cour_type')}">课件类型</a></li>
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
                                    <h3 class="box-title">课件类型列表</h3>
                                    <div class="pull-right box-tools">
                                        <if condition="rolemenu(array('Cour/courtype_edit'))">
                                        <button onClick="javascript:addtype('<?php echo U('Cour/courtype_edit'); ?>');" class="btn btn-danger btn-sm"><i class="fa fa-plus"></i></button>
                                        </if>
                                    </div>
                                </div><!-- /.box-header -->
                                <div class="box-body">
                                    <table class="table table-bordered dataTable fontmini" id="tablelist">
                                        <tr role="row" class="orders" >
                                        	<th class="sorting" data="type_id" width="80">类型编号</th>
                                        	<th class="sorting" data="type_name">类型名称</th>
                                            <th>课件数量</th>
                                            <if condition="rolemenu(array('Cour/cour_edit'))">
                                            <th width="60" class="taskOptions">编辑</th>
                                            </if> 
                                        </tr>
                                        <foreach name="datalist" item="row">
                                        
                                        <tr>
                                        	<td>{$row.type_id}</td>
                                            <td>{$row.type_name}</td>
                                            <td>{$row.cnt}</td>
                                            <if condition="rolemenu(array('Cour/cour_edit'))">
                                            <td class="taskOptions">
                                            <button onClick="javascript:addtype('{:U('Cour/courtype_edit',array('id'=>$row['type_id']))}');" title="修改" class="btn btn-info btn-smsm"><i class="fa fa-pencil"></i></button>
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
		
        
        <include file="Index:footer" />
        
		<script type="text/javascript">
        //打开新建任务box
        function addtype(obj) {
            art.dialog.open(obj,{
                lock:true,
                title: '添加类型',
                width:400,
                height:150,
                okValue: '提交',
                ok: function () {
                    this.iframe.contentWindow.gosubmint();
                    return false;
                },
                cancelValue:'取消',
                cancel: function () {
                }
            });	
        }
        </script>