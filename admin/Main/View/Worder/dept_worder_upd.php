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
                <form method="post" action="{:U('Worder/dept_worder_upd')}" name="myform" id="myform">
                <input type="hidden" name="dosubmint" value="1">
                <input type="hidden" name="id" value="{$info['id']}">
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
                                            <label>工单项名称：</label><input type="text" name="info[pro_title]" value="{$info[pro_title]}" class="form-control" />
                                        </div>
                                        
                                        <div class="form-group col-md-6">
                                            <label>工单受理单位：</label>
                                            <select class="form-control" name="info[dept_id]">
                                                <foreach name="group" item="v">
                                                    <option value="{$v.id}" <?php if($v['id'] == $info['dept_id']){echo 'selected';} ?>>{:tree_pad($v['level'])}{$v.role_name}</option>
                                                </foreach>
                                            </select>
                                        </div>
                                        
                                        <div class="form-group col-md-6">
                                            <label>工单类型：</label>
                                            <select  class="form-control"  name="info[type]" required>
                                                <foreach name="type" key="k" item="v">
                                                    <option value="{$k}" <?php if($k == $info['type']){ echo 'selected';} ?>>{$v}</option>
                                                </foreach>
                                            </select>
                                        </div>

                                        <div class="form-group col-md-6">
                                            <label>完成时间(单位:天)</label><input type="text" name="info[use_time]" value="{$info['use_time']}" placeholder="请输入整数" class="form-control" />
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

