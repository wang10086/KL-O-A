<include file="Index:header2" />

            <aside class="right-side">
                <!-- Content Header (Page header) -->
                <section class="content-header">
                    <h1>营员管理</h1>
                    <ol class="breadcrumb">
                        <li><a href="{:U('Index/index')}"><i class="fa fa-home"></i> 首页</a></li>
                        <li><a href="{:U('Customer/IC')}"><i class="fa fa-gift"></i> 营员管理</a></li>
                    </ol>
                </section>

                <!-- Main content -->
                <section class="content">
                <form method="post" action="{:U('Customer/IC_edit')}" name="myform" id="myform">
                <input type="hidden" name="dosubmint" value="1">
                <input type="hidden" name="ic_id" value="{$ic.id}">
                <input type="hidden" name="referer" value="<?php echo $_SERVER['HTTP_REFERER']; ?>" />
                    <div class="row">
                         <!-- right column -->
                        <div class="col-md-12">
                                  
                            
                            
                            <div class="box box-warning">
                                <div class="box-header">
                                    <h3 class="box-title">营员管理</h3>
                                </div><!-- /.box-header -->
                                <div class="box-body">
                                    <div class="content">
                                    	
                                        <div class="form-group col-md-4">
                                            <label>姓名：</label><input type="text" name="info[name]" class="form-control" value="{$ic.name}"/>
                                        </div>
                                        
                                        
                                        <div class="form-group col-md-4">
                                            <label>性别：</label>
                                            <select  class="form-control"  name="info[sex]">
                                            	<option value="">请选择</option>
                                            	<option value="男" <?php if($ic['sex']=='男'){ echo 'selected';} ?> >男</option>
                                                <option value="女" <?php if($ic['sex']=='女'){ echo 'selected';} ?>>女</option>
                                            </select> 
                                        </div>
                                        
                                        <div class="form-group col-md-4">
                                            <label>身份证号：</label><input type="text" name="info[number]" class="form-control" value="{$ic.number}"/>
                                        </div>
                                        
                                        <div class="form-group col-md-4">
                                            <label>手机号码：</label><input type="text" name="info[mobile]"  class="form-control" value="{$ic.mobile}"/>
                                        </div>
                                        
                                        <div class="form-group col-md-4">
                                            <label>家长姓名：</label><input type="text" name="info[ecname]"  class="form-control" value="{$ic.ecname}"/>
                                        </div>
                                        
                                        <div class="form-group col-md-4">
                                            <label>家长电话：</label><input type="text" name="info[ecmobile]"  class="form-control" value="{$ic.ecmobile}"/>
                                        </div>
          
                                        <div class="form-group col-md-12">
                                            <label>单位：</label><textarea class="form-control"  name="info[remark]">{$ic.remark}</textarea>
                                        </div>
                                        
                                       
                                    </div>
                                    
                                </div><!-- /.box-body -->
                            </div><!-- /.box -->
                            
                            
                            <div class="box box-warning">
                                <div class="box-header">
                                    <h3 class="box-title">参营记录</h3>
                                </div><!-- /.box-header -->
                                <div class="box-body">
                                    <div class="content">
                                    	<div class="form-group col-md-12">
                                        <table class="table table-striped">
                                            <thead>
                                                <tr role="row">
                                                	<th>团号</th>
                                                    <th>项目名称</th>
                                                    <th>单人毛利</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <foreach name="hezuo" item="v">
                                                <tr>
                                                    <td>{$v.group_id}</td>
                                                    <td>{$v.project}</td>
                                                    <td>&yen;{$v.renjunmaoli}</td>
                                                </tr>
                                                </foreach>
                                            </tbody>
                                        </table>
                                        
                                        </div>
                                    </div>
                                </div>
                            </div>
       
                            
                            <div style="width:100%; text-align:center;">
                            <button type="submit" class="btn btn-info btn-lg" id="lrpd">保存</button>
                            </div>
                        </div><!--/.col (right) -->
                    </div>   <!-- /.row -->
                    </form>
                </section><!-- /.content -->
                
            </aside><!-- /.right-side -->
			
  </div>
</div>

<include file="Index:footer2" />
<script type="text/javascript"> 

	
</script>