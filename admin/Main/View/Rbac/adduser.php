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
                                    <div class="box-tools pull-right">
                                        <if condition="rolemenu(array('Salary/salary_add_department'))">
                                            <a href="{:U('Salary/salary_add_department')}" class="btn btn-sm btn-danger"><i class="fa fa-plus"></i> 添加部门</a>
                                        </if>
                                    </div>
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
                                        <label>员工编号</label>
                                        <input class="form-control employee_member"  type="text" name="info[employee_member]"  value="{$row.employee_member}"/>
                                    </div>

                                    <div class="form-group col-md-3">
                                        <label>手机号</label>
                                        <input class="form-control"  type="text" name="info[mobile]"  value="{$row.mobile}"/>
                                    </div>
                                   
                                    <!--<div class="form-group col-md-3">
                                        <label>邮箱</label>
                                        <input class="form-control"  type="text"  name="info[email]" value="{$row.email}"/>
                                    </div>-->
                                    
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
                                            <label>部门</label>
                                            <select  class="form-control department1"  name="departmentid" onchange="get_department()" required>
                                                <option value="0">请选择</option>
                                                <foreach name="department" item="d">
                                                <option value="{$d.id}"  id="{$d.letter}" <?php if ($row['departmentid'] == $d['id']) echo ' selected'; ?>>{$d.department}</option>
                                                </foreach>
                                            </select>
                                        </div>

                                    <div class="form-group col-md-3">
                                        <label>岗位</label>
                                        <select class="form-control" name="info[postid]" id="post1" onchange="get_department()" required>
                                            <foreach name="posts" key="k" item="v">
                                                <if condition="$v">
                                                <option value="{$k}" <?php if ($row['postid']==$k){ echo ' selected'; }?>>{$v}</option>
                                                </if>
                                            </foreach>
                                        </select>
                                    </div>

                                    <div class="form-group col-md-3">
                                        <label>职位</label>
                                        <select class="form-control" name="info[position_id]" required>
                                            <option value="0">请选择</option>
                                            <foreach name="position" key="k" item="v">
                                                <if condition="$v">
                                                    <option value="{$k}" <?php if ($row['position_id']==$k){ echo ' selected'; }?>>{$v}</option>
                                                </if>
                                            </foreach>
                                        </select>
                                    </div>
                                    
                                    <div class="form-group col-md-3">
                                        <label>员工状态</label>
                                        <select class="form-control" name="info[status]" onchange="show_expel($(this).val())">
                                        	<option <?php if($row['status']==0){ echo 'selected';}?> value="0">在职</option>
                                            <option <?php if($row['status']==1){ echo 'selected';}?> value="1">离职</option>
                                        </select>
                                    </div>
                                    
                                    <div class="form-group col-md-3">
                                        <label>入职时间</label>
                                        <input class="form-control inputdate"  type="text"  name="info[entry_time]" value="<if condition="$row['entry_time']">{$row.entry_time|date='Y-m-d',###}</if>"/>
                                    </div>

                                    <div class="form-group col-md-3" id="end_time">
                                        <!--<label>离职时间</label>
                                        <input class="form-control inputdate"  type="text"  name="end_time" value="<if condition="$row['end_time']">{$row.end_time|date='Y-m-d',###}</if>" />-->
                                    </div>

                                    <div class="form-group col-md-3" id="is_expel">
                                        <label>是否被本公司开除</label>
                                        <select class="form-control" name="info[expel]">
                                            <option value="">请选择</option>
                                            <option <?php if($row['expel']=='0'){ echo 'selected';}?> value="0">否</option>
                                            <option <?php if($row['expel']=='1'){ echo 'selected';}?> value="1">是</option>
                                        </select>
                                    </div>


                                    <div class="form-group col-md-3">
                                        <label>员工类别</label>
                                        <select class="form-control" name="info[formal]">
                                            <option value=" ">请选择</option>
                                            <option <?php if($row['formal']==1){ echo 'selected';}?> value="1">正式员工</option>
                                            <option <?php if($row['formal']==0){ echo 'selected';}?> value="0">试用员工</option>
                                            <option <?php if($row['formal']==3){ echo 'selected';}?> value="3">劳务员工</option>
                                            <option <?php if($row['formal']==4){ echo 'selected';}?> value="4">实习员工</option>
                                            </select>
                                    </div>
                                    <div class="form-group col-md-3">
                                        <label>档案所属</label>
                                        <select class="form-control" name="info[archives]">
                                            <option <?php if($row['archives']==0){ echo 'selected';}?> value="0">请选择</option>
                                            <option <?php if($row['archives']==1){ echo 'selected';}?> value="1">中心</option>
                                            <option <?php if($row['archives']==2){ echo 'selected';}?> value="2">科旅</option>
                                            <option <?php if($row['archives']==3){ echo 'selected';}?> value="3">科行</option>
                                            <option <?php if($row['archives']==4){ echo 'selected';}?> value="4">行管局</option>
                                        </select>
                                    </div>
                                    <div class="form-group col-md-3">
                                        <label>身份证号</label>
                                        <input class="form-control"  type="text" name="info[ID_number]"  value="{$row.ID_number}"/>
                                    </div>

                                    <div class="form-group col-md-3">
                                        <label>工资卡号</label>
                                        <input class="form-control"  type="text" name="info[Salary_card_number]"  value="{$row.Salary_card_number}"/>
                                    </div>

                                    <div class="form-group col-md-3">
                                        <label>所属队列</label>
                                        <select class="form-control" name="info[rank]" required>
                                            <option value="">请选择</option>
                                            <option <?php if($row['rank']=='00'){ echo 'selected';}?> value="00">0队列</option>
                                            <option <?php if($row['rank']=='01'){ echo 'selected';}?> value="01">1队列</option>
                                            <option <?php if($row['rank']=='02'){ echo 'selected';}?> value="02">2队列</option>
                                            <option <?php if($row['rank']=='03'){ echo 'selected';}?> value="03">3队列</option>
                                        </select>
                                    </div>
                                    
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
<script type="text/javascript">
    <?php if(!$row){ ?>
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
    <?php } ?>

    var end_time_html = `<label>离职时间</label> <input class="form-control inputdate"  type="text"  name="end_time" value="<?php echo $row['end_time']?date('Y-m-d',$row['end_time']):date('Y-m-d',NOW_TIME); ?>" required />`;
    $(function () {
        var status          = <?php echo $row['status']?$row['status']:0; ?>; //是否离职
        if (status == 1){ //离职
            $('#end_time').show();
            $('#end_time').html(end_time_html);
            $('#is_expel').show();
        }else{
            $('#end_time').html('');
            $('#end_time').hide();
            $('#is_expel').hide();
        }
    })

    function show_expel(stu) {
        if(stu == 1){ //离职
            $('#is_expel').show();
            $('#end_time').show();
            $('#end_time').html(end_time_html);
        }else{
            $('#is_expel').hide();
            $('#end_time').html('');
            $('#end_time').hide();
        }
    }


    function get_department() {
        var name = $('.department1 option:selected').attr("id");
        var post1 = $('#post1 option:selected').text();
        if(post1=="" || name==""){
            die;
        }else{
            $.ajax({
                url : "{:U('Ajax/department')}",
                type : "POST",
                async: true,
                data : {'name':name,'post':post1},
                dataType : "JSON",
                success : function(data) {
                    if(data.result == '1'){
                        $('.employee_member').val(data.msg);
                    }
                    if(data.result == '0'){
                        alert(data.msg);
                    }
                }
            });
        }
    }
	</script>
