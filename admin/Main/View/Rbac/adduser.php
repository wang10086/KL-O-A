<include file="Index:header2" />



            <aside class="right-side">
                <!-- Content Header (Page header) -->
                <section class="content-header">
                    <h1>用户管理</h1>
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
                            <form method="post" action="{:U('Rbac/adduser')}" name="myform" id="myform">   
                            <div class="box box-warning">
                                <div class="box-header">
                                    <h3 class="box-title">新增用户</h3>
                                </div><!-- /.box-header -->
                                <div class="box-body" id="tab_1">
                                    
                                    <input type="hidden" name="dosubmit" value="1" />
                                    <input type="hidden" name="referer" value="<?php echo $_SERVER['HTTP_REFERER']; ?>" />
                                    <if condition="$row"><input type="hidden" name="id" value="{$row.id}" /></if>
                                    <!-- text input -->
                                    
                                    
                                    
                                    
                                    
                                    
                                    
                                    <div class="form-group col-md-3" >
                                        <label>登录账号</label>
                                        <input class="form-control"  type="text" name="info[username]"  <?php if($row){ echo 'disabled'; }?> id="username" value="{$row.username}"/>
                                    </div>
                                    
                                    <div class="form-group col-md-3">
                                        <label>姓名</label>
                                        <input class="form-control"  type="text" name="info[nickname]"  value="{$row.nickname}"/>
                                    </div>
                                    
                                    <?php if(!$row){ ?>
                                    <div class="form-group col-md-3">
                                        <label>密码</label>
                                        <input class="form-control"  type="password" name="password_1" value="" id="password_1"/>
                                    </div>
                                    
                                    <div class="form-group col-md-3">
                                        <label>确认密码</label>
                                        <input class="form-control"  type="password" name="password_2" value="" id="password_2"/>
                                    </div>
                                    <?php } ?>
                                    
                                    <div class="form-group col-md-3">
                                        <label>手机号</label>
                                        <input class="form-control"  type="text" name="info[mobile]"  value="{$row.mobile}"/>
                                    </div>
                                   
                                    <div class="form-group col-md-3">
                                        <label>邮箱</label>
                                        <input class="form-control"  type="text"  name="info[email]" value="{$row.email}"/>
                                    </div>
                                    
                                    
                                    <if condition="rolemenu(array('Rbac/adduser'))">
                                    <div class="form-group col-md-3">
                                        <label>角色</label>
                                        <select  class="form-control"  name="info[roleid]" required>
                                            <option value="0">请选择</option>
                                            <foreach name="roles" item="v">
                                                
                                                <option value="{$v.id}" <?php if ($row['roleid']==$v['id']){ echo ' selected'; }?> >{$v.role_name}</option>
                                                
                                            </foreach>
                                        </select>
                                    </div>
                                    
                                    
                                    <div class="form-group col-md-3">
                                        <label>岗位</label>
                                        <select class="form-control" name="info[postid]">
                                            <option value="0" <?php if ($row['postid']==0){ echo ' selected'; }?>>请选择</option>
                                            <foreach name="posts" key="k" item="v">
                                            <option value="{$k}" <?php if ($row['postid']==$k){ echo ' selected'; }?>>{$v}</option>
                                            </foreach>
                                        </select>
                                    </div>
                                    
                                    <div class="form-group col-md-3">
                                        <label>账号类型</label>
                                        <select  class="form-control"  name="info[temp_user]" required>
                                            <option value="0" <?php if ($row && $row['temp_user'] == 0) echo ' selected'; ?>>专职</option>
                                            <option value="1" <?php if ($row && $row['temp_user'] == 1) echo ' selected'; ?>>兼职</option>
                                            <!-- 
                                            <option value="2" <?php if ($row && $row['temp_user'] == 2) echo ' selected'; ?>>临时</option>
                                             -->
                                        </select>
                                    </div>
                                    
                                    <div class="form-group col-md-3">
                                        <label>用户状态</label>
                                        <select class="form-control" name="info[status]">
                                        	<option <?php if($row['status']==0){ echo 'selected';}?> value="0">启用</option>
                                            <option <?php if($row['status']==1){ echo 'selected';}?> value="1">停用</option>
                                        </select>
                                    </div>
                                        
                                    </if>

                                    <div class="form-group">&nbsp;</div>
                                    <div class="form-group">&nbsp;</div>
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


<include file="Index:footer2" />
 <?php if(!$row){ ?>
<script type="text/javascript">
	$(document).ready(function(){
		$.formValidator.initConfig({autotip:true,formid:"myform",onerror:function(msg){}});
		$("#username").formValidator({onshow:"4-20位字符，可由英文、数字组成",onfocus:"4-20位字符，可由英文、数字组成"}).inputValidator({min:4,max:20,onerror:""}).regexValidator({regexp:"ps_username",datatype:"enum",onerror:"4-20位字符，可由中文、英文、数字组成"}).ajaxValidator({
			type : "get",
			url : "<?php echo U('Rbac/public_checkname_ajax'); ?>",
			datatype : "html",
			async:'false',
			success : function(data){
				if( data == 1 ) {
					return true;
				} else {
					return false;
				}
			},
			buttons: $("#dosubmit"),
			onerror : "该用户名不可用。",
			onwait : "请稍候..."
		});
		$("#email").formValidator({onshow:"请输入邮箱",onfocus:"请输入邮箱"}).inputValidator({min:4,max:20,onerror:"请输入邮箱"}).regexValidator({regexp:"email",datatype:"enum",onerror:"请输入邮箱"}).ajaxValidator({
			type : "get",
			url : "ucenter.php",
			data :"m=User&a=public_checkmail_ajax",
			datatype : "html",
			async:'false',
			success : function(data){
				if( data == "1" ) {
					return true;
				} else {
					return false;
				}
			},
			buttons: $("#dosubmit"),
			onerror : "该邮箱已被注册。",
			onwait : "请稍候..."
		});
		$("#password_1").formValidator({onshow:"6-20位字符（字符、数字、符号）组成",onfocus:"6-20位字符（字符、数字、符号）组成"}).inputValidator({min:6,max:20,onerror:"6-20位字符（字符、数字、符号）组成"});
		$("#password_2").formValidator({onshow:"请再次输入密码",onfocus:"请再次输入密码",oncorrect:"&nbsp;"}).inputValidator({min:1,onerror:"确认密码不能为空"}).compareValidator({desid:"password_1",operateor:"=",onerror:"与上面密码不一致，请重新输入"});

	});
	</script>
<?php } ?>