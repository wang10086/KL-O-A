<include file="Index:header2" />

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
        
            <div class="row"><!-- right column -->
                <div class="col-md-12">
                     <div class="box box-warning" style="margin-top:15px;">
                        <div class="box-header">
                            <h3 class="box-title">工单信息</h3>

                            <h3 class="box-title pull-right" style="font-weight:normal; color:#333333;">
                                <?php if ((C('RBAC_SUPER_ADMIN')==cookie('username') || cookie('userid') == 11 ) || (cookie('userid')==$info['ini_user_id'] && $info['upd_num']==0 )){ ?>
                                    <span  style=" border: solid 1px #00acd6; padding: 0 5px; border-radius: 5px; background-color: #00acd6; color: #ffffff; margin-left: 20px" onClick="change_worder_plan_time()" title="更改计划完成时间">更改计划完成时间</span>
                                <?php } ?>
                            </h3>
                        </div><!-- /.box-header -->
                        <div class="box-body">
                            <div class="content">
                                <div class="form-group col-md-12">
                                <table width="100%" id="font-14" rules="none" border="0" cellpadding="0" cellspacing="0" style="margin-top:-15px;">
                                    <tr>
                                        <td colspan="3">工单名称：{$info.worder_title}</td>
                                    </tr>
                                    <tr>
                                        <td width="33.33%">工单类型 : {$info.type}</td>
                                        <td width="33.33%">发起时间：{$info.create_time|date='Y-m-d H:i:s',###}</td>
                                        <if condition="$info['op_id']">
                                            <td width="33.33%">项目编号:{$info.op_id}</td>
                                        </if>
                                    </tr>
                                    <tr>
                                        <td width="33.33%">发起者姓名：{$info.ini_user_name}</td>
                                        <td width="33.33%">发起者职务：{$info.ini_dept_name}</td>
                                        <td width="33.33%">计划完成时间：{$info.plan_complete_time|date='Y-m-d H:i:s',###}</td>
                                    </tr>
                                    <tr>
                                        <td width="33.33%">执行者姓名：{$info.exe_user_name}</td>
                                        <td width="33.33%">执行部门：{$info.exe_dept_name}</td>
                                        <if condition="$info['assign_name']">
                                            <td width="33.33%">被指派者名字：{$info['assign_name']}</td>
                                        </if>
                                    </tr>
                                    <tr>
                                        <if condition="$dept">
                                            <td width="33.33%">工单项名称：{$dept.pro_title}</td>
                                            <td width="33.33%">工单项类型：{$dept.n_type}</td>
                                        </if>
                                    </tr>

                                    <if condition="in_array($info['urgent'],array(1,2))">
                                        <tr>
                                            <td width="33.33%">是否加急: {$info['urgent_stu']}</td>
                                            <td colspan="2">加急原因: {$info.urgent_cause}</td>
                                        </tr>
                                    </if>

                                    <if condition="$info['exe_reply_content'] neq null">
                                        <tr><td colspan="3">执行人响应工单回复：{$info.exe_reply_content}</td></tr>
                                    </if>
                                </table>
                                </div>

                                <div class="form-group col-md-12">
                                    <h2 style="font-size:16px; border-bottom:2px solid #dedede; padding-bottom:10px;">工单内容</h2>
                                </div>
                                <div class="form-group col-md-12">
                                    {$info.worder_content}
                                </div>

                                <div class="form-group col-md-12">
                                        <h2 class="brh3" style="font-size:16px; border-bottom:2px solid #dedede; padding-bottom:10px;">工单状态<span style="float:right; font-size: 14px">{$info.sta}</span></h2>
                                </div>
                                <div class="form-group col-md-12">
                                    <if condition="$info['exe_complete_content'] neq null">
                                        <tr><td colspan="3">执行人完成工单回复：{$info.exe_complete_content}</td></tr>
                                    </if>
                                </div>
                                
                                <div class="form-group col-md-12">
                                    <h2 style="font-size:16px; border-bottom:2px solid #dedede; padding-bottom:10px;">相关文件</h2>
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

                                                <div class="att-file">
                                                    <a href="{$v.filepath}" target="_blank" style="margin-right:10px;"><img src="{:thumb($v['filepath'],100,100)}" style="margin-right:15px; margin-top:15px;"></a>
                                                    <span class="satt-file"  >{$v.filename}</span>
                                                </div>

                                            <div class="att-file">
											    <a href="{$v.filepath}" target="_blank" style="margin-right:10px;"><img src="{:thumb($v['filepath'],100,100)}" style="margin-right:15px; margin-top:15px;"></a>
                                                <span class="att-file-name"  >{$v.filename}</span>
                                            </div>

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
                    <?php if(rolemenu(array('Worder/urgent')) and ($info['urgent'] == 1) ){ ?>
                    <div class="box box-warning">
                        <div class="box-header">
                            <h3 class="box-title">审核加急工单</h3>
                        </div>
                        <form method="post" action="{:U('Worder/urgent')}" name="myform1" >
                        <input type="hidden" name="dosubmint" value="1">
                        <input type="hidden" name="id" value="{$info.id}">
                        <div class="box-body">
                            <div class="form-group col-md-12" style="margin-top:10px; ">
                                <div class="checkboxlist" id="applycheckbox" style="margin-top:10px;">
                                    <input type="radio" name="info[urgent]" value="2" > 审核通过
                                    &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                                    <input type="radio" name="info[urgent]" value="0" > 审核不通过
                                </div>
                            </div>
                            <div class="form-group col-md-12"  style="margin-top:50px; padding-bottom:20px; text-align:center;">
                                <button class="btn btn-success btn-lg">确认提交</button>
                            </div>
                            <div class="form-group">&nbsp;</div>
                        </div>
                        </form>
                    </div>
                    <?php } ?>
                </div>

                <div class="col-md-12">
                    <?php if(rolemenu(array('Worder/assign_user')) and rolemenu(array('Worder/exe_worder')) and ($info['exe_user_id'] == cookie('userid') || $info['assign_id'] == cookie('userid')) ){ ?>
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
                                <form method="post" action="{:U('Worder/public_save')}" name="myform">
                                <input type="hidden" name="dosubmint" value="1">
                                <input type="hidden" name="savetype" value="1">
                                <input type="hidden" name="id" value="{$info.id}">
                                <input type="hidden" name="unfinished" value="">
                                <input type="hidden" name="referer" value="<?php echo $_SERVER['HTTP_REFERER']; ?>" />

                                <div class="form-group col-md-12" style="margin-top:10px;" id="check_worder">
                                    <div class="checkboxlist" id="applycheckbox" style="margin-top:10px;">
                                    <input type="radio" name="info[status]" value="1" <?php if($row['status']==1){ echo 'checked';} ?> > 确认通过
                                    &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                                    <input type="radio" name="info[status]" value="-1" <?php if($row['status']==-1){ echo 'checked';} ?> > 拒绝该工单

                                    </div>
                                </div>

                                <div class="dept">
                                    <div class="form-group col-md-12">
                                        <div style="border-top:1px solid #dedede; margin-top:15px; padding-top:20px;">
                                            <label>工单类型</label>
                                            <select class="form-control" name="info[wd_id]" onchange="show_dept()" id="pro_tit" required>
                                                <option value="" disabled selected>选择工单类型</option>
                                                <foreach name="dept_list" item="v">
                                                    <option value="{$v.id}" <?php if($info['id']==$v['id']){ echo 'selected';} ?> >{$v.pro_title}</option>
                                                </foreach>
                                            </select>
                                        </div>
                                    </div>

                                    <div class="form-group col-md-6">
                                        <label>工单类型：</label><input type="text" name="d_type" class="form-control" readonly />
                                    </div>

                                    <div class="form-group col-md-6">
                                        <label>完成所需时间：</label><input type="text" name="use_time" class="form-control" readonly />
                                    </div>
                                </div>

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
                    <?php } ?>
                </div><!--/.col (right) -->

                <div class="col-md-12">
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
                                <form method="post" action="{:U('Worder/audit_resure')}" name="myform" onsubmit="submitBefore()" >
                                    <input type="hidden" name="dosubmint" value="1">
                                    <input type="hidden" name="id" value="{$info.id}">
                                    <div class="form-group col-md-12" style="margin-top:10px;">
                                        <div class="checkboxlist" id="applycheckbox" style="margin-top:10px;">
                                            <input type="radio" name="info[status]" checked value="3" > 该工单已执行完毕
                                            &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                                            <input type="radio" name="info[status]" value="-3" > 该工单未执行完毕
                                        </div>
                                        <div class="form-group">&nbsp;</div>
                                        <!--评分信息-->
                                        <include file="score_edit" />
                                    </div>

                                    <div class="form-group col-md-12"  style="padding-bottom:20px; text-align:center;">
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

                <?php if ($info['status']==3 && $pingfen){ ?>
                    <div class="box box-warning">
                        <div class="box-header">
                            <h3 class="box-title">工单评分信息</h3>
                            <?php if ($pingfen && $pingfen != 'null'){ ?>
                            <h3 class="box-title pull-right" style="font-weight:normal; color:#333333;">被评分人：<span id="bpfr"></span></h3>
                            <?php } ?>
                        </div>
                        <div class="box-body">
                            <include file="score_read" />
                        </div>
                    </div>
                <?php } ?>

                    <div class="box box-warning">
                        <div class="box-header">
                            <h3 class="box-title">工单操作记录</h3>
                        </div>
                        <div class="box-body">
                            <include file="worder_recore" />
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
    $(function () {
        $('.dept').hide();
        $('#check_worder').find('ins').each(function (index,ele) {
            $(this).click(function () {
                var stu = $(this).prev('input').val();
                if(stu==1){
                    $('.dept').show();
                }else{
                    $('.dept').hide();
                    $('#pro_tit').val('');
                    $("input[name='d_type']").val('');
                    $("input[name='use_time']").val('');
                    $('#pro_tit').removeAttr('required')
                }
            })
        })
    })

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
                $("input[name='unfinished']").val(msg.unfinished);
            }
        })
    }

    //更改工单计划完成时间
    function change_worder_plan_time () {
        art.dialog.open('<?php echo U('Worder/public_change_plan_time',array('id'=>$info['id'])) ?>', {
            lock:true,
            id: 'change',
            title: '更改工单计划完成时间',
            width:600,
            height:300,
            okValue: '提交',
            ok: function () {
                this.iframe.contentWindow.gosubmint();
                location.reload();
                return false;
            },
            cancelValue:'取消',
            cancel: function () {
            }
        });
    }
</script>
