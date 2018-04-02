<include file="Index:header2" />

            <aside class="right-side">
                <!-- Content Header (Page header) -->
                <section class="content-header">
                    <h1>新增部门工单项</h1>
                    <ol class="breadcrumb">
                        <li><a href="{:U('Index/index')}"><i class="fa fa-home"></i> 首页</a></li>
                        <li><a href="javascript:;"><i class="fa fa-gift"></i> 部门工单项</a></li>
                    </ol>
                </section>

                <!-- Main content -->
                <section class="content">
                <form method="post" action="{:U('Worder/dept_worder_add')}" name="myform" id="myform">
                <input type="hidden" name="dosubmint" value="1">
                    <div class="row">
                         <!-- right column -->
                        <div class="col-md-12">
                                  
                            
                            
                            <div class="box box-warning">
                                <div class="box-header">
                                    <h3 class="box-title">部门工单项</h3>
                                </div><!-- /.box-header -->
                                <div class="box-body">
                                    <div class="content">
                                    	
                                        <div class="form-group col-md-12">
                                            <label>工单项名称：</label><input type="text" name="info[pro_title]" class="form-control" />
                                        </div>
                                        
                                        <div class="form-group col-md-6">
                                            <label>工单受理单位：</label>
                                            <select class="form-control" name="info[dept_id]">
                                                <option value="" disabled selected>请选择受理组</option>
                                                <foreach name="group" item="v">
                                                    <option value="{$v.id}">{:tree_pad($v['level'])}{$v.role_name}</option>
                                                </foreach>
                                            </select>
                                        </div>
                                        
                                        <div class="form-group col-md-6">
                                            <label>工单类型：</label>
                                            <select  class="form-control"  name="info[type]" required>
                                                <foreach name="type" key="k" item="v">
                                                    <option value="{$k}">{$v}</option>
                                                </foreach>
                                            </select>
                                        </div>

                                        <div class="form-group col-md-6">
                                            <label>完成时间(单位:天)</label><input type="text" name="info[use_time]" placeholder="请输入整数" class="form-control" />
                                        </div>

                                        <div class="form-group col-md-6">
                                            <label>未及时完成处理方式：</label>
                                            <select  class="form-control"  name="info[unfinished]" required>
                                                <foreach name="unfinished" key="k" item="v">
                                                    <option value="{$k}">{$v}</option>
                                                </foreach>
                                            </select>
                                        </div>

                                        <div class="form-group col-md-12"></div>
                                        <div class="form-group col-md-12"></div>

                                    </div>
                                    
                                </div><!-- /.box-body -->
                            </div><!-- /.box -->
                            
                           
                            <div style="width:100%; text-align:center;">
                            <button type="submit" class="btn btn-info btn-lg" id="lrpd">新增工单项</button>
                            </div>
                        </div><!--/.col (right) -->
                    </div>   <!-- /.row -->
                    </form>
                </section><!-- /.content -->
                
            </aside><!-- /.right-side -->
			
  </div>
</div>

<include file="Index:footer2" />

