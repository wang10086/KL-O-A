<include file="Index:header2" />



            <aside class="right-side">
                <!-- Content Header (Page header) -->
                <section class="content-header">
                    <h1>修改密码</h1>
                    <ol class="breadcrumb">
                        <li><a href="{:U('Index/index')}"><i class="fa fa-home"></i> 首页</a></li>
                        <li><a href="{:U('Rbac/index')}"><i class="fa fa-gift"></i> 用户管理</a></li>
                        <li class="active">用户管理</li>
                    </ol>
                </section>

                <!-- Main content -->
                <section class="content">
                    <div class="row">
                         <!-- right column -->
                        <div class="col-md-12">
                            <!-- general form elements disabled -->
                            <div class="box box-warning">
                                <div class="box-header">
                                    <h3 class="box-title">新增用户</h3>
                                </div><!-- /.box-header -->
                                
                                <div class="box-body">
                                    <form role="form" method="post" action="{:U('Rbac/password')}" name="myform" id="myform" >
                                        <input type="hidden" name="dosubmit" value="1" />
                                        <input type="hidden" name="id" value="{$row.id}" />
                                        <input type="hidden" name="referer" value="<?php echo $_SERVER['HTTP_REFERER']; ?>" />
                                        <!-- text input -->
                                        <div class="form-group col-md-12">
                                            <label>用户名</label>
                                            <input class="form-control"  type="text" name="info[username]"  disabled value="{$row.username}"/>
                                        </div>
                                        
                                        <div class="form-group col-md-6">
                                            <label>密码</label>
                                            <input class="form-control"  type="password" name="password_1" value="" id="password_1"/>
                                        </div>
                                        <div class="form-group col-md-6">
                                            <label>确认密码</label>
                                            <input class="form-control"  type="password" name="password_2" value="" id="password_2"/>
                                        </div>
                                        
                                        
                                        <div class="form-group col-md-12">
                                        	<button type="submit" class="btn btn-success">保存</button>
                                        </div>
                                        
                                        <div class="form-group">&nbsp;</div>
                                        

                                    </form>
                                </div><!-- /.box-body -->
                                
                            </div><!-- /.box -->
                        </div><!--/.col (right) -->
                    </div>   <!-- /.row -->
                </section><!-- /.content -->
            </aside><!-- /.right-side -->

  </div>
</div>


<include file="Index:footer2" />

<script type="text/javascript">
	$(document).ready(function(){
		$.formValidator.initConfig({autotip:true,formid:"myform",onerror:function(msg){}});
		$("#password_1").formValidator({onshow:"6-20位字符（字符、数字、符号）组成",onfocus:"6-20位字符（字符、数字、符号）组成"}).inputValidator({min:6,max:20,onerror:"6-20位字符（字符、数字、符号）组成"});
		$("#password_2").formValidator({onshow:"请再次输入密码",onfocus:"请再次输入密码",oncorrect:"&nbsp;"}).inputValidator({min:1,onerror:"确认密码不能为空"}).compareValidator({desid:"password_1",operateor:"=",onerror:"与上面密码不一致，请重新输入"});

	});
	</script>
            