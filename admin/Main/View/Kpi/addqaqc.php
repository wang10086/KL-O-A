<include file="Index:header2" />



            <aside class="right-side">
                <!-- Content Header (Page header) -->
                <section class="content-header">
                    <h1>发布品质检查</h1>
                    <ol class="breadcrumb">
                        <li><a href="{:U('Index/index')}"><i class="fa fa-home"></i> 首页</a></li>
                        <li><a href="{:U('Kpi/qa')}"><i class="fa fa-gift"></i> 品质检查</a></li>
                    </ol>
                </section>

                <!-- Main content -->
                <section class="content">
                
                    <div class="row">
                         <!-- right column -->
                        <div class="col-md-12">
                            <!-- general form elements disabled -->
                            <form method="post" action="{:U('Kpi/addqa')}" name="myform" id="myform">
                			<input type="hidden" name="dosubmit" value="1">
                			<input type="hidden" name="editid" value="{$row.id}" >
                            <input type="hidden" name="referer" value="<?php echo $_SERVER['HTTP_REFERER']; ?>" />
                            <div class="box box-warning">
                                <div class="box-header">
                                    <h3 class="box-title">发布品质检查</h3>
                                    <div class="box-tools pull-right"> </div>
                                </div><!-- /.box-header -->
                                <div class="box-body">
                                    <div class="content">
                                        <div class="form-group box-float-12">
                                            <label>标题</label> 
                                            <input type="text" name="info[title]" value="{$row.title}" class="form-control" placeholder="如：关于对某某的某原因的奖惩" />
                                        </div>

                                        <div class="form-group box-float-4">
                                            <label>计入绩效月份</label> 
                                            <input type="text" name="info[month]"  value="{$row.month}"  class="form-control monthly"/>
                                        </div>

                                        <div class="form-group box-float-4">
                                            <label>记录属性</label>
                                            <select name="info[is_op]" class="form-control"  onchange="show_op($(this).val())" id="is_op" required>
                                                <option value="" selected disabled>==请选择==</option>
                                                <option value="0" <?php if ($row['is_op'] == 0) echo 'selected'; ?>>非团巡检</option>
                                                <option value="1" <?php if ($row['is_op'] == 1) echo 'selected'; ?>>团内巡检</option>
                                            </select>
                                        </div>

                                        <div class="form-group box-float-4" id="noop">
                                            <label>记录人员</label>
                                            <input type="text"   name="" value="{:session('nickname')}" class="form-control" readonly />
                                        </div>

                                        <div class="form-group box-float-4" id="isop">
                                            <label>团号</label>
                                            <input type="text" name="info[group_id]" value="{$row.group_id}" class="form-control" onblur="check_group_id($(this).val())" />
                                            <input type="hidden" name="info[op_id]" value="{$row.op_id}" id="op_id">
                                        </div>

                                        <div class="form-group box-float-4">
                                            <label>责任人员</label>
                                            <input type="text"   name="info[rp_user_name]" value="{$row.rp_user_name}" class="form-control selectuser" />
                                        </div>
                                        
                                        <div class="form-group box-float-4">
                                            <label>所在部门</label>
                                            <input type="text" name="info[rp_post]" value="{$row.rp_post}"  class="form-control" />
                                        </div>
                                        
                                        <div class="form-group box-float-4">
                                            <label>直接领导</label>
                                            <input type="text" name="info[ld_user_name]" value="{$row.ld_user_name}"  class="form-control selectuser" />
                                        </div>
                                        
                                        
                                        <div class="form-group box-float-4">
                                            <label>发现人员</label>
                                            <input type="text"   name="info[fd_user_name]" value="{$row.fd_user_name}" class="form-control selectuser" />
                                        </div>
                                        
                                        <div class="form-group box-float-4">
                                            <label>发现时间</label>
                                            <input type="text" name="info[fd_date]"  value="{$row.fd_date}"  class="form-control inputdate" />
                                        </div>
                                        
                                        <div class="form-group box-float-4">
                                            <label>陪同人员</label>
                                            <input type="text" name="info[ac_user_name]" value="{$row.ac_user_name}"  class="form-control selectuser" />
                                        </div>
                                        
                                        <div class="form-group box-float-12">
                                            <label>相关事实陈述及适用规定条款</label>
                                            <textarea class="form-control" style="height:90px;" name="info[chen]">{$row.chen}</textarea>
                                        </div>
                                        
                                        <div class="form-group box-float-12">
                                            <label>原因分析</label>
                                            <textarea class="form-control" style="height:90px;" name="info[reason]">{$row.reason}</textarea>
                                        </div>
                                        
                                        <div class="form-group box-float-12">
                                            <label>纠正措施及验证</label>
                                            <textarea class="form-control" style="height:90px;" name="info[verif]">{$row.verif}</textarea>
                                        </div>

                                        <div class="form-group box-float-12 mt20" id="suggest">
                                            <label>处理意见</label> &emsp;
                                            <input type="radio" name="info[suggest]" <?php if ($row['suggest']==1) echo "checked" ?> value="1"> &nbsp;建议撤销 &#12288;
                                            <input type="radio" name="info[suggest]" <?php if ($row['suggest']==2) echo "checked" ?> value="2"> &nbsp;建议观察 &#12288;
                                            <input type="radio" name="info[suggest]" <?php if ($row['suggest']==3) echo "checked" ?> value="3"> &nbsp;建议不合格处理
                                        </div>
	                            	</div>
                              </div><!-- /.box-body -->
                          
                              
                           </div><!-- /.box -->     
                           
                           
                           <div class="box box-warning">
                                <div class="box-header">
                                    <h3 class="box-title">奖惩实施</h3>
                                </div>
                                <div class="box-body">
                                    <div class="content">
                                    	<div class="content" style="padding-top:0px; margin-top:-20px;"> 
                                            <div id="qaqclist">
                                                <div class="userlist">
                                                    <div class="unitbox us">奖惩人员</div>
                                                    <div class="unitbox">奖惩类型</div>
                                                    <div class="unitbox">分数</div>
                                                    <div class="unitbox bz">备注</div>
                                                </div>
                                                <?php if($userlist){ ?>
                                                <foreach name="userlist" key="k" item="v">
                                                <div class="userlist" id="userlist_{$v.id}">
                                                    <span class="title"><?php echo $k+1; ?></span>
                                                   <input type="text" class="form-control selectuser us" name="qadata[888{$v.id}][user_name]" value="{$v.user_name}">
                                                    <select class="form-control" name="qadata[888{$v.id}][type]">
                                                    	<option value="0" <?php if($v['type']==0){ echo 'selected';} ?>>惩罚</option>
                                                        <option value="1" <?php if($v['type']==1){ echo 'selected';} ?>>奖励</option>
                                                    </select>
                                                    <input type="text" class="form-control" name="qadata[888{$v.id}][score]" value="{$v.score}">
                                                    <input type="text" class="form-control bz" name="qadata[888{$v.id}][remark]" value="{$v.remark}">
                                                    <a href="javascript:;" class="btn btn-danger btn-flat" onclick="delbox('userlist_{$v.id}')">删除</a>
                                                </div>
                                                </foreach>
                                                <?php }else{ ?>
                                                <div class="userlist" id="delone">
                                                    <span class="title">1</span>
                                                    <input type="text" class="form-control selectuser us" name="qadata[0][user_name]" value="">
                                                    <select class="form-control" name="qadata[0][type]">
                                                    	<option value="0">惩罚</option>
                                                        <option value="1">奖励</option>
                                                    </select>
                                                    <input type="text" class="form-control" name="qadata[0][score]" value="">
                                                    <input type="text" class="form-control bz" name="qadata[0][remark]" value="">
                                                    <a href="javascript:;" class="btn btn-danger btn-flat" onclick="delbox('delone')">删除</a>
                                                </div>
                                                <?php } ?>
                                            </div>
                                            <div id="qaqclist_val">1</div>
                                            <div class="form-group col-md-12" id="useraddbtns">
                                                <a href="javascript:;" class="btn btn-success btn-sm" onClick="add_qauser()"><i class="fa fa-fw fa-plus"></i> 新增人员</a> 
                                            </div>
                                            <div class="form-group">&nbsp;</div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                           
                           <!--<div class="box-footer clearfix">
                                <div style="width:100%; text-align:center;">
	                            <button type="submit" class="btn btn-info btn-lg" id="lrpd" >保存</button>
	                            </div>
                           </div>-->
                          </form>

                            <div id="formsbtn" style="padding-bottom:10px;">
                                <div class="content">
                                    <form method="post" action="{:U('Kpi/public_save')}" name="myform" id="appsubmint">
                                        <input type="hidden" name="dosubmint" value="1">
                                        <input type="hidden" name="savetype" value="6">
                                        <input type="hidden" name="id" value="{$row.id}">
                                    </form>

                                    <button type="button" onClick="submitBefore()" class="btn btn-info btn-lg" style=" padding-left:40px; padding-right:40px; margin-right:10px;">保存</button>
                                    <button type="button" onClick="submit_check()" class="btn btn-success btn-lg" style=" padding-left:40px; padding-right:40px; margin-left:10px;">提交</button>
                                </div>
                            </div>
                        </div><!--/.col (right) -->
                    </div>   <!-- /.row -->
                   
                </section><!-- /.content -->
                
            </aside><!-- /.right-side -->
			
  </div>
</div>

<include file="Index:footer2" />
<script type="text/javascript"> 

	$(document).ready(function(e) {
        selectuser();

        let group_id    = "<?php echo $row['group_id']?$row['group_id']:''; ?>";
        if (group_id){
            $('#isop').show();
            $('#noop').hide();
            $('#isop').attr('required',true);
        }else{
            $('#isop').hide();
            $('#noop').show();
            $('#isop').removeAttr('required');
            $('#op_id').val('');
        }
        check_from_inspect();
    });

    //检查是否是从不合格处理页面进入
    function check_from_inspect() {
        let group_id    = "<?php echo $group_id?$group_id:''; ?>";
        let op_id       = "<?php echo $opid?$opid:''; ?>"
        if(group_id){
            $('input[name="info[group_id]"]').val(group_id).attr('readonly',true);
            $('#op_id').val(op_id);
            $('#isop').show();
            $('#noop').hide();
            $('#isop').attr('required',true);
            $('#is_op').attr('readonly',true).attr('disabled',true);

            $('#is_op').find('option').each(function (index,ele) {
                let val = $(this).val();
                $(this).removeAttr('selected',false);
                if (val == 1){ $(this).attr('selected',true); }
            })
        };
    }
	
	function selectuser(){
		var keywords = <?php echo $userkey; ?>;	
		$('.selectuser').autocomplete(keywords, {
			 matchContains: true,
			 highlightItem: false,
			 formatItem: function(row, i, max, term) {
				 return '<span style=" display:none">'+row.pinyin+'</span>'+row.text;
			 },
			 formatResult: function(row) {
				 return row.user_name;
			 }
		}).result(function(event, item) {
		   
		});	
	}
	
	//新增奖惩人员
	function add_qauser(){
		var i = parseInt($('#qaqclist_val').text())+1;

		var html  = '<div class="userlist" id="qauser_'+i+'">';
		    html += '<span class="title"></span>';
			html += '<input type="text" class="form-control selectuser us" name="qadata['+i+'][user_name]" value="">';
            html += '<select class="form-control" name="qadata['+i+'][type]"><option value="0">惩罚</option><option value="1">奖励</option></select>';
            html += '<input type="text" class="form-control" name="qadata['+i+'][score]" value="">';
            html += '<input type="text" class="form-control bz" name="qadata['+i+'][remark]" value="">';
			html += '<a href="javascript:;" class="btn btn-danger btn-flat" onclick="delbox(\'qauser_'+i+'\')">删除</a></div>';
		
		$('#qaqclist').append(html);	
		$('#qaqclist_val').html(i);
		orderno();
		selectuser();
		laydate.render({
			elem: '.monthly',type: 'month',format: 'yyyyMM'
		});
	}
	
	//编号
	function orderno(){
		$('#qaqclist').find('.title').each(function(index, element) {
            $(this).text(parseInt(index)+1);
        });
	}
	
	//移除
	function delbox(obj){
		$('#'+obj).remove();
		orderno();
	}

	function show_op(res) {
        if (res == 1){
            $('#noop').hide();
            $('#isop').show();
            $('#isop').attr('required',true);
        }else{
            $('#isop').hide();
            $('#noop').show();
            $('#isop').removeAttr('required');
        }
    }

    function check_group_id(group_id) {
        if (group_id){
            $.ajax({
                type : "POST",
                url  : "<?php echo U('Ajax/get_opid') ?>",
                dataType : 'json',
                data : {group_id:group_id},
                success : function (opid) {
                    if (opid){
                       $('#op_id').val(opid);
                    }else{
                        art_show_msg('团号填写错误',3);
                    }
                },
                error : function(){
                    art_show_msg('连接失败',3);
                    return false;
                }
            });
        }else {
            art_show_msg('请输入如团号',3);
            return false;
        }
    }

    function submitBefore() {
        var title   = $('input[name="info[title]"]').val().trim();
        var isop    = $('select[name="info[is_op]"]').val();
        var opid    = $('#op_id').val();
        if (!title) { art_show_msg('标题不能为空',3); return false; }
        if (isop == 1 && !opid) {  art_show_msg('团号信息错误',3); return false;  }

        //建议处理方式，必选
        var suggest;
        var suggest1;
        $('#suggest').find('ins').each(function () {
            if ($(this).parent('div').attr("aria-checked") == 'true'){
                suggest     = $(this).prev('input[name="info[suggest]"]').val();
            }
            if ($(this).prev('input').attr('checked') == 'checked'){ //编辑时数据带入
                suggest1    = $(this).prev('input[name="info[suggest]"]').val();
            }
        })
        if (!suggest && !suggest1){ art_show_msg('请选择建议处理方式',3); return false; }

        $('#myform').submit();
    }

    function submit_check() {
        var id              = $('input[name="id"]').val();
        if (!id){            art_show_msg('保存后才可提交',3); return false;  }
        $('#appsubmint').submit();
    }
	
</script>	


     


