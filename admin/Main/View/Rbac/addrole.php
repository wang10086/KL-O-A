<include file="Index:header2" />



            <aside class="right-side">
                <!-- Content Header (Page header) -->
                <section class="content-header">
                    <h1>
                        组织结构和权限
                        <small>设置系统用户、部门和权限等</small>
                    </h1>
                    <ol class="breadcrumb">
                        <li><a href="{:U('Index/index')}"><i class="fa fa-home"></i> 首页</a></li>
                        <li><a href="{:U('Rbac/index')}"><i class="fa fa-gift"></i> 组织结构和权限</a></li>
                        <li class="active">新增/修改部门</li>
                    </ol>
                </section>

                <!-- Main content -->
                <section class="content">
                    <div class="row">
                         <!-- right column -->
                        <div class="col-md-12">
                            <!-- general form elements disabled -->
                            <form role="form" method="post" action="{:U('Rbac/addrole')}" name="myform" id="myform">        
                            <div class="box box-warning">
                                <div class="box-header">
                                    <h3 class="box-title">新增/修改角色</h3>
                                </div><!-- /.box-header -->
                                <div class="box-body">
                                    
                                    <input type="hidden" name="dosubmit" value="1" />
                                    <input type="hidden" name="referer" value="<?php echo $_SERVER['HTTP_REFERER']; ?>" />
                                    <input type="hidden" name="info[isend]" value="1">
                                    <if condition="$row"><input type="hidden" name="id" value="{$row.id}" /></if>
                                    <!-- text input -->
                                    
                                    <div class="form-group col-md-6">
                                        <label>上级角色</label>
                                        <select class="form-control" name="info[pid]">
                                        	<foreach name="rolelist" key="k" item="v">
                                        	<option value="{$v.id}" <?php if($v['id']==$row['pid']){ echo 'selected';} ?> >{$v.role_name}</option>
                                            </foreach>
                                        </select>
                                        
                                    </div>
                                    
                                    
                                    <div class="form-group col-md-6">
                                        <label>角色标识</label>
                                        <input type="text" name="info[name]" id="rolename" value="{$row.name}"  class="form-control" />
                                    </div>
                                    <div class="form-group col-md-6">
                                        <label>角色名称</label>
                                        <input type="text" name="info[role_name]" value="{$row.role_name}" class="form-control" />
                                    </div>
                                    
                                    <!--
                                    <div class="form-group col-md-6">
                                        <label>是否是职位</label>
                                        <select  class="form-control"  name="info[isend]" required>
                                        
                                            <option value="1" <?php if ($row !== false and $row['isend']==1) echo ' selected';?>>是</option>
                                            <option value="0" <?php if ($row === false or $row['isend'] == 0) echo ' selected';?>>否</option>
                                        </select>
                                        
                                    </div>
                                    -->
                                    <div class="form-group col-md-6">
                                        <label>状态</label>
                                        <select  class="form-control"  name="info[status]" required>
                                        
                                            <option value="1" <?php if ($row === false or $row['status']==1) echo ' selected';?>>启用</option>
                                            <option value="0" <?php if ($row !== false and $row['status'] == 0) echo ' selected';?>>停用</option>
                                        </select>
                                    </div>
                                    
                                    <div class="form-group col-md-6">
                                        &nbsp;
                                    </div>
                                    
                                    
                                    <div class="form-group">&nbsp;</div>
                                        

                                </div><!-- /.box-body -->
                            </div><!-- /.box -->
                            <div id="formsbtn">
                            	<button type="submit" class="btn btn-info btn-lg" id="lrpd">保存</button>
                            </div>
                             </form>
                        </div><!--/.col (right) -->
                    </div>   <!-- /.row -->
                </section><!-- /.content -->
            </aside><!-- /.right-side -->

  </div>
</div>

<script type="text/javascript"> 

	$().ready(function(e) {
		$('#myform').validate();
	});
</script>	
            
<include file="Index:footer2" />