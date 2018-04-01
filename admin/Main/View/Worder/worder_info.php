<include file="Index:header2" />
<!--评分插件-->
<!--<link rel="stylesheet" type="text/css" href="__HTML__/pingfen/css/normalize.css" />
<link rel="stylesheet" type="text/css" href="__HTML__/pingfen/css/default.css">
<link rel="stylesheet" type="text/css" href="__HTML__/pingfen/css/demo.css" />
<link href="http://cdn.bootcss.com/font-awesome/4.4.0/css/font-awesome.min.css" rel="stylesheet">
<script src="__HTML__/pingfen/js/jquery-2.1.1.min.js"></script>
<script src="__HTML__/pingfen/js/jquery.ratyli.js"></script>
<script src="__HTML__/pingfen/js/demo.js"></script>-->

<script type="text/javascript">
    window.onload = function(){
        $('#dept').hide();
    }
</script>

    <aside class="right-side">
        <!-- Content Header (Page header) -->
        <section class="content-header">
            <h1>工单详情</h1>
            <ol class="breadcrumb">
                <li><a href="{:U('Index/index')}"><i class="fa fa-home"></i> 首页</a></li>
                <li><a href="{:U('Worder/worder_list')}"><i class="fa fa-gift"></i> 工单管理</a></li>
            </ol>
        </section>

        <!-- Main content -->
        <section class="content">
        
            <div class="row">
                 <!-- right column -->
                <div class="col-md-12">
                     
                     
                     
                     <div class="box box-warning" style="margin-top:15px;">
                        <div class="box-header">
                            <h3 class="box-title">
                             工单信息
                            </h3>
                            <?php /*if($row['contract_id']){ */?><!--
                            <h3 class="box-title pull-right" style="font-weight:normal; color:#333333;"><span class="green">工单编号：{$row.contract_id}</span></h3>
                            --><?php /*} */?>
                        </div><!-- /.box-header -->
                        <div class="box-body">
                            <div class="content">
                            	<div class="form-group col-md-12">
                                    <h2 style="font-size:16px; color:#ff3300; border-bottom:2px solid #dedede; padding-bottom:10px;">工单信息</h2>
                                </div>
                                <div class="form-group col-md-12">
                                <table width="100%" id="font-14" rules="none" border="0" cellpadding="0" cellspacing="0" style="margin-top:-15px;">
                                    <tr>
                                        <td width="33.33%">工单名称：{$info.worder_title}</td>
                                        <td width="33.33%">工单类型 : {$info.type}</td>
                                        <td width="33.33%">工单发起时间：{$info.create_time|date='Y-m-d H:i:s',###}</td>
                                    </tr>
                                    <tr>
                                        <td colspan="3">工单内容：{$info.worder_content}</td>
                                    </tr>
                                    <tr>
                                        <td width="33.33%">工单发起者姓名：{$info.ini_user_name}</td>
                                        <td width="33.33%">工单发起者职务：{$info.ini_dept_name}</td>
                                        <if condition="$info.response_time neq 0">
                                            <td width="33.33%">工单响应时间：{$info.response_time|date='Y-m-d H:i:s',###}</td>
                                            <else />
                                            <td width="33.33%">工单响应时间：<span class="red">未响应</span></td>
                                        </if>
                                    </tr>
                                    <tr>
                                        <td width="33.33%">工单执行者姓名：{$info.exe_user_name}</td>
                                        <td width="33.33%">工单执行者职务：{$info.exe_dept_name}</td>
                                        <td width="33.33%">工单状态：{$info.sta}</td>
                                    </tr>
                                    <tr>
                                        <td width="33.33%">工单计划完成时间：{$info.plan_complete_time|date='Y-m-d H:i:s',###}</td>
                                        <if condition="$info.complete_time neq 0">
                                            <td width="33.33%">工单执行人完成时间：{$info.complete_time|date='Y-m-d H:i:s',###}</td>
                                            <else />
                                            <td width="33.33%">工单执行人完成时间：未完成</td>
                                        </if>
                                        <if condition="$info.ini_confirm_time neq 0">
                                            <td width="33.33%">工单发起人确认完成时间：{$info.ini_confirm_time|date='Y-m-d H:i:s',###}</td>
                                            <else />
                                            <td width="33.33%">工单发起人确认完成时间：未完成</td>
                                        </if>
                                    </tr>

                                    <tr>
                                        <if condition="$dept">
                                        <td width="33.33%">工单项名称：{$dept.pro_title}</td>
                                        <td width="33.33%">工单项类型：{$dept.n_type}</td>
                                        </if>
                                        <if condition="$info['assign_name']">
                                            <td width="33.33%">被指派者名字：{$info['assign_name']}</td>
                                        </if>
                                    </tr>

                                    <if condition="$info['urgent'] eq 1">
                                        <tr>
                                            <td width="33.33%">是否是加急工单: <span style="color: red">加急工单</span></td>
                                            <td colspan="2">工单加急原因: {$info.urgent_cause}</td>
                                        </tr>
                                    </if>

                                    <if condition="$info['exe_reply_content'] neq null">
                                        <tr><td colspan="3">工单执行人响应工单回复：{$info.exe_reply_content}</td></tr>
                                    </if>
                                    <if condition="$info['exe_complete_content'] neq null">
                                        <tr><td colspan="3">工单执行人完成工单回复：{$info.exe_complete_content}</td></tr>
                                    </if>
                                </table>
                                </div>
                                
                                <div class="form-group col-md-12">
                                    <h2 style="font-size:16px; color:#ff3300; border-bottom:2px solid #dedede; padding-bottom:10px;">工单相关文件</h2>
                                </div>
                                <div class="form-group col-md-12">
                                	<div id="showimglist">
                                        <foreach name="atts" key="k" item="v">
											<?php if(isimg($v['filepath'])){ ?>
                                            <div class="att-file">
                                                <a href="{$v.filepath}" target="_blank" style="margin-right:10px;"><div class="fileext"><?php echo isimg($v['filepath']); ?></div></a>
                                                <span class="att-file-name"  >{$v.filename}</span>
                                            </div>
                                            <?php }else{ ?>
<<<<<<< HEAD
                                                <div class="att-file">
                                                    <a href="{$v.filepath}" target="_blank" style="margin-right:10px;"><img src="{:thumb($v['filepath'],100,100)}" style="margin-right:15px; margin-top:15px;"></a>
                                                    <span class="satt-file"  >{$v.filename}</span>
                                                </div>
=======
                                            <div class="att-file">
											    <a href="{$v.filepath}" target="_blank" style="margin-right:10px;"><img src="{:thumb($v['filepath'],100,100)}" style="margin-right:15px; margin-top:15px;"></a>
                                                <span class="att-file-name"  >{$v.filename}</span>
                                            </div>
>>>>>>> 4e771563ac5bfe550fd88adbd9deadbca7c94a46
											<?php } ?>
                                        </foreach>
                                        <foreach name="exe_atts" key="k" item="v">
                                            <?php if(isimg($v['filepath'])){ ?>
                                                <div class="att-file">
                                                    <a href="{$v.filepath}" target="_blank" style="margin-right:10px;"><div class="fileext"><?php echo isimg($v['filepath']); ?></div></a>
                                                    <span class="att-file-name"  >{$v.filename}</span>
                                                </div>
                                            <?php }else{ ?>
                                                <div class="att-file">
                                                    <a href="{$v.filepath}" target="_blank" style="margin-right:10px;"><img src="{:thumb($v['filepath'],100,100)}" style="margin-right:15px; margin-top:15px;"></a>
                                                    <span class="att-file-name"  >{$v.filename}</span>
                                                </div>
                                            <?php } ?>
                                        </foreach>
                                    </div>
                                </div>

                            </div>
                            
                        </div><!-- /.box-body -->
                    </div><!-- /.box -->
                </div><!--/.col (right) -->
                
                
                <div class="col-md-12">
                    <?php if(rolemenu(array('Worder/assign_user')) and rolemenu(array('Worder/exe_worder')) and ($info['exe_user_id'] == cookie('userid') || $info['assign_id'] == cookie('userid')) ){ ?>
                        <?php /*if(rolemenu(array('Worder/assign_user'))){ */?>
                    <div class="box box-warning">
                        <div class="box-header">
                            <h3 class="box-title">工单确认信息</h3>
                            <h3 class="box-title pull-right" style="font-weight:normal; color:#333333;">
                                <?php  if($info['assign_name']){ ?>
                                    负责人：{$info.assign_name} &#12288;&#12288;
                                <?php  if(rolemenu(array('Worder/assign_user')) and($info['status']==0 || $info['status']==1) and ($info['assign_id'] == cookie('userid'))){ ?>
                                    <a href="javascript:;" onclick="javascript:assign('{:U('Worder/assign_user',array('id'=>$info['id']))}','指派工单负责人');" style="color:#09F;">再次指派负责人</a>
                                    <?php } ?>
                                <?php  }else{ ?>
                                    <?php  if(rolemenu(array('Worder/assign_user')) and($info['status']==0 || $info['status']==1 || $info['status']==-3) and $info['exe_user_id'] == cookie('userid')){ ?>
                                        <a href="javascript:;" onclick="javascript:assign('{:U('Worder/assign_user',array('id'=>$info['id']))}','指派工单负责人');" style="color:#09F;">指派负责人</a>
                                    <?php  }else{ ?>
                                        暂未指派负责人
                                    <?php  } ?>

                                <?php  } ?>
                            </h3>
                        </div>
                        <div class="box-body" style="padding-top:20px;" id="form_tip">

                                <?php if ($info['status']==0 || $info['status']==-3){ ?>
                                <form method="post" action="{:U('Worder/assign_user')}" name="myform" id="save_huikuan">
                                <input type="hidden" name="do_exe" value="1">
                                <input type="hidden" name="id" value="{$info.id}">
                                <input type="hidden" name="referer" value="<?php echo $_SERVER['HTTP_REFERER']; ?>" />

                                <div class="form-group col-md-12" style="margin-top:10px;">
                                    <div class="checkboxlist" id="applycheckbox" style="margin-top:10px;">
                                    <!--<input type="radio" name="info[status]" value="1" <?php /*if($row['status']==1){ echo 'checked';} */?> > 确认通过-->
                                    <input type="radio" name="info[status]" value="1" <?php if($row['status']==1){ echo 'checked';} ?> > 确认通过
                                    &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                                    <input type="radio" name="info[status]" value="-1" <?php if($row['status']==-1){ echo 'checked';} ?> > 拒绝该工单

                                    </div>
                                </div>

                                <if condition="in_array(cookie('roleid'),$ids)">
                                    <div class="form-group col-md-12">
                                        <div style="border-top:1px solid #dedede; margin-top:15px; padding-top:20px;">
                                            <label>工单类型</label>
                                            <select class="form-control" name="info[wd_id]" onchange="show_dept()" id="pro_tit">
                                                <option value="" disabled selected>选择工单类型</option>
                                                <foreach name="dept_list" item="v">
                                                    <option value="{$v.id}" <?php if($info['id']==$v['id']){ echo 'selected';} ?> >{$v.pro_title}</option>
                                                </foreach>
                                            </select>
                                        </div>
                                    </div>

                                    <div id="dept">
                                        <div class="form-group col-md-6">
                                            <label>工单类型：</label><input type="text" name="d_type" class="form-control" readonly />
                                        </div>

                                        <div class="form-group col-md-6">
                                            <label>完成所需时间：</label><input type="text" name="use_time" class="form-control" readonly />
                                        </div>
                                    </div>
                                </if>

                                <div class="form-group col-md-12"></div>
                                <div class="form-group col-md-12">
                                    <label>审核意见</label>
                                    <textarea class="form-control" name="info[exe_reply_content]" >{$row.exe_reply_content}</textarea>
                                </div>

                                <div class="form-group col-md-12"  style="margin-top:50px; padding-bottom:20px; text-align:center;">
                                    <button class="btn btn-success btn-lg">确认提交</button>
                                </div>
                                </form>
                                <?php }else{ ?>
                                    <div class="content" ><span style="padding:20px 0; float:left; clear:both; text-align:center; text-align:center; width:100%;">该工单已完成确认操作</span></div>
							<?php } ?>

                            <div class="form-group">&nbsp;</div>
                                   
                        </div>
                    </div><!-- /.box -->
                    <?php } ?>
                </div><!--/.col (right) -->


                <div class="col-md-12">
                    <?php if(rolemenu(array('Worder/assign_user')) and rolemenu(array('Worder/exe_worder'))  and ($info['exe_user_id'] == cookie('userid') || $info['assign_id'] == cookie('userid'))){ ?>
                    <?php /*if(rolemenu(array('Worder/assign_user'))){ */?>
                    <div class="box box-warning">
                        <div class="box-header">
                            <h3 class="box-title">工单执行信息</h3>
                        </div>
                        <div class="box-body" style="padding-top:20px;" id="form_tip">

                                <?php if ($info['status'] ==1){ ?>
                                <form method="post" action="{:U('Worder/exe_worder')}" name="myform" id="">
                                    <input type="hidden" name="dosubmint" value="1">
                                    <input type="hidden" name="id" value="{$info.id}">

                                    <div class="form-group col-md-12" style="margin-top:10px;">
                                        <div class="checkboxlist" id="applycheckbox" style="margin-top:10px;">
                                            <input type="checkbox" name="info[status]" value="2" <?php if($row['status']==2){ echo 'checked';} ?> > &#12288;执行完成

                                        </div>
                                    </div>

                                    <div class="form-group col-md-12"></div>
                                    <div class="form-group col-md-12">
                                        <label>执行意见</label>
                                        <textarea class="form-control" name="info[exe_complete_content]" >{$row.exe_complete_content}</textarea>
                                    </div>

                                    <div class="form-group col-md-12"></div>
                                    <div class="form-group col-md-12">
                                        <label>上传文件附件：</label>
                                        {:upload_m('uploadfile','files',$attr,'上传文件附件')}
                                    </div>

                                    <div class="form-group col-md-12"  style="margin-top:50px; padding-bottom:20px; text-align:center;">
                                        <button class="btn btn-success btn-lg">确认提交</button>
                                    </div>
                                </form>
                                <?php }elseif($info['status'] == 0){ ?>
                                    <div class="content" ><span style="padding:20px 0; float:left; clear:both; text-align:center; text-align:center; width:100%;">工单执行者尚未确认该工单</span></div>
                                <?php }else{ ?>
                                    <div class="content" ><span style="padding:20px 0; float:left; clear:both; text-align:center; text-align:center; width:100%;">该工单已执行</span></div>
                                <?php } ?>

                            <div class="form-group">&nbsp;</div>

                        </div>
                    </div><!-- /.box -->
                    <?php }
                    /*else{ */?><!--
                                <div class="content" ><span style="padding:20px 0; float:left; clear:both; text-align:center; text-align:center; width:100%;">尚无相关信息</span></div>
							--><?php /*} */?>
                </div><!--/.col (right) -->

                <div class="col-md-12">
                <?php /*if(rolemenu(array('Worder/new_worder'))){ */?>
                <?php if(rolemenu(array('Worder/new_worder')) and ($info['ini_user_id'] == cookie('userid'))){ ?>
                    <div class="box box-warning">
                        <div class="box-header">
                            <if condition="$info['status']==0">
                                <h3 class="box-title">撤销工单</h3>
                                <else />
                                <h3 class="box-title">工单发起人确认</h3>
                            </if>
                        </div>
                        <div class="box-body" style="padding-top:20px;" id="form_tip">

                            <?php if ($info['status']==0 ){ ?>
                                <form method="post" action="{:U('Worder/revoke')}" name="myform" >
                                    <input type="hidden" name="dosubmint" value="1">
                                    <input type="hidden" name="id" value="{$info.id}">

                                    <div class="form-group col-md-12" style="margin-top:10px;">
                                        <div class="checkboxlist" id="applycheckbox" style="margin-top:10px;">
                                            <input type="checkbox" name="info[status]" value="-2" > &#12288;撤销该工单

                                        </div>
                                    </div>

                                    <div class="form-group col-md-12"></div>

                                    <div class="form-group col-md-12"  style="margin-top:50px; padding-bottom:20px; text-align:center;">
                                        <button class="btn btn-success btn-lg">确认提交</button>
                                    </div>
                                </form>
                            <?php } ?>
                            <?php if ($info['status']==2 ){ ?>
                                <form method="post" action="{:U('Worder/audit_resure')}" name="myform" >
                                    <input type="hidden" name="dosubmint" value="1">
                                    <input type="hidden" name="id" value="{$info.id}">

                                    <div class="form-group col-md-12" style="margin-top:10px;">
                                        <div class="checkboxlist" id="applycheckbox" style="margin-top:10px;">
                                            <input type="radio" name="info[status]" value="3" > 该工单已执行完毕
                                            &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                                            <input type="radio" name="info[status]" value="-3" > 该工单未执行完毕
                                        </div>

                                        <div class="form-group">&nbsp;</div>

                                        <!--**********************pingfen start*********************-->
                                        <!--<div class="form-group col-md-12">
                                            <h2 style="font-size:16px; color:#ff3300; border-bottom:2px solid #dedede; padding-bottom:10px;">对该工单进行评分</h2>
                                        </div>-->

                                        <!--<div class="col-md-12 "  id="demo7">
                                            <label>请您对本次的工单服务进行评价 :</label>
                                            <span class="ratyli"></span>
                                        </div>-->
                                        <!--**********************pingfen end*********************-->

                                    </div>

                                    <div class="form-group col-md-12"  style="margin-top:50px; padding-bottom:20px; text-align:center;">
                                        <button class="btn btn-success btn-lg">确认提交</button>
                                    </div>
                                </form>
                            <?php }elseif($info['status']==3){ ?>
                                <div class="content" ><span style="padding:20px 0; float:left; clear:both; text-align:center; text-align:center; width:100%;">该工单已完成</span></div>
                            <?php } ?>

                            <div class="form-group">&nbsp;</div>

                        </div>
                    </div>
                <?php } ?>

                    <div class="box box-warning">
                        <div class="box-header">
                            <h3 class="box-title">工单操作记录</h3>
                        </div>
                        <div class="box-body">
                            <div class="content" style="padding:10px 30px;">
                                <table rules="none" border="0">
                                    <tr>
                                        <th style="border-bottom:2px solid #06E0F3; font-weight:bold;" width="160">操作时间</th>
                                        <th style="border-bottom:2px solid #06E0F3; font-weight:bold;" width="100">操作人</th>
                                        <th style="border-bottom:2px solid #06E0F3; font-weight:bold;" width="500">操作说明</th>
                                    </tr>
                                    <foreach name="record" item="v">
                                        <tr>
                                            <td style="padding:20px 0 0 0">{$v.time|date='Y-m-d H:i:s',###}</td>
                                            <td style="padding:20px 0 0 0">{$v.uname}</td>
                                            <td style="padding:20px 0 0 0">{$v.explain}</td>
                                        </tr>
                                    </foreach>
                                </table>
                            </div>
                        </div>
                    </div>

                </div>

            </div>   <!-- /.row -->
            
        </section><!-- /.content -->
        
    </aside><!-- /.right-side -->
			
  </div>
</div>

<include file="Index:footer2" />

<script type="text/javascript">
    //指派责任人
    function assign(url,title){
        art.dialog.open(url,{
            lock:true,
            title: title,
            width:800,
            height:500,
            okValue: '提交',
            id:'closeart',
            ok: function () {
                this.iframe.contentWindow.gosubmint();
                return false;
            },
            cancelValue:'取消',
            cancel: function () {
            }

        });
    }


    //获取工单项信息
    function show_dept(){
        var id = $("#pro_tit").val();
        $.ajax({
            type:"POST",
            url:"{:U('Ajax/dept')}",
            data:{id:id},
            success:function(msg){
                $("#dept").show();
                $("input[name='d_type']").val(msg.type_res);
                $("input[name='use_time']").val(msg.use_time+"个工作日");
            }
        })
    }
</script>
